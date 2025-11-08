<?php
session_start();

if (!isset($_SESSION['student_name'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Dashboard</title>
</head>
<body style="font-family:Arial;margin:40px;">
  <h2>Welcome, <?php echo $_SESSION['student_name']; ?> 🎓</h2>
  <p>You have successfully logged in to the student portal.</p>
  <a href="signout.php">Logout</a>
</body>
</html>
