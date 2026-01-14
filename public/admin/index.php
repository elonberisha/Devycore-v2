<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Devycore</title>

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
            font-size: 28px;
            font-weight: 700;
        }

        .user-info {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .user-name {
            color: #888;
            font-size: 14px;
        }

        .btn-logout {
            background: #ff0055;
            color: white;
            border: 2px solid #ff0055;
            padding: 8px 16px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: transparent;
            color: #ff0055;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #1a1a1a;
            border: 2px solid #333;
            padding: 20px;
            transition: border-color 0.2s;
        }

        .stat-card:hover {
            border-color: #00ff88;
        }

        .stat-label {
            color: #888;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #00ff88;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            color: #00ff88;
            font-size: 20px;
        }

        .btn-add {
            background: #00ff88;
            color: #0a0a0a;
            border: 2px solid #00ff88;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            transition: all 0.2s;
        }

        .btn-add:hover {
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #ff0055;
        }

        .projects-table {
            width: 100%;
            background: #1a1a1a;
            border: 2px solid #333;
            border-collapse: collapse;
        }

        .projects-table th,
        .projects-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        .projects-table th {
            background: #0a0a0a;
            color: #00ff88;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .projects-table tr:hover {
            background: rgba(0, 255, 136, 0.05);
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            border: 1px solid;
        }

        .badge-featured {
            color: #00ff88;
            border-color: #00ff88;
        }

        .badge-normal {
            color: #888;
            border-color: #888;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border: 1px solid;
            background: transparent;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-edit {
            color: #00ff88;
            border-color: #00ff88;
        }

        .btn-edit:hover {
            background: #00ff88;
            color: #0a0a0a;
        }

        .btn-delete {
            color: #ff0055;
            border-color: #ff0055;
        }

        .btn-delete:hover {
            background: #ff0055;
            color: white;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #888;
        }

        .error {
            background: #ff0055;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
        }

        .tech-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .tech-tag {
            background: #333;
            color: #00ff88;
            padding: 2px 6px;
            font-size: 10px;
            border: 1px solid #00ff88;
        }

        @media (max-width: 768px) {
            .projects-table {
                font-size: 12px;
            }

            .projects-table th,
            .projects-table td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>ADMIN DASHBOARD</h1>
        <div class="user-info">
            <span class="user-name">Logged in as: <strong id="username">-</strong></span>
            <button class="btn-logout" onclick="logout()">Logout</button>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Projects</div>
            <div class="stat-value" id="totalProjects">-</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Featured</div>
            <div class="stat-value" id="featuredProjects">-</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Contacts</div>
            <div class="stat-value" id="totalContacts">-</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Discounts</div>
            <div class="stat-value" id="totalDiscounts">-</div>
        </div>
    </div>

    <div id="errorMessage" class="error" style="display: none;"></div>

    <div class="section-header">
        <h2>Projects</h2>
        <button class="btn-add" onclick="window.location.href='add-project.php'">
            + Add New Project
        </button>
    </div>

    <div id="projectsContainer">
        <div class="loading">Loading projects...</div>
    </div>

    <script>
        // Check authentication
        const authToken = sessionStorage.getItem('auth_token');
        const userData = sessionStorage.getItem('user_data');

        if (!authToken || !userData) {
            window.location.href = 'login.php';
        }

        const user = JSON.parse(userData);
        document.getElementById('username').textContent = user.username;

        // Logout function
        async function logout() {
            try {
                await fetch('/devycore-v2/public/api/auth.php/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + authToken
                    }
                });
            } catch (error) {
                console.error('Logout error:', error);
            }

            sessionStorage.clear();
            window.location.href = 'login.php';
        }

        // Load projects
        async function loadProjects() {
            try {
                const response = await fetch('/devycore-v2/public/api/projects.php');
                const data = await response.json();

                if (data.success && data.data) {
                    renderProjects(data.data);
                    updateStats(data.data);
                } else {
                    showError('Failed to load projects');
                }
            } catch (error) {
                console.error('Load error:', error);
                showError('Error loading projects. Check console.');
            }
        }

        function renderProjects(projects) {
            const container = document.getElementById('projectsContainer');

            if (projects.length === 0) {
                container.innerHTML = '<div class="loading">No projects yet. Click "Add New Project" to create one.</div>';
                return;
            }

            const table = `
                <table class="projects-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Technologies</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${projects.map(project => `
                            <tr>
                                <td><strong>${escapeHtml(project.title)}</strong></td>
                                <td><a href="${escapeHtml(project.url)}" target="_blank" style="color: #00ff88;">${truncate(project.url, 40)}</a></td>
                                <td>
                                    <div class="tech-tags">
                                        ${project.technologies ? JSON.parse(project.technologies).map(tech =>
                                            `<span class="tech-tag">${escapeHtml(tech)}</span>`
                                        ).join('') : '-'}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge ${project.featured ? 'badge-featured' : 'badge-normal'}">
                                        ${project.featured ? 'Featured' : 'Normal'}
                                    </span>
                                </td>
                                <td>${project.display_order}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-sm btn-edit" onclick="editProject(${project.id})">Edit</button>
                                        <button class="btn-sm btn-delete" onclick="deleteProject(${project.id})">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;

            container.innerHTML = table;
        }

        function updateStats(projects) {
            document.getElementById('totalProjects').textContent = projects.length;
            document.getElementById('featuredProjects').textContent = projects.filter(p => p.featured).length;
            // TODO: Load actual contact/discount counts from API
            document.getElementById('totalContacts').textContent = '0';
            document.getElementById('totalDiscounts').textContent = '0';
        }

        function editProject(id) {
            window.location.href = `edit-project.php?id=${id}`;
        }

        async function deleteProject(id) {
            if (!confirm('Are you sure you want to delete this project?')) {
                return;
            }

            try {
                const response = await fetch(`/devycore-v2/public/api/projects.php/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + authToken
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('Project deleted successfully!');
                    loadProjects();
                } else {
                    alert('Failed to delete project: ' + data.message);
                }
            } catch (error) {
                console.error('Delete error:', error);
                alert('Error deleting project');
            }
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function truncate(str, length) {
            return str.length > length ? str.substring(0, length) + '...' : str;
        }

        // Load projects on page load
        loadProjects();
    </script>
</body>
</html>
