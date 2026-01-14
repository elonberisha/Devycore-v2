<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project - Admin - Devycore</title>

    <link rel="stylesheet" href="/devycore-v2/public/assets/css/base.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/components.css">

    <style>
        body {
            background: #0a0a0a;
            color: #ffffff;
            padding: 20px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 2px solid #00ff88;
            margin-bottom: 30px;
        }

        .admin-header h1 {
            color: #00ff88;
            font-size: 24px;
        }

        .back-link {
            color: #00ff88;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            color: #ff0055;
        }

        .form-container {
            max-width: 800px;
            background: #1a1a1a;
            border: 2px solid #333;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            color: #00ff88;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        label .required {
            color: #ff0055;
        }

        input[type="text"],
        input[type="url"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            background: #0a0a0a;
            border: 2px solid #333;
            color: #fff;
            font-size: 14px;
            font-family: inherit;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #00ff88;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .tech-input-group {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .tech-input-group input {
            flex: 1;
        }

        .tech-input-group button {
            padding: 12px 20px;
            background: #00ff88;
            color: #0a0a0a;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .tech-input-group button:hover {
            background: #00dd77;
        }

        .tech-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .tech-item {
            background: #333;
            color: #00ff88;
            padding: 6px 12px;
            font-size: 12px;
            border: 1px solid #00ff88;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tech-item button {
            background: none;
            border: none;
            color: #ff0055;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            line-height: 1;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #333;
        }

        .btn {
            padding: 14px 28px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            border: 2px solid;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #00ff88;
            color: #0a0a0a;
            border-color: #00ff88;
        }

        .btn-primary:hover {
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #ff0055;
        }

        .btn-secondary {
            background: transparent;
            color: #888;
            border-color: #888;
        }

        .btn-secondary:hover {
            color: #fff;
            border-color: #fff;
        }

        .btn:disabled {
            background: #333;
            color: #666;
            border-color: #333;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .message-error {
            background: rgba(255, 0, 85, 0.1);
            border-color: #ff0055;
            color: #ff0055;
        }

        .message-success {
            background: rgba(0, 255, 136, 0.1);
            border-color: #00ff88;
            color: #00ff88;
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-preview {
            margin-top: 10px;
            max-width: 300px;
        }

        .file-preview img {
            width: 100%;
            border: 2px solid #333;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>ADD NEW PROJECT</h1>
        <a href="index.php" class="back-link">← Back to Dashboard</a>
    </div>

    <div class="form-container">
        <div id="message" style="display: none;"></div>

        <form id="projectForm">
            <div class="form-group">
                <label for="title">
                    Project Title <span class="required">*</span>
                </label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="url">
                    Project URL <span class="required">*</span>
                </label>
                <input type="url" id="url" name="url" required placeholder="https://example.com">
            </div>

            <div class="form-group">
                <label for="description">
                    Description
                </label>
                <textarea id="description" name="description" placeholder="Brief description of the project..."></textarea>
            </div>

            <div class="form-group">
                <label>
                    Technologies
                </label>
                <div class="tech-input-group">
                    <input type="text" id="techInput" placeholder="Enter technology name">
                    <button type="button" onclick="addTechnology()">+ Add</button>
                </div>
                <div class="tech-list" id="techList"></div>
                <input type="hidden" id="technologies" name="technologies">
            </div>

            <div class="form-group">
                <label for="image">
                    Project Image
                </label>
                <input type="file" id="image" name="image" accept="image/*">
                <div class="file-preview" id="imagePreview"></div>
            </div>

            <div class="form-group">
                <label for="display_order">
                    Display Order
                </label>
                <input type="number" id="display_order" name="display_order" value="0" min="0">
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="featured" name="featured">
                    <label for="featured" style="margin: 0; text-transform: none;">
                        Featured Project (show on homepage)
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    Create Project
                </button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <script>
        // Check authentication
        const authToken = sessionStorage.getItem('auth_token');
        if (!authToken) {
            window.location.href = 'login.php';
        }

        const technologies = [];

        // Add technology to list
        function addTechnology() {
            const input = document.getElementById('techInput');
            const tech = input.value.trim();

            if (tech && !technologies.includes(tech)) {
                technologies.push(tech);
                updateTechList();
                input.value = '';
            }
        }

        // Remove technology from list
        function removeTechnology(tech) {
            const index = technologies.indexOf(tech);
            if (index > -1) {
                technologies.splice(index, 1);
                updateTechList();
            }
        }

        // Update technologies display
        function updateTechList() {
            const list = document.getElementById('techList');
            const hidden = document.getElementById('technologies');

            list.innerHTML = technologies.map(tech => `
                <div class="tech-item">
                    ${escapeHtml(tech)}
                    <button type="button" onclick="removeTechnology('${tech.replace(/'/g, '\\\'')}')">&times;</button>
                </div>
            `).join('');

            hidden.value = JSON.stringify(technologies);
        }

        // Allow adding tech with Enter key
        document.getElementById('techInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                addTechnology();
            }
        });

        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });

        // Handle form submission
        document.getElementById('projectForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const messageDiv = document.getElementById('message');

            submitBtn.disabled = true;
            submitBtn.textContent = 'Creating...';

            // Prepare form data
            const formData = new FormData();
            formData.append('title', document.getElementById('title').value);
            formData.append('url', document.getElementById('url').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('technologies', JSON.stringify(technologies));
            formData.append('display_order', document.getElementById('display_order').value);
            formData.append('featured', document.getElementById('featured').checked ? '1' : '0');

            const imageFile = document.getElementById('image').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            try {
                const response = await fetch('/devycore-v2/public/api/projects.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + authToken
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showMessage('Project created successfully! Redirecting...', 'success');
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1500);
                } else {
                    showMessage('Error: ' + (data.message || 'Failed to create project'), 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Create Project';
                }
            } catch (error) {
                console.error('Submit error:', error);
                showMessage('Connection error. Please try again.', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Create Project';
            }
        });

        function showMessage(text, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.className = 'message message-' + type;
            messageDiv.textContent = text;
            messageDiv.style.display = 'block';

            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 5000);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
