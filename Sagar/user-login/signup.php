<?php
include("connection.php");

$message = "";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($pass !== $confirm) {
        $message = "Passwords do not match!";
    } else {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO students (student_name, student_email, student_password)
                VALUES ('$name', '$email', '$hashed')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Account created! You can log in now.'); window.location='login.php';</script>";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Sign Up</title>
  <style>
    body{font-family:Arial;margin:40px}
    input{padding:8px;width:100%;margin:6px 0}
    button{padding:8px 15px}
  </style>
</head>
<body>
  <h2>Create Student Account</h2>
  <?php if($message) echo "<p style='color:red;'>$message</p>"; ?>

  <form method="POST">
    <label>Name</label><br>
    <input type="text" name="name" required><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br>

    <label>Confirm Password</label><br>
    <input type="password" name="confirm" required><br>

    <button type="submit" name="register">Sign Up</button>
  </form>

  <p>Already registered? <a href="login.php">Login here</a></p>
</body>
</html>
