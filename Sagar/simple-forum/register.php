<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $pass = $_POST['pass'];

  if ($name === '' || $pass === '') $msg = "All fields required.";
  else {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, pass) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $name, $hash);
    if (@mysqli_stmt_execute($stmt)) {
      $_SESSION['id'] = mysqli_insert_id($conn);
      $_SESSION['name'] = $name;
      header('Location: home.php'); exit;
    } else $msg = "Username already exists.";
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
  <label>Username</label><br><input name="name" required><br><br>
  <label>Password</label><br><input type="password" name="pass" required><br><br>
  <button>Sign up</button>
</form>
<p>Already user? <a href="login.php">Login</a></p>
</body></html>
