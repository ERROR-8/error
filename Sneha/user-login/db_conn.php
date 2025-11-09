<?php
$HOST_ADDR = 'localhost';
$DB_ACC = 'user_auth_acc';
$DB_SECRET = 'auth_secret';
$DB_LINK = 'unique_auth_db';

$db_instance = new mysqli($HOST_ADDR, $DB_ACC, $DB_SECRET, $DB_LINK);

if ($db_instance->connect_errno) {
    die("Connection failed: " . $db_instance->connect_error);
}

$db_instance->set_charset('utf8');
?>