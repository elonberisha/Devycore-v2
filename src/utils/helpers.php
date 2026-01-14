<?php
/**
 * Helper Functions
 * Utility functions used throughout the application
 */

/**
 * Get client IP address (handles proxy headers)
 * @return string
 */
function getClientIP(): string {
    $headers = [
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_REAL_IP',
        'HTTP_CF_CONNECTING_IP',
        'HTTP_FASTLY_CLIENT_IP',
        'HTTP_X_CLIENT_IP',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = $_SERVER[$header];

            // Handle comma-separated IPs (proxy chain)
            if (str_contains($ip, ',')) {
                $ip = trim(explode(',', $ip)[0]);
            }

            // Remove IPv6 prefix
            $ip = str_replace('::ffff:', '', $ip);

            // Normalize localhost
            if ($ip === '::1') {
                return '127.0.0.1';
            }

            // Validate IP
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }

    return '0.0.0.0';
}

/**
 * Send JSON response
 * @param array $data Response data
 * @param int $statusCode HTTP status code
 */
function jsonResponse(array $data, int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/**
 * Send error response
 * @param string $error Error message
 * @param int $statusCode HTTP status code
 * @param array $extra Extra data to include
 */
function errorResponse(string $error, int $statusCode = 400, array $extra = []): void {
    jsonResponse(array_merge([
        'success' => false,
        'error' => $error
    ], $extra), $statusCode);
}

/**
 * Send success response
 * @param array $data Response data
 * @param string|null $message Success message
 */
function successResponse(array $data = [], ?string $message = null): void {
    $response = ['success' => true];

    if ($message !== null) {
        $response['message'] = $message;
    }

    if (!empty($data)) {
        $response['data'] = $data;
    }

    jsonResponse($response);
}

/**
 * Sanitize string input
 * @param string|null $value
 * @param int $maxLength
 * @return string
 */
function sanitizeString(?string $value, int $maxLength = 255): string {
    if ($value === null) {
        return '';
    }

    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

    if ($maxLength > 0) {
        $value = mb_substr($value, 0, $maxLength, 'UTF-8');
    }

    return $value;
}

/**
 * Validate email address
 * @param string|null $email
 * @return bool
 */
function isValidEmail(?string $email): bool {
    if (empty($email)) {
        return false;
    }
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate URL
 * @param string|null $url
 * @return bool
 */
function isValidUrl(?string $url): bool {
    if (empty($url)) {
        return false;
    }
    return (bool) filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Generate CSRF token
 * @return string
 */
function generateCsrfToken(): string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    $_SESSION['csrf_token_time'] = time();

    return $token;
}

/**
 * Verify CSRF token
 * @param string|null $token
 * @return bool
 */
function verifyCsrfToken(?string $token): bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }

    // Check if token is expired (1 hour)
    $tokenAge = time() - ($_SESSION['csrf_token_time'] ?? 0);
    $maxAge = (int)($_ENV['CSRF_TOKEN_EXPIRY'] ?? 3600);

    if ($tokenAge > $maxAge) {
        unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get Bearer token from Authorization header
 * @return string|null
 */
function getBearerToken(): ?string {
    $headers = getallheaders();

    if (isset($headers['Authorization'])) {
        $auth = $headers['Authorization'];
        if (preg_match('/Bearer\s+(.*)$/i', $auth, $matches)) {
            return $matches[1];
        }
    }

    return null;
}

/**
 * Sanitize filename for safe storage
 * @param string $filename
 * @return string
 */
function sanitizeFilename(string $filename): string {
    // Get extension
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $name = pathinfo($filename, PATHINFO_FILENAME);

    // Remove special characters
    $name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $name);

    // Limit length
    $name = mb_substr($name, 0, 50, 'UTF-8');

    // Add timestamp prefix
    return time() . '-' . $name . '.' . $ext;
}

/**
 * Log audit event
 * @param string $action
 * @param array $details
 * @param int|null $userId
 */
function logAudit(string $action, array $details = [], ?int $userId = null): void {
    $logFile = __DIR__ . '/../../logs/audit.log';
    $logDir = dirname($logFile);

    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'action' => $action,
        'user_id' => $userId,
        'ip' => getClientIP(),
        'details' => $details
    ];

    file_put_contents(
        $logFile,
        json_encode($entry) . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}

/**
 * Check if request is AJAX
 * @return bool
 */
function isAjaxRequest(): bool {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Get request body as array (handles JSON)
 * @return array
 */
function getRequestBody(): array {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (str_contains($contentType, 'application/json')) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        return is_array($data) ? $data : [];
    }

    return $_POST;
}

/**
 * Check if request method matches
 * @param string $method HTTP method (GET, POST, PUT, DELETE, etc.)
 * @return bool
 */
function isMethod(string $method): bool {
    return strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($method);
}

/**
 * Require HTTP method or send 405 error
 * @param string $method
 */
function requireMethod(string $method): void {
    if (!isMethod($method)) {
        errorResponse('Method not allowed', 405);
    }
}
