<?php
$HOST = '127.0.0.1';
$DB_USR = 'forum_minimal';
$DB_PWD = 'forum_temp_pass';
$DB_NM = 'forum_v4_minimal';

$conn = mysqli_connect($HOST, $DB_USR, $DB_PWD, $DB_NM);

if (mysqli_connect_errno()) {
    die("DB Error: " . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');

session_start();
?>