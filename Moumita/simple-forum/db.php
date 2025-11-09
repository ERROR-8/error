<?php
// db.php
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'simple_forum_sep';

$mysqli = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$mysqli) {
    die("DB connection error: " . mysqli_connect_error());
}
mysqli_set_charset($mysqli, 'utf8mb4');
session_start();
?>