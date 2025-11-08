<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['uname']);
  $pass = $_POST['upass'];

  if ($name === '' || $pass === '') {
    $msg = "Fill all fields.";
  } else {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $q = $pdo->prepare("INSERT INTO users (uname, upass) VALUES (:n, :p)");
    try {
      $q->execute([':n'=>$name, ':p'=>$hash]);
      $_SESSION['uid'] = $pdo->lastInsertId();
      $_SESSION['uname'] = $name;
      header('Location: manage.php'); exit;
    } catch (Exception $e) {
      $msg = "Username already exists.";
    }
  }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
<h2>Create Account</h2>
<?php if($msg) echo "<p style='color:red;'>".clean($msg)."</p>"; ?>
<form method="post">
  <label>Username</label><br><input name="uname" required><br><br>
  <label>Password</label><br><input type="password" name="upass" required><br><br>
  <button>Register</button>
</form>
<p><a href="login.php">Login</a> | <a href="home.php">Public site</a></p>
</body></html>
