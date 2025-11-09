<?php
session_start();

$dbHost = '127.0.0.1';
$dbName = 'blog_assignment_db';
$dbUser = 'blog_user';
$dbPass = 'strong_password';

$pdoDsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";

$pdoOptions = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $dbConnect = new PDO($pdoDsn, $dbUser, $dbPass, $pdoOptions);
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("A system error occurred. Please try again later.");
}

function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
?>