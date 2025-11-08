<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = trim($_POST['user']);
  $pass = $_POST['pass'];

  if ($user === '' || $pass === '') $msg = "Fill all fields.";
  else {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $user, $hash);
    if (@mysqli_stmt_execute($stmt)) {
      $_SESSION['user_id'] = mysqli_insert_id($conn);
      $_SESSION['user'] = $user;
      header("Location: index.php"); exit;
    } else {
      $msg = "Username already exists.";
    }
    mysqli_stmt_close($stmt);
  }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
<h2>Register</h2>
<?php if($msg) echo "<p style='color:red;'>$msg</p>"; ?>
<form method="post">
  <label>Username</label><br><input name="user" required><br><br>
  <label>Password</label><br><input type="password" name="pass" required><br><br>
  <button>Create Account</button>
</form>
<p>Already registered? <a href="login.php">Login</a></p>
</body></html>
