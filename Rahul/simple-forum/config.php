<?php
// config.php
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'quick_forum2';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("DB connect failed: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
session_start();
