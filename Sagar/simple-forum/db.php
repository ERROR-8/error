<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "mini_forumx";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) die("DB Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8mb4");
session_start();
?>
