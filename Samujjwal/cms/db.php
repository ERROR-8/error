<?php
// db.php
session_start();

$host = '127.0.0.1';
$db   = 'simple_cms_clean';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  die("DB connection failed.");
}

function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
