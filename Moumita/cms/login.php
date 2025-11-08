<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['uname']);
  $pass = $_POST['upass'];

  $q = $pdo->prepare("SELECT uid, upass FROM users WHERE uname = :n LIMIT 1");
  $q->execute([':n'=>$name]);
  $u = $q->fetch();

  if ($u && password_verify($pass, $u['upass'])) {
    $_SESSION['uid'] = $u['uid'];
    $_SESSION['uname'] = $name;
    header('Location: manage.php'); exit;
  } else {
    $msg = "Invalid login.";
  }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
<h2>Login</h2>
<?php if($msg) echo "<p style='color:red;'>".clean($msg)."</p>"; ?>
<form method="post">
  <label>Username</label><br><input name="uname" required><br><br>
  <label>Password</label><br><input type="password" name="upass" required><br><br>
  <button>Login</button>
</form>
<p><a href="register.php">Create account</a> | <a href="home.php">Public site</a></p>
</body></html>
