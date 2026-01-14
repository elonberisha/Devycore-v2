<?php
/**
 * Create Test Data
 * Run this once to populate database with sample data
 */

require_once __DIR__ . '/vendor/autoload.php';

use Devycore\Database;
use Devycore\Auth;

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "==========================================\n";
echo "Creating Test Data for Devycore V2\n";
echo "==========================================\n\n";

try {
    $db = Database::getInstance();
    echo "✓ Connected to database\n\n";

    // 1. Check if admin user exists
    echo "1. Checking admin user...\n";
    $adminExists = $db->fetchOne("SELECT id FROM users WHERE username = 'admin'");

    if ($adminExists) {
        echo "   ✓ Admin user already exists (ID: {$adminExists['id']})\n";
    } else {
        echo "   Creating admin user...\n";
        $auth = new Auth();

        // Create admin user
        $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 12]);
        $db->query(
            "INSERT INTO users (username, password_hash, role, is_active) VALUES (?, ?, 'super', 1)",
            ['admin', $hashedPassword]
        );

        echo "   ✓ Admin user created\n";
        echo "   Username: admin\n";
        echo "   Password: admin123\n";
        echo "   ⚠️  CHANGE THIS PASSWORD IN PRODUCTION!\n";
    }

    // 2. Create sample projects
    echo "\n2. Creating sample projects...\n";

    $sampleProjects = [
        [
            'id' => (int)(microtime(true) * 1000),
            'title' => 'E-Commerce Platform',
            'url' => 'https://example.com/ecommerce',
            'description' => 'Modern e-commerce platform with real-time inventory management, payment processing, and analytics dashboard.',
            'technologies' => json_encode(['PHP', 'MySQL', 'React', 'Stripe']),
            'image_url' => '/devycore-v2/public/assets/images/project1.jpg',
            'featured' => 1,
            'display_order' => 1,
            'created_by' => 1
        ],
        [
            'id' => (int)(microtime(true) * 1000) + 1,
            'title' => 'Project Management System',
            'url' => 'https://example.com/pms',
            'description' => 'Collaborative project management tool with task tracking, team collaboration, and time tracking features.',
            'technologies' => json_encode(['Laravel', 'Vue.js', 'PostgreSQL', 'Redis']),
            'image_url' => '/devycore-v2/public/assets/images/project2.jpg',
            'featured' => 1,
            'display_order' => 2,
            'created_by' => 1
        ],
        [
            'id' => (int)(microtime(true) * 1000) + 2,
            'title' => 'Analytics Dashboard',
            'url' => 'https://example.com/analytics',
            'description' => 'Real-time analytics dashboard with custom reports, data visualization, and automated insights.',
            'technologies' => json_encode(['Python', 'Django', 'Chart.js', 'MongoDB']),
            'image_url' => '/devycore-v2/public/assets/images/project3.jpg',
            'featured' => 1,
            'display_order' => 3,
            'created_by' => 1
        ],
        [
            'id' => (int)(microtime(true) * 1000) + 3,
            'title' => 'CRM Application',
            'url' => 'https://example.com/crm',
            'description' => 'Customer relationship management system with lead tracking, email automation, and sales pipeline.',
            'technologies' => json_encode(['Node.js', 'Express', 'React', 'MySQL']),
            'image_url' => '/devycore-v2/public/assets/images/project4.jpg',
            'featured' => 0,
            'display_order' => 4,
            'created_by' => 1
        ],
        [
            'id' => (int)(microtime(true) * 1000) + 4,
            'title' => 'Social Media Platform',
            'url' => 'https://example.com/social',
            'description' => 'Social networking platform with real-time messaging, content sharing, and user engagement features.',
            'technologies' => json_encode(['Ruby on Rails', 'PostgreSQL', 'React Native', 'WebSocket']),
            'image_url' => '/devycore-v2/public/assets/images/project5.jpg',
            'featured' => 0,
            'display_order' => 5,
            'created_by' => 1
        ],
        [
            'id' => (int)(microtime(true) * 1000) + 5,
            'title' => 'Learning Management System',
            'url' => 'https://example.com/lms',
            'description' => 'Online learning platform with course management, student tracking, and interactive assessments.',
            'technologies' => json_encode(['PHP', 'Symfony', 'Vue.js', 'MariaDB']),
            'image_url' => '/devycore-v2/public/assets/images/project6.jpg',
            'featured' => 1,
            'display_order' => 6,
            'created_by' => 1
        ]
    ];

    $existingProjects = $db->fetchAll("SELECT id FROM projects");

    if (count($existingProjects) > 0) {
        echo "   ✓ Projects already exist (" . count($existingProjects) . " projects)\n";
        echo "   Skipping project creation...\n";
    } else {
        foreach ($sampleProjects as $project) {
            $db->query(
                "INSERT INTO projects (id, title, url, description, technologies, image_url, featured, display_order, created_by)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $project['id'],
                    $project['title'],
                    $project['url'],
                    $project['description'],
                    $project['technologies'],
                    $project['image_url'],
                    $project['featured'],
                    $project['display_order'],
                    $project['created_by']
                ]
            );
            echo "   ✓ Created: {$project['title']}\n";
        }

        echo "   ✓ Created " . count($sampleProjects) . " sample projects\n";
    }

    // 3. Summary
    echo "\n==========================================\n";
    echo "Database Summary\n";
    echo "==========================================\n\n";

    $userCount = $db->fetchOne("SELECT COUNT(*) as count FROM users")['count'];
    $projectCount = $db->fetchOne("SELECT COUNT(*) as count FROM projects")['count'];
    $contactCount = $db->fetchOne("SELECT COUNT(*) as count FROM contact_submissions")['count'];
    $discountCount = $db->fetchOne("SELECT COUNT(*) as count FROM discount_submissions")['count'];

    echo "Users:              $userCount\n";
    echo "Projects:           $projectCount\n";
    echo "Contact Submissions: $contactCount\n";
    echo "Discount Submissions: $discountCount\n";

    echo "\n==========================================\n";
    echo "Test Data Created Successfully!\n";
    echo "==========================================\n\n";

    echo "Login Credentials:\n";
    echo "  URL:      http://localhost/devycore-v2/public/api/auth.php/login\n";
    echo "  Username: admin\n";
    echo "  Password: admin123\n";
    echo "  ⚠️  CHANGE PASSWORD IN PRODUCTION!\n\n";

    echo "Next Steps:\n";
    echo "1. Test login: See TEST.md for curl commands\n";
    echo "2. View projects: http://localhost/devycore-v2/public/api/projects.php\n";
    echo "3. Test contact form on homepage\n";
    echo "4. Build admin panel UI (optional)\n\n";

} catch (Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "\nPlease ensure:\n";
    echo "1. MySQL is running in XAMPP\n";
    echo "2. Database 'devycore_v2' exists\n";
    echo "3. Schema has been imported (database/schema.sql)\n\n";
    exit(1);
}
