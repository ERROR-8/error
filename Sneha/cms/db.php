<?php
session_start();

$dsn = "mysql:host=127.0.0.1;dbname=mysimplecms;charset=utf8mb4"; 
$user = "root";
$pass = "";

try {
    $db_conn = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed."); 
}

function sanitize_output($text) { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
?>