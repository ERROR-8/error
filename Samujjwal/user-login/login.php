<?php
include("db.php");
session_start();

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    if (password_verify($password, $user['password'])) {
      $_SESSION['username'] = $user['username'];
      header("Location: welcome.php");
      exit;
    } else {
      echo "<script>alert('Wrong password!');</script>";
    }
  } else {
    echo "<script>alert('User not found!');</script>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
  <h2>Login Here</h2>
  <form method="POST">
    <label>Username or Email:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <input type="submit" name="login" value="Login">
  </form>
  <p>Don’t have an account? <a href="register.php">Register here</a></p>
</body>
</html>
