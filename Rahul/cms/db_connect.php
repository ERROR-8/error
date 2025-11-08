<?php
// db_connect.php
session_start();

$DB_HOST = '127.0.0.1';
$DB_NAME = 'friend3_blog';
$DB_USER = 'root';
$DB_PASS = '';

$dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $db = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
  die("DB connect failed.");
}

function safe($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
