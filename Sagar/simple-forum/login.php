<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $pass = $_POST['pass'];

  $stmt = mysqli_prepare($conn, "SELECT id, pass FROM users WHERE name=? LIMIT 1");
  mysqli_stmt_bind_param($stmt, "s", $name);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $id, $hash);

  if (mysqli_stmt_fetch($stmt) && password_verify($pass, $hash)) {
    $_SESSION['id'] = $id;
    $_SESSION['name'] = $name;
    header('Location: home.php'); exit;
  } else $msg = "Wrong username or password.";

  mysqli_stmt_close($stmt);
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
<h2>Login</h2>
<?php if($msg) echo "<p style='color:red;'>$msg</p>"; ?>
<form method="post">
  <label>Username</label><br><input name="name" required><br><br>
  <label>Password</label><br><input type="password" name="pass" required><br><br>
  <button>Login</button>
</form>
<p>New user? <a href="register.php">Create account</a></p>
</body></html>
