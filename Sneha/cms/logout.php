<?php
require 'db.php';
$_SESSION = [];
session_destroy();
header('Location: home.php'); exit;