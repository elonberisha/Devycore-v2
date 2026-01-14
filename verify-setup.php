<?php
/**
 * Setup Verification Script
 * Run this to check if environment is ready
 */

echo "==========================================\n";
echo "Devycore V2 - Setup Verification\n";
echo "==========================================\n\n";

// 1. PHP Version Check
echo "1. PHP Version: ";
if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
    echo "✓ " . PHP_VERSION . " (OK)\n";
} else {
    echo "✗ " . PHP_VERSION . " (Requires PHP 8.2+)\n";
}

// 2. Required Extensions
echo "\n2. PHP Extensions:\n";
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'json'];
foreach ($requiredExtensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "   - " . str_pad($ext, 12) . ": " . ($loaded ? "✓" : "✗") . "\n";
}

// 3. Composer Autoloader
echo "\n3. Composer Autoloader: ";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "✓ Found\n";
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    echo "✗ Not found (run: composer install)\n";
    exit(1);
}

// 4. Environment File
echo "\n4. Environment File (.env): ";
if (file_exists(__DIR__ . '/.env')) {
    echo "✓ Found\n";
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        echo "   - DB_HOST: " . $_ENV['DB_HOST'] . "\n";
        echo "   - DB_NAME: " . $_ENV['DB_NAME'] . "\n";
        echo "   - DB_USER: " . $_ENV['DB_USER'] . "\n";
    } catch (Exception $e) {
        echo "   ✗ Error loading: " . $e->getMessage() . "\n";
    }
} else {
    echo "✗ Not found (copy .env.example to .env)\n";
}

// 5. Database Connection
echo "\n5. Database Connection: ";
try {
    $db = Devycore\Database::getInstance();
    echo "✓ Connected\n";

    // Check if tables exist
    echo "\n6. Database Tables:\n";
    $tables = ['users', 'auth_tokens', 'projects', 'contact_submissions', 'discount_submissions', 'rate_limits'];
    foreach ($tables as $table) {
        try {
            $stmt = $db->query("SELECT COUNT(*) as count FROM $table");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "   - " . str_pad($table, 22) . ": ✓ (" . $result['count'] . " rows)\n";
        } catch (Exception $e) {
            echo "   - " . str_pad($table, 22) . ": ✗ (not found)\n";
        }
    }

} catch (Exception $e) {
    echo "✗ Failed\n";
    echo "   Error: " . $e->getMessage() . "\n";
    echo "\n   Please:\n";
    echo "   1. Start XAMPP (Apache + MySQL)\n";
    echo "   2. Create database: devycore_v2\n";
    echo "   3. Import: database/schema.sql\n";
}

// 7. File Permissions
echo "\n7. Upload Directory: ";
$uploadDir = __DIR__ . '/public/admin/uploads';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
    echo "✓ Created\n";
} else {
    echo "✓ Exists\n";
}

echo "\n==========================================\n";
echo "Setup Check Complete!\n";
echo "==========================================\n\n";

echo "Next Steps:\n";
echo "1. If database tables are missing, import database/schema.sql\n";
echo "2. Open browser: http://localhost/devycore-v2/public/\n";
echo "3. Check console for any JavaScript errors\n";
echo "4. Test contact form submission\n";
echo "5. Test prize balloon game\n\n";
