<?php
// Simple DB bootstrap using mysqli (keeps the original procedural style)

// DB settings
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'forum_dev');
define('DB_PASS', 'forum_pass');
define('DB_NAME', 'simple_forum_reimplement');

// Connect
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$link) {
    error_log('DB connection error: ' . mysqli_connect_error());
    http_response_code(500);
    exit('Database connection failed.');
}

// Ensure UTF-8
mysqli_set_charset($link, 'utf8mb4');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>