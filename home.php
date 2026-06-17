<?php
require_once 'config.php';
require_once 'utils.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
            color: white;
        }

        .header h1 {
            font-size: 48px;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 18px;
            opacity: 0.95;
            text-shadow: 0 1px 5px rgba(0,0,0,0.2);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .card-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .card h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 22px;
        }

        .card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .card a {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .card a:hover {
            border-color: #667eea;
            background: white;
            color: #667eea;
        }

        .admin-section {
            background: white;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-top: 30px;
        }

        .admin-section h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .admin-btn {
            display: inline-block;
            background: #ff6b6b;
            color: white;
            padding: 12px 40px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .admin-btn:hover {
            border-color: #ff6b6b;
            background: white;
            color: #ff6b6b;
        }

        .stats {
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .stats-item {
            display: inline-block;
            margin: 10px 20px;
        }

        .stats-value {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
        }

        .stats-label {
            color: #666;
            font-size: 13px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 36px;
            }
            .grid {
                grid-template-columns: 1fr;
            }
            .card {
                padding: 20px;
            }
            .card-icon {
                font-size: 36px;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 24px;
            }
            .header p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 <?php echo APP_NAME; ?></h1>
            <p>Educational Security Demonstration Platform</p>
        </div>

        <div class="grid">
            <div class="card">
                <div class="card-icon">🐙</div>
                <h3>GitHub</h3>
                <p>Practice with GitHub's authentication interface and security awareness</p>
                <a href="fake_github_login.php">Access GitHub Login</a>
            </div>

            <div class="card">
                <div class="card-icon">🔍</div>
                <h3>Google</h3>
                <p>Experience Google's sign-in flow and account security features</p>
                <a href="fake_google_login.php">Access Google Login</a>
            </div>

            <div class="card">
                <div class="card-icon">💻</div>
                <h3>Microsoft</h3>
                <p>Learn about Microsoft account protection mechanisms</p>
                <a href="fake_microsoft_login.php">Access Microsoft Login</a>
            </div>

            <div class="card">
                <div class="card-icon">💼</div>
                <h3>LinkedIn</h3>
                <p>Understand professional network security best practices</p>
                <a href="fake_linkedin_login.php">Access LinkedIn Login</a>
            </div>

            <div class="card">
                <div class="card-icon">𝕏</div>
                <h3>Twitter/X</h3>
                <p>Explore social media authentication security measures</p>
                <a href="fake_twitter_login.php">Access Twitter/X Login</a>
            </div>

            <div class="card">
                <div class="card-icon">🎮</div>
                <h3>Hacker Terminal</h3>
                <p>Interactive terminal experience and security quiz</p>
                <a href="index.php?guest">Enter Terminal</a>
            </div>
        </div>

        <div class="admin-section">
            <h2>🔐 Administrator Panel</h2>
            <p style="color: #666; margin-bottom: 20px;">Monitor and manage captured data in real-time</p>
            <a href="admin.php" class="admin-btn">Open Admin Dashboard</a>
        </div>

        <div class="stats">
            <?php 
            $stats = getStatistics();
            ?>
            <div class="stats-item">
                <div class="stats-value"><?php echo $stats['total_captures']; ?></div>
                <div class="stats-label">Total Captures</div>
            </div>
            <div class="stats-item">
                <div class="stats-value"><?php echo count($stats['platforms']); ?></div>
                <div class="stats-label">Platforms</div>
            </div>
            <div class="stats-item">
                <div class="stats-value"><?php echo count($stats['ips']); ?></div>
                <div class="stats-label">Unique IPs</div>
            </div>
        </div>
    </div>
</body>
</html>
