<?php
/**
 * API Endpoint - Get Statistics
 * Returns captured statistics in JSON format
 * 
 * Usage: http://127.0.0.1:8000/api.php?action=stats
 */

require_once 'utils.php';

// Set JSON header
header('Content-Type: application/json');

// Get action parameter
$action = $_GET['action'] ?? null;

// Allow CORS for educational purposes
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Handle different actions
switch ($action) {
    case 'stats':
        $stats = getStatistics();
        echo json_encode([
            'success' => true,
            'data' => $stats,
            'timestamp' => date('Y-m-d H:i:s'),
        ], JSON_PRETTY_PRINT);
        break;

    case 'entries':
        $limit = $_GET['limit'] ?? 50;
        $entries = getLogEntries((int)$limit);
        $parsed = [];
        foreach ($entries as $line) {
            $data = parseLogLine($line);
            if ($data) {
                $parsed[] = $data;
            }
        }
        echo json_encode([
            'success' => true,
            'data' => $parsed,
            'count' => count($parsed),
        ], JSON_PRETTY_PRINT);
        break;

    case 'health':
        echo json_encode([
            'success' => true,
            'status' => 'online',
            'version' => APP_VERSION,
            'time' => date('Y-m-d H:i:s'),
        ], JSON_PRETTY_PRINT);
        break;

    default:
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Invalid action. Available actions: stats, entries, health',
        ], JSON_PRETTY_PRINT);
        break;
}
?>
