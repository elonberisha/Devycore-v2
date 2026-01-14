<?php
// No CSP headers for admin panel
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['auth_token'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Devycore</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Space Grotesk', -apple-system, sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            background: #1a1a1a;
            border: 3px solid #00ff88;
            padding: 40px;
            box-shadow: 8px 8px 0 rgba(0, 255, 136, 0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 32px;
            color: #00ff88;
            font-weight: 700;
            letter-spacing: -1px;
        }

        .logo p {
            color: #888;
            font-size: 14px;
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 20px;
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

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            background: #0a0a0a;
            border: 2px solid #333;
            color: #fff;
            font-size: 16px;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #00ff88;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: #00ff88;
            color: #0a0a0a;
            border: none;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn:hover {
            background: #00dd77;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #ff0055;
        }

        .btn:active {
            transform: translate(0, 0);
            box-shadow: none;
        }

        .btn:disabled {
            background: #333;
            color: #666;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .error-message {
            background: #ff0055;
            color: #fff;
            padding: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #ff0055;
            font-size: 14px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .loading {
            text-align: center;
            color: #888;
            margin-top: 20px;
            font-size: 14px;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #00ff88;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: #ff0055;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .logo h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>DEVYCORE</h1>
            <p>Admin Panel</p>
        </div>

        <div id="errorMessage" class="error-message"></div>

        <form id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    autocomplete="username"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn" id="loginBtn">
                Login
            </button>
        </form>

        <div class="back-link">
            <a href="/devycore-v2/public/">← Back to Homepage</a>
        </div>
    </div>

    <script>
        const form = document.getElementById('loginForm');
        const errorMessage = document.getElementById('errorMessage');
        const loginBtn = document.getElementById('loginBtn');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Get form data
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Hide previous errors
            errorMessage.classList.remove('show');
            errorMessage.textContent = '';

            // Disable button
            loginBtn.disabled = true;
            loginBtn.textContent = 'Logging in...';

            try {
                const response = await fetch('/devycore-v2/public/api/auth.php/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username, password })
                });

                const data = await response.json();

                if (data.success && data.data.token) {
                    // Store token in session
                    sessionStorage.setItem('auth_token', data.data.token);
                    sessionStorage.setItem('user_data', JSON.stringify(data.data.user));

                    // Redirect to dashboard
                    window.location.href = 'index.php';
                } else {
                    // Show error
                    errorMessage.textContent = data.message || 'Login failed. Please try again.';
                    errorMessage.classList.add('show');

                    loginBtn.disabled = false;
                    loginBtn.textContent = 'Login';
                }
            } catch (error) {
                console.error('Login error:', error);
                errorMessage.textContent = 'Connection error. Please check if the server is running.';
                errorMessage.classList.add('show');

                loginBtn.disabled = false;
                loginBtn.textContent = 'Login';
            }
        });

        // Auto-focus username field
        document.getElementById('username').focus();
    </script>
</body>
</html>
