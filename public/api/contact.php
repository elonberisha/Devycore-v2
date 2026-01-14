<?php
/**
 * Contact Form API Endpoint
 * Handles contact form submissions with email sending
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

    // Rate limiting: 10 requests per 10 minutes
    $rateLimitCheck = $rateLimit->check('contact', $ip, (int)($_ENV['RATE_LIMIT_CONTACT'] ?? 10));
    if (!$rateLimitCheck['allowed']) {
        errorResponse('Too many submissions. Please try again later.', 429, [
            'retry_after' => $rateLimitCheck['retry_after']
        ]);
    }

    // Get request body
    $data = getRequestBody();

    // Validate form data
    $validation = validateContactForm($data);
    if (!$validation['valid']) {
        errorResponse('Validation failed', 400, ['errors' => $validation['errors']]);
    }

    // Sanitize data
    $sanitized = sanitizeContactData($data);

    // Save to database
    try {
        $submissionId = $db->insert(
            "INSERT INTO contact_submissions (name, email, phone, company, message, project_type, company_type, prize, ip_address, user_agent, email_sent)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)",
            [
                $sanitized['name'],
                $sanitized['email'],
                $sanitized['phone'],
                $sanitized['company'],
                $sanitized['message'],
                $sanitized['project_type'],
                $sanitized['company_type'],
                $sanitized['prize'],
                $sanitized['ip_address'],
                $sanitized['user_agent']
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to save contact submission: " . $e->getMessage());
        errorResponse('Failed to save submission', 500);
    }

    // Send email
    $emailSent = $email->sendContactEmail($sanitized);

    // Update email_sent status
    if ($emailSent) {
        $db->execute(
            "UPDATE contact_submissions SET email_sent = 1 WHERE id = ?",
            [$submissionId]
        );
    } else {
        error_log("Contact email failed to send for submission ID: $submissionId");
    }

    logAudit('contact_form_submitted', [
        'submission_id' => $submissionId,
        'email' => $sanitized['email'],
        'project_type' => $sanitized['project_type'],
        'email_sent' => $emailSent
    ]);

    successResponse([
        'id' => $submissionId,
        'email_sent' => $emailSent
    ], 'Thank you! We will contact you soon.');

} catch (Exception $e) {
    error_log("Contact API error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
