<?php
include("connection.php");
session_start();

$notice = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE student_email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);

        if (password_verify($password, $student['student_password'])) {
            $_SESSION['student_name'] = $student['student_name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $notice = "Incorrect password!";
        }
    } else {
        $notice = "No student found with that email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Login</title>
  <style>
    body{font-family:Arial;margin:40px}
    input{padding:8px;width:100%;margin:6px 0}
    button{padding:8px 15px}
  </style>
</head>
<body>
  <h2>Login to Student Dashboard</h2>
  <?php if($notice) echo "<p style='color:red;'>$notice</p>"; ?>

  <form method="POST">
    <label>Email</label><br>
    <input type="email" name="email" required><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br>

    <button type="submit" name="login">Login</button>
  </form>

  <p>Don’t have an account? <a href="signup.php">Sign Up</a></p>
</body>
</html>
