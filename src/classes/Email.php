<?php
namespace Devycore;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Email Class - PHPMailer Wrapper
 * Handles email sending with SMTP configuration
 */
class Email {
    private PHPMailer $mailer;
    private array $config;

    public function __construct() {
        $this->config = [
            'host' => $_ENV['SMTP_HOST'] ?? '',
            'port' => (int)($_ENV['SMTP_PORT'] ?? 465),
            'secure' => ($_ENV['SMTP_SECURE'] ?? 'true') === 'true',
            'user' => $_ENV['SMTP_USER'] ?? '',
            'pass' => $_ENV['SMTP_PASS'] ?? '',
            'from_email' => $_ENV['SMTP_FROM_EMAIL'] ?? '',
            'from_name' => $_ENV['SMTP_FROM_NAME'] ?? 'Devycore',
        ];

        $this->mailer = new PHPMailer(true);
        $this->configure();
    }

    /**
     * Configure PHPMailer
     */
    private function configure(): void {
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['host'];
        $this->mailer->Port = $this->config['port'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config['user'];
        $this->mailer->Password = $this->config['pass'];
        $this->mailer->SMTPSecure = $this->config['secure'] ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->setFrom($this->config['from_email'], $this->config['from_name']);
        $this->mailer->CharSet = 'UTF-8';

        // Disable debug output in production
        if (($_ENV['APP_ENV'] ?? 'production') !== 'development') {
            $this->mailer->SMTPDebug = SMTP::DEBUG_OFF;
        }
    }

    /**
     * Send contact form email
     * @param array $data Contact form data
     * @return bool
     */
    public function sendContactEmail(array $data): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->clearAttachments();

            $to = $_ENV['CONTACT_TO'] ?? $this->config['from_email'];
            $this->mailer->addAddress($to);

            if (!empty($data['email'])) {
                $this->mailer->addReplyTo($data['email'], $data['name'] ?? '');
            }

            $subject = sprintf(
                "Interested Client: %s – %s",
                $data['name'] ?? 'Unknown',
                $data['project_type'] ?? 'General Inquiry'
            );

            $this->mailer->Subject = $subject;
            $this->mailer->Body = $this->getContactHtmlBody($data);
            $this->mailer->AltBody = $this->getContactPlainBody($data);

            // Add custom headers
            $this->mailer->addCustomHeader('X-Source', 'InterestedClient');
            $this->mailer->addCustomHeader('X-Client-Type', 'contact');
            if (!empty($data['ip_address'])) {
                $this->mailer->addCustomHeader('X-Origin-IP', $data['ip_address']);
            }

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Contact email failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send discount email
     * @param array $data Discount form data
     * @return bool
     */
    public function sendDiscountEmail(array $data): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->clearAttachments();

            $to = $_ENV['DISCOUNT_TO'] ?? $_ENV['CONTACT_TO'] ?? $this->config['from_email'];
            $this->mailer->addAddress($to);

            if (!empty($data['email'])) {
                $this->mailer->addReplyTo($data['email'], $data['name'] ?? '');
            }

            $percentage = $data['percentage'] ?? 0;
            $subject = sprintf(
                "Discount Client: %s – %d%%",
                $data['name'] ?? 'Unknown',
                $percentage
            );

            $this->mailer->Subject = $subject;
            $this->mailer->Body = $this->getDiscountHtmlBody($data);
            $this->mailer->AltBody = $this->getDiscountPlainBody($data);

            // Add custom headers
            $this->mailer->addCustomHeader('X-Source', 'DiscountClient');
            $this->mailer->addCustomHeader('X-Client-Type', 'discount');
            $this->mailer->addCustomHeader('X-Discount', $data['prize'] ?? '');
            if (!empty($data['ip_address'])) {
                $this->mailer->addCustomHeader('X-Origin-IP', $data['ip_address']);
            }

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Discount email failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send admin notification email
     * @param string $subject
     * @param string $message
     * @param string|null $username
     * @return bool
     */
    public function sendAdminNotification(string $subject, string $message, ?string $username = null): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->clearAttachments();

            $to = $_ENV['ADMIN_NOTIFY_EMAIL'] ?? $_ENV['CONTACT_TO'] ?? $this->config['from_email'];
            $this->mailer->addAddress($to);

            $this->mailer->Subject = "[Admin] " . $subject;
            $this->mailer->Body = "<pre style='font-family:monospace;white-space:pre-wrap;line-height:1.4'>$message</pre>";
            $this->mailer->AltBody = $message;

            // Add custom headers
            $this->mailer->addCustomHeader('X-Source', 'AdminNotification');
            if ($username) {
                $this->mailer->addCustomHeader('X-Admin-User', $username);
            }

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Admin notification failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get contact email HTML body
     */
    private function getContactHtmlBody(array $data): string {
        $name = htmlspecialchars($data['name'] ?? '');
        $email = htmlspecialchars($data['email'] ?? '');
        $projectType = htmlspecialchars($data['project_type'] ?? '—');
        $message = htmlspecialchars($data['message'] ?? '');
        $timestamp = date('Y-m-d H:i:s');

        // Optional fields - only show if provided
        $phone = !empty($data['phone']) ? htmlspecialchars($data['phone']) : null;
        $company = !empty($data['company']) ? htmlspecialchars($data['company']) : null;
        $companyType = !empty($data['company_type']) ? htmlspecialchars($data['company_type']) : null;
        $prize = !empty($data['prize']) ? htmlspecialchars($data['prize']) : null;

        $optionalRows = '';
        if ($phone) {
            $optionalRows .= "<tr><td style=\"color:#7f8b99;padding-right:20px;\">Phone</td><td>$phone</td></tr>";
        }
        if ($company) {
            $optionalRows .= "<tr><td style=\"color:#7f8b99;padding-right:20px;\">Company</td><td>$company</td></tr>";
        }
        if ($companyType) {
            $optionalRows .= "<tr><td style=\"color:#7f8b99;padding-right:20px;\">Company Type</td><td>$companyType</td></tr>";
        }
        if ($prize) {
            $optionalRows .= "<tr><td style=\"color:#7f8b99;padding-right:20px;\">Discount Code</td><td style=\"color:#00ff88;font-weight:600;\">$prize</td></tr>";
        }

        return <<<HTML
<html>
<body style="font-family:Inter,Arial,sans-serif;background:#0b0d10;color:#ecf3ff;padding:24px;margin:0;">
  <h2 style="margin:0 0 14px;font-size:20px;font-weight:600;color:#00ff88;">New Contact Inquiry</h2>
  <table cellpadding="6" cellspacing="0" style="font-size:14px;border-collapse:collapse;">
    <tr><td style="color:#7f8b99;padding-right:20px;">Name</td><td><strong>$name</strong></td></tr>
    <tr><td style="color:#7f8b99;padding-right:20px;">Email</td><td><a href="mailto:$email" style="color:#00ff88;text-decoration:none;">$email</a></td></tr>
    <tr><td style="color:#7f8b99;padding-right:20px;">Project Type</td><td><strong>$projectType</strong></td></tr>
    $optionalRows
  </table>
  <div style="margin:20px 0 8px;font-size:12px;color:#ff0055;font-weight:600;text-transform:uppercase;">Message</div>
  <div style="white-space:pre-wrap;background:#12171d;border:2px solid #333;padding:14px 16px;font-family:monospace;line-height:1.6;">$message</div>
  <div style="margin-top:26px;font-size:11px;color:#6b7683;">Generated $timestamp · Devycore Contact Form</div>
</body>
</html>
HTML;
    }

    /**
     * Get contact email plain text body
     */
    private function getContactPlainBody(array $data): string {
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $projectType = $data['project_type'] ?? '—';
        $message = $data['message'] ?? '';

        $text = "New Contact Inquiry\n\n";
        $text .= "Name: $name\n";
        $text .= "Email: $email\n";
        $text .= "Project Type: $projectType\n";

        // Optional fields
        if (!empty($data['phone'])) {
            $text .= "Phone: " . $data['phone'] . "\n";
        }
        if (!empty($data['company'])) {
            $text .= "Company: " . $data['company'] . "\n";
        }
        if (!empty($data['company_type'])) {
            $text .= "Company Type: " . $data['company_type'] . "\n";
        }
        if (!empty($data['prize'])) {
            $text .= "Discount Code: " . $data['prize'] . "\n";
        }

        $text .= "\n---\nMessage:\n$message";

        return $text;
    }

    /**
     * Get discount email HTML body
     */
    private function getDiscountHtmlBody(array $data): string {
        $name = htmlspecialchars($data['name'] ?? '');
        $email = htmlspecialchars($data['email'] ?? '');
        $prize = htmlspecialchars($data['prize'] ?? '');
        $percentage = (int)($data['percentage'] ?? 0);
        $projectType = htmlspecialchars($data['project_type'] ?? '—');
        $company = htmlspecialchars($data['company'] ?? '—');
        $source = htmlspecialchars($data['source'] ?? '—');
        $notes = htmlspecialchars($data['notes'] ?? '—');
        $ip = htmlspecialchars($data['ip_address'] ?? 'unknown');
        $timestamp = date('Y-m-d H:i:s');

        return <<<HTML
<html>
<body style="font-family:Inter,Arial,sans-serif;background:#0b0d10;color:#ecf3ff;padding:24px;margin:0;">
  <h2 style="margin:0 0 14px;font-size:20px;font-weight:600;color:#00ff88;">Discount Client</h2>
  <table cellpadding="6" cellspacing="0" style="font-size:14px;border-collapse:collapse;">
    <tr><td style="color:#7f8b99;padding-right:20px;">Name</td><td><strong>$name</strong></td></tr>
    <tr><td style="color:#7f8b99;padding-right:20px;">Email</td><td><a href="mailto:$email" style="color:#00ff88;text-decoration:none;">$email</a></td></tr>
    <tr><td style="color:#7f8b99;padding-right:20px;">Prize</td><td><span style="color:#00ff88;font-weight:600;">$prize ($percentage%)</span></td></tr>
    <tr><td style="color:#7f8b99;padding-right:20px;">Project Type</td><td>$projectType</td></tr>
    <tr><td style="color:#7f8b99;padding-right:20px;">Company</td><td>$company</td></tr>
    <tr><td style="color:#7f8b99;padding-right:20px;">Source</td><td>$source</td></tr>
    <tr><td style="color:#7f8b99;padding-right:20px;">IP</td><td>$ip</td></tr>
  </table>
  <div style="margin:20px 0 8px;font-size:12px;color:#ff0055;font-weight:600;text-transform:uppercase;">Notes</div>
  <div style="white-space:pre-wrap;background:#12171d;border:2px solid #333;padding:14px 16px;font-family:monospace;">$notes</div>
  <div style="margin-top:26px;font-size:11px;color:#6b7683;">Generated $timestamp · Devycore Discount</div>
</body>
</html>
HTML;
    }

    /**
     * Get discount email plain text body
     */
    private function getDiscountPlainBody(array $data): string {
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $prize = $data['prize'] ?? '';
        $percentage = $data['percentage'] ?? 0;
        $projectType = $data['project_type'] ?? '—';
        $company = $data['company'] ?? '—';
        $source = $data['source'] ?? '—';
        $notes = $data['notes'] ?? '—';
        $ip = $data['ip_address'] ?? 'unknown';

        return <<<TEXT
Discount Client

Name: $name
Email: $email
Prize: $prize ($percentage%)
Project Type: $projectType
Company: $company
Source: $source
IP: $ip

Notes:
$notes
TEXT;
    }
}
