<?php
/**
 * Projects API Endpoint
 * Handles CRUD operations for projects
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/utils/helpers.php';
require_once __DIR__ . '/../../src/utils/validation.php';

use Devycore\Database;
use Devycore\Auth;

// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $db = Database::getInstance();
    $auth = new Auth($db);
    $method = $_SERVER['REQUEST_METHOD'];
    $requestUri = $_SERVER['REQUEST_URI'];

    // Parse project ID from URI
    $projectId = null;
    if (preg_match('/\/api\/projects\/(\d+)/', $requestUri, $matches)) {
        $projectId = (int)$matches[1];
    }

    // GET /api/projects - Get all projects (PUBLIC)
    if ($method === 'GET' && !$projectId) {
        $projects = $db->fetchAll(
            "SELECT id, title, url, description, image_path, technologies, featured, display_order, created_at, updated_at
             FROM projects
             ORDER BY display_order ASC, created_at DESC"
        );

        // Parse JSON technologies
        foreach ($projects as &$project) {
            if ($project['technologies']) {
                $project['technologies'] = json_decode($project['technologies'], true);
            }
            $project['featured'] = (bool)$project['featured'];
        }

        successResponse(['projects' => $projects]);
    }

    // GET /api/projects/{id} - Get single project (PUBLIC)
    elseif ($method === 'GET' && $projectId) {
        $project = $db->fetchOne(
            "SELECT * FROM projects WHERE id = ?",
            [$projectId]
        );

        if (!$project) {
            errorResponse('Project not found', 404);
        }

        if ($project['technologies']) {
            $project['technologies'] = json_decode($project['technologies'], true);
        }
        $project['featured'] = (bool)$project['featured'];

        successResponse(['project' => $project]);
    }

    // POST /api/projects - Create project (AUTH REQUIRED)
    elseif ($method === 'POST' && !$projectId) {
        $token = getBearerToken();
        if (!$token) {
            errorResponse('Authentication required', 401);
        }

        $user = $auth->validateToken($token);
        if (!$user) {
            errorResponse('Invalid or expired token', 401);
        }

        // Get form data
        $data = $_POST;

        // Validate data
        $validation = validateProjectData($data);
        if (!$validation['valid']) {
            errorResponse('Validation failed', 400, ['errors' => $validation['errors']]);
        }

        // Sanitize data
        $sanitized = sanitizeProjectData($data);

        // Handle image upload
        $imagePath = null;
        if (!empty($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $imageValidation = validateImageUpload($_FILES['image']);

            if (!$imageValidation['valid']) {
                errorResponse($imageValidation['error'], 400);
            }

            // Upload directory
            $uploadDir = __DIR__ . '/../admin/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $filename = sanitizeFilename($_FILES['image']['name']);
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                errorResponse('Failed to upload image', 500);
            }

            $imagePath = '/admin/uploads/' . $filename;
        }

        // Generate project ID (timestamp in milliseconds)
        $projectId = (int)(microtime(true) * 1000);

        // Insert project
        $db->query(
            "INSERT INTO projects (id, title, url, description, image_path, technologies, featured, display_order)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $projectId,
                $sanitized['title'],
                $sanitized['url'],
                $sanitized['description'],
                $imagePath,
                $sanitized['technologies'],
                $sanitized['featured'] ? 1 : 0,
                $sanitized['display_order']
            ]
        );

        logAudit('project_created', [
            'project_id' => $projectId,
            'title' => $sanitized['title']
        ], $user['id']);

        successResponse([
            'project' => [
                'id' => $projectId,
                'title' => $sanitized['title'],
                'url' => $sanitized['url'],
                'description' => $sanitized['description'],
                'image_path' => $imagePath,
                'technologies' => $sanitized['technologies'] ? json_decode($sanitized['technologies'], true) : null,
                'featured' => $sanitized['featured']
            ]
        ], 'Project created successfully');
    }

    // PUT /api/projects/{id} - Update project (AUTH REQUIRED)
    elseif ($method === 'PUT' && $projectId) {
        $token = getBearerToken();
        if (!$token) {
            errorResponse('Authentication required', 401);
        }

        $user = $auth->validateToken($token);
        if (!$user) {
            errorResponse('Invalid or expired token', 401);
        }

        // Check if project exists
        $existingProject = $db->fetchOne("SELECT * FROM projects WHERE id = ?", [$projectId]);
        if (!$existingProject) {
            errorResponse('Project not found', 404);
        }

        // Get form data (PUT with multipart/form-data)
        parse_str(file_get_contents("php://input"), $_PUT);
        $data = !empty($_PUT) ? $_PUT : $_POST;

        // Validate data
        $validation = validateProjectData($data);
        if (!$validation['valid']) {
            errorResponse('Validation failed', 400, ['errors' => $validation['errors']]);
        }

        // Sanitize data
        $sanitized = sanitizeProjectData($data);

        // Handle image upload (if new image provided)
        $imagePath = $existingProject['image_path'];
        if (!empty($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $imageValidation = validateImageUpload($_FILES['image']);

            if (!$imageValidation['valid']) {
                errorResponse($imageValidation['error'], 400);
            }

            // Delete old image
            if ($existingProject['image_path']) {
                $oldImagePath = __DIR__ . '/..' . $existingProject['image_path'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload new image
            $uploadDir = __DIR__ . '/../admin/uploads/';
            $filename = sanitizeFilename($_FILES['image']['name']);
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                errorResponse('Failed to upload image', 500);
            }

            $imagePath = '/admin/uploads/' . $filename;
        }

        // Update project
        $db->execute(
            "UPDATE projects
             SET title = ?, url = ?, description = ?, image_path = ?, technologies = ?, featured = ?, display_order = ?, updated_at = NOW()
             WHERE id = ?",
            [
                $sanitized['title'],
                $sanitized['url'],
                $sanitized['description'],
                $imagePath,
                $sanitized['technologies'],
                $sanitized['featured'] ? 1 : 0,
                $sanitized['display_order'],
                $projectId
            ]
        );

        logAudit('project_updated', [
            'project_id' => $projectId,
            'title' => $sanitized['title']
        ], $user['id']);

        successResponse([
            'project' => [
                'id' => $projectId,
                'title' => $sanitized['title'],
                'url' => $sanitized['url'],
                'description' => $sanitized['description'],
                'image_path' => $imagePath,
                'technologies' => $sanitized['technologies'] ? json_decode($sanitized['technologies'], true) : null,
                'featured' => $sanitized['featured']
            ]
        ], 'Project updated successfully');
    }

    // DELETE /api/projects/{id} - Delete project (AUTH REQUIRED)
    elseif ($method === 'DELETE' && $projectId) {
        $token = getBearerToken();
        if (!$token) {
            errorResponse('Authentication required', 401);
        }

        $user = $auth->validateToken($token);
        if (!$user) {
            errorResponse('Invalid or expired token', 401);
        }

        // Get project to delete image
        $project = $db->fetchOne("SELECT image_path FROM projects WHERE id = ?", [$projectId]);
        if (!$project) {
            errorResponse('Project not found', 404);
        }

        // Delete image file
        if ($project['image_path']) {
            $imagePath = __DIR__ . '/..' . $project['image_path'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete project
        $affected = $db->execute("DELETE FROM projects WHERE id = ?", [$projectId]);

        if ($affected === 0) {
            errorResponse('Project not found', 404);
        }

        logAudit('project_deleted', ['project_id' => $projectId], $user['id']);

        successResponse([], 'Project deleted successfully');
    }

    else {
        errorResponse('Method not allowed', 405);
    }

} catch (Exception $e) {
    error_log("Projects API error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
