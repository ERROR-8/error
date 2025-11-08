<?php
// db.php - simple mysqli connection + session
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'simpleblog_f2';

$mysqli = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$mysqli) {
    die("DB connection error: " . mysqli_connect_error());
}
mysqli_set_charset($mysqli, 'utf8mb4');
session_start();

function esc($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
