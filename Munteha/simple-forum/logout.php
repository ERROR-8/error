<?php
// logout.php
require 'config.php';
$_SESSION = [];
session_destroy();
header('Location: home.php');
exit;
