<?php
/**
 * Configuration File
 * Centralized settings for the password capture project
 */

// Application Settings
define('APP_NAME', 'I Can See U - Security Demo');
define('APP_VERSION', '2.0.0');
define('LOG_FILE', __DIR__ . '/captured.log');
define('ADMIN_PASSWORD', 'blackeye0335'); // Change this in production!
define('MAX_LOG_ENTRIES', 1000);

// Supported Platforms
define('PLATFORMS', [
    'github' => ['name' => 'GitHub', 'icon' => '🐙'],
    'google' => ['name' => 'Google', 'icon' => '🔍'],
    'microsoft' => ['name' => 'Microsoft', 'icon' => '💻'],
    'linkedin' => ['name' => 'LinkedIn', 'icon' => '💼'],
    'twitter' => ['name' => 'Twitter/X', 'icon' => '𝕏'],
    'facebook' => ['name' => 'Facebook', 'icon' => '📘'],
    'amazon' => ['name' => 'Amazon', 'icon' => '📦'],
    'apple' => ['name' => 'Apple', 'icon' => '🍎'],
]);

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
session_start();

// Error Logging
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Helper function to get client IP
function getClientIP() {
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

// Helper function to get user agent
function getUserAgent() {
    return $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
}

// Helper function to detect device type
function getDeviceType() {
    $ua = getUserAgent();
    if (preg_match('/(mobile|android|iphone|ipad|tablet)/i', $ua)) {
        return 'Mobile';
    }
    return 'Desktop';
}
