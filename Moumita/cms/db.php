<?php
session_start();

$dsn = "mysql:host=127.0.0.1;dbname=simplepress5;charset=utf8mb4";
$user = "root";
$pass = "";

try {
  $pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);
} catch (PDOException $e) {
  die("Database error.");
}

function clean($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
