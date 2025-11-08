<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = trim($_POST['user']);
  $pass = $_POST['pass'];

  $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE username=? LIMIT 1");
  mysqli_stmt_bind_param($stmt, "s", $user);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $id, $hash);

  if (mysqli_stmt_fetch($stmt) && password_verify($pass, $hash)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['user'] = $user;
    header("Location: index.php"); exit;
  } else {
    $msg = "Invalid username or password.";
  }
  mysqli_stmt_close($stmt);
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
<h2>Login</h2>
<?php if($msg) echo "<p style='color:red;'>$msg</p>"; ?>
<form method="post">
  <label>Username</label><br><input name="user" required><br><br>
  <label>Password</label><br><input type="password" name="pass" required><br><br>
  <button>Login</button>
</form>
<p>No account? <a href="register.php">Register</a></p>
</body></html>
