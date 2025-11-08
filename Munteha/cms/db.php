<?php
// db.php (MySQLi OO)
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'buddy_blog4';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("DB error: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
session_start();

function esc($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
