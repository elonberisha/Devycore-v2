<?php
namespace Devycore;

/**
 * Authentication Class
 * Token-based authentication with role-based access control
 */
class Auth {
    private Database $db;
    private int $tokenExpiryHours;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->tokenExpiryHours = (int)($_ENV['TOKEN_EXPIRY_HOURS'] ?? 24);
    }

    /**
     * Login user and generate token
     * @param string $username
     * @param string $password
     * @return array|false ['token' => string, 'user' => array] or false
     */
    public function login(string $username, string $password): array|false {
        // Find user
        $user = $this->db->fetchOne(
            "SELECT * FROM users WHERE username = ? AND is_active = 1",
            [$username]
        );

        if (!$user) {
            return false;
        }

        // Verify password
        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }

        // Generate token
        $token = bin2hex(random_bytes(32)); // 64 character hex string
        $expiresAt = date('Y-m-d H:i:s', time() + ($this->tokenExpiryHours * 3600));

        // Store token
        $this->db->query(
            "INSERT INTO auth_tokens (user_id, token, expires_at) VALUES (?, ?, ?)",
            [$user['id'], $token, $expiresAt]
        );

        return [
            'token' => $token,
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ]
        ];
    }

    /**
     * Validate token and return user info
     * @param string $token
     * @return array|false User info or false
     */
    public function validateToken(string $token): array|false {
        $result = $this->db->fetchOne(
            "SELECT u.*, t.expires_at
             FROM auth_tokens t
             JOIN users u ON t.user_id = u.id
             WHERE t.token = ? AND t.expires_at > NOW() AND u.is_active = 1",
            [$token]
        );

        if (!$result) {
            return false;
        }

        return [
            'id' => $result['id'],
            'username' => $result['username'],
            'role' => $result['role']
        ];
    }

    /**
     * Logout user (delete token)
     * @param string $token
     * @return bool
     */
    public function logout(string $token): bool {
        $affected = $this->db->execute(
            "DELETE FROM auth_tokens WHERE token = ?",
            [$token]
        );
        return $affected > 0;
    }

    /**
     * Create new user (super role only)
     * @param string $username
     * @param string $password
     * @param string $role
     * @return int|false User ID or false
     */
    public function createUser(string $username, string $password, string $role = 'admin'): int|false {
        // Validate role
        if (!in_array($role, ['super', 'admin'])) {
            return false;
        }

        // Check if user exists
        $existing = $this->db->fetchOne(
            "SELECT id FROM users WHERE username = ?",
            [$username]
        );

        if ($existing) {
            return false;
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        // Insert user
        try {
            $userId = $this->db->insert(
                "INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)",
                [$username, $passwordHash, $role]
            );
            return (int)$userId;
        } catch (\Exception $e) {
            error_log("Failed to create user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Change user password
     * @param int $userId
     * @param string $currentPassword
     * @param string $newPassword
     * @return bool
     */
    public function changePassword(int $userId, string $currentPassword, string $newPassword): bool {
        // Get current hash
        $user = $this->db->fetchOne(
            "SELECT password_hash FROM users WHERE id = ?",
            [$userId]
        );

        if (!$user) {
            return false;
        }

        // Verify current password
        if (!password_verify($currentPassword, $user['password_hash'])) {
            return false;
        }

        // Hash new password
        $newHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);

        // Update password
        $affected = $this->db->execute(
            "UPDATE users SET password_hash = ?, updated_at = NOW() WHERE id = ?",
            [$newHash, $userId]
        );

        // Invalidate all tokens except current (handled by caller)
        $this->db->execute(
            "DELETE FROM auth_tokens WHERE user_id = ?",
            [$userId]
        );

        return $affected > 0;
    }

    /**
     * Reset password with reset code
     * @param string $username
     * @param string $resetCode
     * @param string $newPassword
     * @return bool
     */
    public function resetPassword(string $username, string $resetCode, string $newPassword): bool {
        $adminResetCode = $_ENV['ADMIN_RESET_CODE'] ?? null;

        if (!$adminResetCode || $resetCode !== $adminResetCode) {
            return false;
        }

        // Find user
        $user = $this->db->fetchOne(
            "SELECT id FROM users WHERE username = ?",
            [$username]
        );

        if (!$user) {
            return false;
        }

        // Hash new password
        $newHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);

        // Update password
        $affected = $this->db->execute(
            "UPDATE users SET password_hash = ?, updated_at = NOW() WHERE id = ?",
            [$newHash, $user['id']]
        );

        // Invalidate all tokens
        $this->db->execute(
            "DELETE FROM auth_tokens WHERE user_id = ?",
            [$user['id']]
        );

        return $affected > 0;
    }

    /**
     * Get user by ID
     * @param int $userId
     * @return array|false
     */
    public function getUserById(int $userId): array|false {
        $user = $this->db->fetchOne(
            "SELECT id, username, role, is_active, created_at FROM users WHERE id = ?",
            [$userId]
        );

        return $user ?: false;
    }

    /**
     * Check if user has role
     * @param array $user User array with 'role' key
     * @param string $requiredRole
     * @return bool
     */
    public function hasRole(array $user, string $requiredRole): bool {
        if ($user['role'] === 'super') {
            return true; // Super has all permissions
        }
        return $user['role'] === $requiredRole;
    }

    /**
     * Cleanup expired tokens (run periodically)
     */
    public function cleanupExpiredTokens(): int {
        return $this->db->execute("DELETE FROM auth_tokens WHERE expires_at < NOW()");
    }
}
