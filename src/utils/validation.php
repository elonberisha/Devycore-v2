<?php
/**
 * Validation Functions
 * Input validation and sanitization
 */

/**
 * Validate contact form data
 * @param array $data Form data
 * @return array ['valid' => bool, 'errors' => array]
 */
function validateContactForm(array $data): array {
    $errors = [];

    // Check honeypot field
    if (!empty($data['website'])) {
        return ['valid' => false, 'errors' => ['spam' => 'Spam detected']];
    }

    // Required fields - ONLY name, email, project_type, and message
    if (empty($data['name']) || strlen($data['name']) < 2) {
        $errors['name'] = 'Name is required (min 2 characters)';
    }

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email address is required';
    }

    if (empty($data['message']) || strlen($data['message']) < 10) {
        $errors['message'] = 'Message is required (min 10 characters)';
    }

    if (empty($data['project_type'])) {
        $errors['project_type'] = 'Project type is required';
    }

    // Length limits
    if (!empty($data['name']) && strlen($data['name']) > 255) {
        $errors['name'] = 'Name is too long (max 255 characters)';
    }

    if (!empty($data['message']) && strlen($data['message']) > 5000) {
        $errors['message'] = 'Message is too long (max 5000 characters)';
    }

    // Optional fields - no validation errors, just length checks
    if (!empty($data['phone']) && strlen($data['phone']) > 60) {
        $errors['phone'] = 'Phone number is too long';
    }

    if (!empty($data['company']) && strlen($data['company']) > 255) {
        $errors['company'] = 'Company name is too long';
    }

    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Validate discount form data
 * @param array $data Form data
 * @return array ['valid' => bool, 'errors' => array]
 */
function validateDiscountForm(array $data): array {
    $errors = [];

    // Required fields
    if (empty($data['name']) || strlen($data['name']) < 2) {
        $errors['name'] = 'Name is required (min 2 characters)';
    }

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email address is required';
    }

    // Validate prize code
    if (empty($data['prize']) || !preg_match('/^DISC_(20|30|40|50|60)$/', $data['prize'])) {
        $errors['prize'] = 'Invalid prize code';
    }

    // Length limits
    if (!empty($data['name']) && strlen($data['name']) > 255) {
        $errors['name'] = 'Name is too long (max 255 characters)';
    }

    if (!empty($data['notes']) && strlen($data['notes']) > 800) {
        $errors['notes'] = 'Notes are too long (max 800 characters)';
    }

    if (!empty($data['company']) && strlen($data['company']) > 255) {
        $errors['company'] = 'Company name is too long';
    }

    if (!empty($data['source']) && strlen($data['source']) > 255) {
        $errors['source'] = 'Source is too long';
    }

    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Validate project data
 * @param array $data Project data
 * @return array ['valid' => bool, 'errors' => array]
 */
function validateProjectData(array $data): array {
    $errors = [];

    // Required fields
    if (empty($data['title']) || strlen($data['title']) < 3) {
        $errors['title'] = 'Title is required (min 3 characters)';
    }

    if (empty($data['url']) || !filter_var($data['url'], FILTER_VALIDATE_URL)) {
        $errors['url'] = 'Valid URL is required';
    }

    // Length limits
    if (!empty($data['title']) && strlen($data['title']) > 255) {
        $errors['title'] = 'Title is too long (max 255 characters)';
    }

    if (!empty($data['url']) && strlen($data['url']) > 2048) {
        $errors['url'] = 'URL is too long';
    }

    if (!empty($data['description']) && strlen($data['description']) > 10000) {
        $errors['description'] = 'Description is too long (max 10000 characters)';
    }

    // Validate technologies (if provided)
    if (!empty($data['technologies'])) {
        if (is_string($data['technologies'])) {
            $technologies = json_decode($data['technologies'], true);
            if (!is_array($technologies)) {
                $errors['technologies'] = 'Technologies must be a valid JSON array';
            }
        } elseif (!is_array($data['technologies'])) {
            $errors['technologies'] = 'Technologies must be an array';
        }
    }

    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Validate image upload
 * @param array $file $_FILES array for a file
 * @param int $maxSize Maximum file size in bytes
 * @return array ['valid' => bool, 'error' => string|null]
 */
function validateImageUpload(array $file, int $maxSize = 5242880): array {
    // Check if file was uploaded
    if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return ['valid' => false, 'error' => 'No file uploaded'];
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds server upload limit',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds form upload limit',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
        ];
        return ['valid' => false, 'error' => $errorMessages[$file['error']] ?? 'Unknown upload error'];
    }

    // Check file size
    if ($file['size'] > $maxSize) {
        $maxMB = round($maxSize / 1048576, 1);
        return ['valid' => false, 'error' => "File is too large (max {$maxMB}MB)"];
    }

    // Check MIME type
    $allowedTypes = explode(',', $_ENV['ALLOWED_IMAGE_TYPES'] ?? 'image/jpeg,image/png,image/webp,image/gif');
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedTypes)) {
        return ['valid' => false, 'error' => 'Invalid image type. Allowed: JPEG, PNG, WebP, GIF'];
    }

    // Verify it's actually an image
    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return ['valid' => false, 'error' => 'File is not a valid image'];
    }

    return ['valid' => true, 'error' => null];
}

/**
 * Validate login credentials
 * @param array $data Login data
 * @return array ['valid' => bool, 'errors' => array]
 */
function validateLoginData(array $data): array {
    $errors = [];

    if (empty($data['username']) || strlen($data['username']) < 3) {
        $errors['username'] = 'Username is required (min 3 characters)';
    }

    if (empty($data['password']) || strlen($data['password']) < 6) {
        $errors['password'] = 'Password is required (min 6 characters)';
    }

    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Validate password strength
 * @param string $password
 * @return array ['valid' => bool, 'errors' => array]
 */
function validatePassword(string $password): array {
    $errors = [];

    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters long';
    }

    if (strlen($password) > 100) {
        $errors[] = 'Password is too long (max 100 characters)';
    }

    // Optional: Add more complexity requirements
    // if (!preg_match('/[A-Z]/', $password)) {
    //     $errors[] = 'Password must contain at least one uppercase letter';
    // }

    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Sanitize contact form data
 * @param array $data Raw form data
 * @return array Sanitized data
 */
function sanitizeContactData(array $data): array {
    return [
        'name' => sanitizeString($data['name'] ?? null, 255),
        'email' => filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL),
        'phone' => sanitizeString($data['phone'] ?? null, 60),
        'company' => sanitizeString($data['company'] ?? null, 255),
        'project_type' => sanitizeString($data['project_type'] ?? null, 100),
        'company_type' => sanitizeString($data['company_type'] ?? null, 100),
        'prize' => sanitizeString($data['prize'] ?? null, 20),
        'message' => sanitizeString($data['message'] ?? null, 5000),
        'website' => sanitizeString($data['website'] ?? null, 255), // Honeypot
        'ip_address' => getClientIP(),
        'user_agent' => sanitizeString($_SERVER['HTTP_USER_AGENT'] ?? null, 500)
    ];
}

/**
 * Sanitize discount form data
 * @param array $data Raw form data
 * @return array Sanitized data
 */
function sanitizeDiscountData(array $data): array {
    return [
        'name' => sanitizeString($data['name'] ?? null, 255),
        'email' => filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL),
        'prize' => sanitizeString($data['prize'] ?? null, 20),
        'percentage' => isset($data['prize']) ? (int)str_replace('DISC_', '', $data['prize']) : 0,
        'source' => sanitizeString($data['source'] ?? null, 255),
        'project_type' => sanitizeString($data['project_type'] ?? null, 100),
        'company' => sanitizeString($data['company'] ?? null, 255),
        'notes' => sanitizeString($data['notes'] ?? null, 800),
        'ip_address' => getClientIP()
    ];
}

/**
 * Sanitize project data
 * @param array $data Raw project data
 * @return array Sanitized data
 */
function sanitizeProjectData(array $data): array {
    $sanitized = [
        'title' => sanitizeString($data['title'] ?? null, 255),
        'url' => filter_var($data['url'] ?? '', FILTER_SANITIZE_URL),
        'description' => sanitizeString($data['description'] ?? null, 10000),
        'featured' => !empty($data['featured']) && ($data['featured'] === '1' || $data['featured'] === 'true'),
        'display_order' => isset($data['display_order']) ? (int)$data['display_order'] : 0
    ];

    // Handle technologies (can be JSON string or array)
    if (!empty($data['technologies'])) {
        if (is_string($data['technologies'])) {
            $sanitized['technologies'] = $data['technologies']; // Keep as JSON string
        } elseif (is_array($data['technologies'])) {
            $sanitized['technologies'] = json_encode($data['technologies']);
        }
    } else {
        $sanitized['technologies'] = null;
    }

    return $sanitized;
}
