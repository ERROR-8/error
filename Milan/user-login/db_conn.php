<?php
// Database configuration
const APP_HOST = 'localhost';
const APP_DB_USER = 'auth_app_usr';
const APP_DB_PASS = 'auth_app_pwd';
const APP_DB_NAME = 'user_auth_v7';

// Establish connection
$auth_conn = new mysqli(APP_HOST, APP_DB_USER, APP_DB_PASS, APP_DB_NAME);

if ($auth_conn->connect_errno) {
    die("SYSTEM ERROR: DB connection failed: " . $auth_conn->connect_error);
}

$auth_conn->set_charset('utf8');
?>