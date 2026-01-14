<?php
/**
 * Discount Form API Endpoint
 * Handles discount/prize submissions with email sending
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/utils/helpers.php';
require_once __DIR__ . '/../../src/utils/validation.php';

use Devycore\Database;
use Devycore\Email;
use Devycore\RateLimit;

// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only allow POST
requireMethod('POST');

try {
    $db = Database::getInstance();
    $email = new Email();
    $rateLimit = new RateLimit($db);

    // Get client IP
    $ip = getClientIP();

    // Rate limiting: 5 requests per 10 minutes (stricter than contact)
    $rateLimitCheck = $rateLimit->check('discount', $ip, (int)($_ENV['RATE_LIMIT_DISCOUNT'] ?? 5));
    if (!$rateLimitCheck['allowed']) {
        errorResponse('Too many submissions. Please try again later.', 429, [
            'retry_after' => $rateLimitCheck['retry_after']
        ]);
    }

    // Get request body
    $data = getRequestBody();

    // Validate form data
    $validation = validateDiscountForm($data);
    if (!$validation['valid']) {
        errorResponse('Validation failed', 400, ['errors' => $validation['errors']]);
    }

    // Sanitize data
    $sanitized = sanitizeDiscountData($data);

    // Extract percentage from prize code
    $percentage = (int)str_replace('DISC_', '', $sanitized['prize']);

    // Save to database
    try {
        $submissionId = $db->insert(
            "INSERT INTO discount_submissions (name, email, prize, percentage, source, project_type, company, notes, ip_address, email_sent)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)",
            [
                $sanitized['name'],
                $sanitized['email'],
                $sanitized['prize'],
                $percentage,
                $sanitized['source'],
                $sanitized['project_type'],
                $sanitized['company'],
                $sanitized['notes'],
                $sanitized['ip_address']
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to save discount submission: " . $e->getMessage());
        errorResponse('Failed to save submission', 500);
    }

    // Prepare email data
    $emailData = $sanitized;
    $emailData['percentage'] = $percentage;

    // Send email
    $emailSent = $email->sendDiscountEmail($emailData);

    // Update email_sent status
    if ($emailSent) {
        $db->execute(
            "UPDATE discount_submissions SET email_sent = 1 WHERE id = ?",
            [$submissionId]
        );
    } else {
        error_log("Discount email failed to send for submission ID: $submissionId");
    }

    logAudit('discount_form_submitted', [
        'submission_id' => $submissionId,
        'email' => $sanitized['email'],
        'prize' => $sanitized['prize'],
        'percentage' => $percentage,
        'email_sent' => $emailSent
    ]);

    successResponse([
        'id' => $submissionId,
        'prize' => $sanitized['prize'],
        'percentage' => $percentage,
        'label' => "{$percentage}% OFF",
        'email_sent' => $emailSent
    ], "Congratulations! You won {$percentage}% discount!");

} catch (Exception $e) {
    error_log("Discount API error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
