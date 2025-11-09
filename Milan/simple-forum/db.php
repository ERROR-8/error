<?php
$DB_HOST_CONST = '127.0.0.1';
$DB_USER_CONST = 'forum_dev';
$DB_PASS_CONST = 'forum_pass';
$DB_NAME_CONST = 'simple_forum_reimplement';

$link = mysqli_connect($DB_HOST_CONST, $DB_USER_CONST, $DB_PASS_CONST, $DB_NAME_CONST);

if (!$link) {
    die("Connection Failed: " . mysqli_connect_error());
}

mysqli_set_charset($link, 'utf8mb4');

session_start();
?>