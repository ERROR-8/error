<?php
$conn = mysqli_connect("localhost", "root", "", "easy_forum");
if (!$conn) die("Database error: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8mb4");
session_start();
?>
