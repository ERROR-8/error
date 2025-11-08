<?php
include("db.php");

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  if ($password == $confirm) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed')";
    if (mysqli_query($conn, $sql)) {
      echo "<script>alert('Registration successful! You can log in now.'); window.location='login.php';</script>";
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  } else {
    echo "<script>alert('Passwords do not match!');</script>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
</head>
<body>
  <h2>Register Here</h2>
  <form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm" required><br><br>

    <input type="submit" name="submit" value="Register">
  </form>
  <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
