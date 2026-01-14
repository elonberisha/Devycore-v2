<?php
/**
 * Site Settings API - Contact Info & Social Networks
 * Handles CRUD operations for contact information and social media links
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/classes/Auth.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

// Public GET requests (no auth required)
if ($method === 'GET') {
    handleGetRequest($path);
    exit;
}

// All other methods require authentication
$headers = getallheaders();
$token = $headers['Authorization'] ?? '';
$token = str_replace('Bearer ', '', $token);

$auth = new Auth($pdo);
$user = $auth->validateToken($token);

if (!$user) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

// Route based on method and path
switch ($method) {
    case 'POST':
        handlePostRequest($path);
        break;
    case 'PUT':
        handlePutRequest($path);
        break;
    case 'DELETE':
        handleDeleteRequest($path);
        break;
    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Method not allowed']);
}

/**
 * GET - Public endpoint to fetch all settings
 */
function handleGetRequest($path) {
    global $pdo;

    try {
        // Get contact info
        $stmt = $pdo->prepare("
            SELECT info_key, info_value, display_order
            FROM contact_info
            WHERE is_active = TRUE
            ORDER BY display_order
        ");
        $stmt->execute();
        $contactInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get social networks
        $stmt = $pdo->prepare("
            SELECT id, platform, url, icon_name, display_order
            FROM social_networks
            WHERE is_active = TRUE
            ORDER BY display_order
        ");
        $stmt->execute();
        $socialNetworks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'data' => [
                'contact_info' => $contactInfo,
                'social_networks' => $socialNetworks
            ]
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    }
}

/**
 * POST - Create new contact info or social network
 */
function handlePostRequest($path) {
    global $pdo;

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['type'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid request data']);
        return;
    }

    try {
        if ($data['type'] === 'contact_info') {
            // Validate required fields
            if (empty($data['info_key']) || empty($data['info_value'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Missing required fields']);
                return;
            }

            $stmt = $pdo->prepare("
                INSERT INTO contact_info (info_key, info_value, display_order, is_active)
                VALUES (:info_key, :info_value, :display_order, :is_active)
            ");

            $stmt->execute([
                ':info_key' => $data['info_key'],
                ':info_value' => $data['info_value'],
                ':display_order' => $data['display_order'] ?? 0,
                ':is_active' => $data['is_active'] ?? true
            ]);

            $id = $pdo->lastInsertId();

            echo json_encode([
                'success' => true,
                'message' => 'Contact info created successfully',
                'data' => ['id' => $id]
            ]);

        } elseif ($data['type'] === 'social_network') {
            // Validate required fields
            if (empty($data['platform']) || empty($data['url'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Missing required fields']);
                return;
            }

            $stmt = $pdo->prepare("
                INSERT INTO social_networks (platform, url, icon_name, display_order, is_active)
                VALUES (:platform, :url, :icon_name, :display_order, :is_active)
            ");

            $stmt->execute([
                ':platform' => $data['platform'],
                ':url' => $data['url'],
                ':icon_name' => $data['icon_name'] ?? null,
                ':display_order' => $data['display_order'] ?? 0,
                ':is_active' => $data['is_active'] ?? true
            ]);

            $id = $pdo->lastInsertId();

            echo json_encode([
                'success' => true,
                'message' => 'Social network created successfully',
                'data' => ['id' => $id]
            ]);

        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid type']);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    }
}

/**
 * PUT - Update existing contact info or social network
 */
function handlePutRequest($path) {
    global $pdo;

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['type']) || !isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid request data']);
        return;
    }

    try {
        if ($data['type'] === 'contact_info') {
            $stmt = $pdo->prepare("
                UPDATE contact_info
                SET info_value = :info_value,
                    display_order = :display_order,
                    is_active = :is_active
                WHERE id = :id
            ");

            $stmt->execute([
                ':id' => $data['id'],
                ':info_value' => $data['info_value'],
                ':display_order' => $data['display_order'] ?? 0,
                ':is_active' => $data['is_active'] ?? true
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Contact info updated successfully'
            ]);

        } elseif ($data['type'] === 'social_network') {
            $stmt = $pdo->prepare("
                UPDATE social_networks
                SET platform = :platform,
                    url = :url,
                    icon_name = :icon_name,
                    display_order = :display_order,
                    is_active = :is_active
                WHERE id = :id
            ");

            $stmt->execute([
                ':id' => $data['id'],
                ':platform' => $data['platform'],
                ':url' => $data['url'],
                ':icon_name' => $data['icon_name'] ?? null,
                ':display_order' => $data['display_order'] ?? 0,
                ':is_active' => $data['is_active'] ?? true
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Social network updated successfully'
            ]);

        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid type']);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    }
}

/**
 * DELETE - Remove contact info or social network
 */
function handleDeleteRequest($path) {
    global $pdo;

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['type']) || !isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid request data']);
        return;
    }

    try {
        if ($data['type'] === 'contact_info') {
            $stmt = $pdo->prepare("DELETE FROM contact_info WHERE id = :id");
            $stmt->execute([':id' => $data['id']]);

            echo json_encode([
                'success' => true,
                'message' => 'Contact info deleted successfully'
            ]);

        } elseif ($data['type'] === 'social_network') {
            $stmt = $pdo->prepare("DELETE FROM social_networks WHERE id = :id");
            $stmt->execute([':id' => $data['id']]);

            echo json_encode([
                'success' => true,
                'message' => 'Social network deleted successfully'
            ]);

        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid type']);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    }
}
