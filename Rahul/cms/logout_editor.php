<?php
require 'db_connect.php';
$_SESSION = [];
session_destroy();
header('Location: home.php'); exit;
