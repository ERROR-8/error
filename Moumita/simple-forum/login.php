<?php
// login.php
require 'db.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $message = "Fill both fields.";
    } else {
        $stmt = mysqli_prepare($mysqli, "SELECT id,password FROM users WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $hash);
        if (mysqli_stmt_fetch($stmt) && password_verify($password, $hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            mysqli_stmt_close($stmt);
            header('Location: threads.php'); exit;
        } else {
            $message = "Invalid username or password.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Login</h2>
  <?php if ($message) echo "<p style='color:red;'>".htmlspecialchars($message)."</p>"; ?>
  <form method="post" action="login.php">
    <label>Username</label><br><input name="username" required><br><br>
    <label>Password</label><br><input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
  </form>
  <p>New? <a href="register.php">Register here</a></p>
</body>
</html>
