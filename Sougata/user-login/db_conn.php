<?php
// Lightweight MySQLi bootstrap for the auth component

define('AUTH_DB_HOST', '127.0.0.1');
define('AUTH_DB_USER', 'auth_app_usr');
define('AUTH_DB_PASS', 'auth_app_pwd');
define('AUTH_DB_NAME', 'user_auth_v7');

$auth_conn = mysqli_init();

if (!@mysqli_real_connect($auth_conn, AUTH_DB_HOST, AUTH_DB_USER, AUTH_DB_PASS, AUTH_DB_NAME)) {
    error_log('AUTH DB connection error: ' . mysqli_connect_error());
    http_response_code(500);
    exit('Database connection failed. Please try again later.');
}

$auth_conn->set_charset('utf8mb4');
?>