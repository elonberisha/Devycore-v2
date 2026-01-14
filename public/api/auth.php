<?php
/**
 * Authentication API Endpoint
 * Handles login, logout, and token validation
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/utils/helpers.php';
require_once __DIR__ . '/../../src/utils/validation.php';

use Devycore\Database;
use Devycore\Auth;
use Devycore\RateLimit;

// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $db = Database::getInstance();
    $auth = new Auth($db);
    $rateLimit = new RateLimit($db);

    $requestUri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    // POST /api/auth/login - User login
    if ($method === 'POST' && str_contains($requestUri, '/login')) {
        $ip = getClientIP();

        // Rate limiting: 10 attempts per 15 minutes
        $rateLimitCheck = $rateLimit->check('login', $ip, 10);
        if (!$rateLimitCheck['allowed']) {
            errorResponse('Too many login attempts. Try again later.', 429, [
                'retry_after' => $rateLimitCheck['retry_after']
            ]);
        }

        $data = getRequestBody();

        // Validate input
        $validation = validateLoginData($data);
        if (!$validation['valid']) {
            errorResponse('Invalid input', 400, ['errors' => $validation['errors']]);
        }

        // Attempt login
        $result = $auth->login($data['username'], $data['password']);

        if ($result === false) {
            logAudit('login_failed', ['username' => $data['username'], 'ip' => $ip]);
            errorResponse('Invalid credentials', 401);
        }

        logAudit('login_success', ['username' => $result['user']['username']], $result['user']['id']);

        successResponse($result, 'Login successful');
    }

    // POST /api/auth/logout - User logout
    elseif ($method === 'POST' && str_contains($requestUri, '/logout')) {
        $token = getBearerToken();

        if (!$token) {
            errorResponse('No token provided', 401);
        }

        // Validate token to get user info before logout
        $user = $auth->validateToken($token);

        if ($user) {
            logAudit('logout', ['username' => $user['username']], $user['id']);
        }

        $auth->logout($token);

        successResponse([], 'Logged out successfully');
    }

    // GET /api/auth/me - Get current user info
    elseif ($method === 'GET' && str_contains($requestUri, '/me')) {
        $token = getBearerToken();

        if (!$token) {
            errorResponse('No token provided', 401);
        }

        $user = $auth->validateToken($token);

        if (!$user) {
            errorResponse('Invalid or expired token', 401);
        }

        successResponse($user);
    }

    // POST /api/auth/reset-password - Reset password with code
    elseif ($method === 'POST' && str_contains($requestUri, '/reset-password')) {
        $ip = getClientIP();

        // Rate limiting
        $rateLimitCheck = $rateLimit->check('password_reset', $ip, 5);
        if (!$rateLimitCheck['allowed']) {
            errorResponse('Too many reset attempts. Try again later.', 429, [
                'retry_after' => $rateLimitCheck['retry_after']
            ]);
        }

        $data = getRequestBody();

        if (empty($data['username']) || empty($data['reset_code']) || empty($data['new_password'])) {
            errorResponse('Missing required fields', 400);
        }

        // Validate password
        $passwordValidation = validatePassword($data['new_password']);
        if (!$passwordValidation['valid']) {
            errorResponse('Invalid password', 400, ['errors' => $passwordValidation['errors']]);
        }

        $result = $auth->resetPassword($data['username'], $data['reset_code'], $data['new_password']);

        if (!$result) {
            logAudit('password_reset_failed', ['username' => $data['username'], 'ip' => $ip]);
            errorResponse('Invalid reset code or username', 403);
        }

        logAudit('password_reset_success', ['username' => $data['username']]);

        successResponse([], 'Password reset successful');
    }

    // POST /api/auth/change-password - Change own password
    elseif ($method === 'POST' && str_contains($requestUri, '/change-password')) {
        $token = getBearerToken();

        if (!$token) {
            errorResponse('No token provided', 401);
        }

        $user = $auth->validateToken($token);

        if (!$user) {
            errorResponse('Invalid or expired token', 401);
        }

        $data = getRequestBody();

        if (empty($data['current_password']) || empty($data['new_password'])) {
            errorResponse('Missing required fields', 400);
        }

        // Validate new password
        $passwordValidation = validatePassword($data['new_password']);
        if (!$passwordValidation['valid']) {
            errorResponse('Invalid password', 400, ['errors' => $passwordValidation['errors']]);
        }

        $result = $auth->changePassword($user['id'], $data['current_password'], $data['new_password']);

        if (!$result) {
            errorResponse('Invalid current password', 401);
        }

        logAudit('password_changed', ['username' => $user['username']], $user['id']);

        successResponse([], 'Password changed successfully');
    }

    // POST /api/auth/create-user - Create new user (super only)
    elseif ($method === 'POST' && str_contains($requestUri, '/create-user')) {
        $token = getBearerToken();

        if (!$token) {
            errorResponse('No token provided', 401);
        }

        $user = $auth->validateToken($token);

        if (!$user) {
            errorResponse('Invalid or expired token', 401);
        }

        // Check if user is super
        if ($user['role'] !== 'super') {
            errorResponse('Permission denied', 403);
        }

        $data = getRequestBody();

        if (empty($data['username']) || empty($data['password'])) {
            errorResponse('Missing required fields', 400);
        }

        // Validate password
        $passwordValidation = validatePassword($data['password']);
        if (!$passwordValidation['valid']) {
            errorResponse('Invalid password', 400, ['errors' => $passwordValidation['errors']]);
        }

        $role = $data['role'] ?? 'admin';
        $userId = $auth->createUser($data['username'], $data['password'], $role);

        if ($userId === false) {
            errorResponse('Failed to create user (may already exist)', 400);
        }

        logAudit('user_created', [
            'username' => $data['username'],
            'role' => $role,
            'created_by' => $user['username']
        ], $user['id']);

        successResponse([
            'user_id' => $userId,
            'username' => $data['username'],
            'role' => $role
        ], 'User created successfully');
    }

    else {
        errorResponse('Endpoint not found', 404);
    }

} catch (Exception $e) {
    error_log("Auth API error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
