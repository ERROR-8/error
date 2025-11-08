<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "student_login";

$conn = mysqli_connect($server, $user, $pass, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
