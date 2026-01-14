<?php
/**
 * Test Email Script
 * Test if SMTP configuration is working
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

use Devycore\Email;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Test - Devycore</title>
    <style>
        body {
            font-family: monospace;
            background: #0a0a0a;
            color: #00ff88;
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            color: #00ff88;
            border-bottom: 2px solid #00ff88;
            padding-bottom: 1rem;
        }
        .config {
            background: #1a1a1a;
            border: 2px solid #333;
            padding: 1.5rem;
            margin: 1rem 0;
        }
        .config-item {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 1rem;
            margin: 0.5rem 0;
            padding: 0.5rem 0;
            border-bottom: 1px solid #333;
        }
        .config-label {
            color: #7f8b99;
        }
        .config-value {
            color: #00ff88;
            font-weight: bold;
        }
        .btn {
            background: #00ff88;
            color: #0a0a0a;
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            margin: 1rem 0;
        }
        .btn:hover {
            background: #00d470;
        }
        .result {
            background: #1a1a1a;
            border: 2px solid #333;
            padding: 1.5rem;
            margin: 1rem 0;
        }
        .success {
            border-color: #00ff88;
            color: #00ff88;
        }
        .error {
            border-color: #ff0055;
            color: #ff0055;
        }
        input {
            width: 100%;
            padding: 0.75rem;
            background: #1a1a1a;
            border: 2px solid #333;
            color: #00ff88;
            font-family: monospace;
            font-size: 1rem;
        }
        input:focus {
            outline: none;
            border-color: #00ff88;
        }
        .form-group {
            margin: 1rem 0;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #7f8b99;
        }
    </style>
</head>
<body>
    <h1>📧 Email Configuration Test</h1>

    <div class="config">
        <h2 style="margin-top: 0;">Current SMTP Configuration</h2>
        <div class="config-item">
            <div class="config-label">SMTP Host:</div>
            <div class="config-value"><?= htmlspecialchars($_ENV['SMTP_HOST'] ?? 'NOT SET') ?></div>
        </div>
        <div class="config-item">
            <div class="config-label">SMTP Port:</div>
            <div class="config-value"><?= htmlspecialchars($_ENV['SMTP_PORT'] ?? 'NOT SET') ?></div>
        </div>
        <div class="config-item">
            <div class="config-label">SMTP User:</div>
            <div class="config-value"><?= htmlspecialchars($_ENV['SMTP_USER'] ?? 'NOT SET') ?></div>
        </div>
        <div class="config-item">
            <div class="config-label">SMTP Password:</div>
            <div class="config-value"><?= !empty($_ENV['SMTP_PASS']) ? '••••••••' : 'NOT SET' ?></div>
        </div>
        <div class="config-item">
            <div class="config-label">From Email:</div>
            <div class="config-value"><?= htmlspecialchars($_ENV['SMTP_FROM_EMAIL'] ?? 'NOT SET') ?></div>
        </div>
        <div class="config-item">
            <div class="config-label">Contact To:</div>
            <div class="config-value"><?= htmlspecialchars($_ENV['CONTACT_TO'] ?? 'NOT SET') ?></div>
        </div>
        <div class="config-item">
            <div class="config-label">Discount To:</div>
            <div class="config-value"><?= htmlspecialchars($_ENV['DISCOUNT_TO'] ?? 'NOT SET') ?></div>
        </div>
    </div>

    <form method="POST" action="">
        <div class="form-group">
            <label>Test Email Address:</label>
            <input type="email" name="test_email" placeholder="your-email@example.com" required
                   value="<?= htmlspecialchars($_POST['test_email'] ?? '') ?>">
        </div>
        <button type="submit" name="send_test" class="btn">Send Test Email</button>
    </form>

    <?php
    if (isset($_POST['send_test'])) {
        $testEmail = filter_var($_POST['test_email'], FILTER_VALIDATE_EMAIL);

        if (!$testEmail) {
            echo '<div class="result error">❌ Invalid email address</div>';
        } else {
            echo '<div class="result">Sending test email to: ' . htmlspecialchars($testEmail) . '</div>';

            try {
                $email = new Email();

                // Send test discount email
                $testData = [
                    'name' => 'Test User',
                    'email' => $testEmail,
                    'prize' => 'DISC_30',
                    'percentage' => 30,
                    'project_type' => 'Test Project',
                    'company' => 'Test Company',
                    'source' => 'email_test',
                    'notes' => 'This is a test email to verify SMTP configuration is working correctly.',
                    'ip_address' => '127.0.0.1'
                ];

                $result = $email->sendDiscountEmail($testData);

                if ($result) {
                    echo '<div class="result success">✅ Test email sent successfully!</div>';
                    echo '<div class="result">Check your inbox at: ' . htmlspecialchars($testEmail) . '</div>';
                    echo '<div class="result">Also check: ' . htmlspecialchars($_ENV['DISCOUNT_TO'] ?? 'NOT SET') . '</div>';
                } else {
                    echo '<div class="result error">❌ Failed to send test email</div>';
                    echo '<div class="result error">Check PHP error log for details</div>';
                }

            } catch (Exception $e) {
                echo '<div class="result error">❌ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        }
    }
    ?>

    <div class="config" style="margin-top: 2rem;">
        <h2 style="margin-top: 0;">Troubleshooting Steps</h2>
        <ol style="color: #7f8b99; line-height: 1.8;">
            <li>Verify SMTP credentials are correct in <code>.env</code> file</li>
            <li>Check if SMTP host and port are accessible</li>
            <li>Verify "From" email is authorized to send via SMTP server</li>
            <li>Check spam folder in receiving email</li>
            <li>Enable PHP error logging: check <code>php_error.log</code></li>
            <li>Test with a different email provider if needed</li>
            <li>For Hostinger: Use port 465 with SSL, or port 587 with TLS</li>
        </ol>
    </div>

    <div class="config">
        <h2 style="margin-top: 0;">Common Issues</h2>
        <ul style="color: #7f8b99; line-height: 1.8;">
            <li><strong>Authentication Failed:</strong> Wrong username/password</li>
            <li><strong>Connection Timeout:</strong> Wrong host or port, firewall blocking</li>
            <li><strong>Email in Spam:</strong> SPF/DKIM records not configured</li>
            <li><strong>From Email Rejected:</strong> Email not verified on SMTP provider</li>
        </ul>
    </div>

</body>
</html>
