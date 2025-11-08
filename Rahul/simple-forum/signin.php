<?php
// signin.php
require 'config.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    if ($name === '' || $pass === '') $msg = "Fill both fields.";
    else {
        $stmt = $mysqli->prepare("SELECT uid, upass FROM users WHERE uname = ? LIMIT 1");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($uid, $hash);
        if ($stmt->fetch() && password_verify($pass, $hash)) {
            $_SESSION['uid'] = $uid;
            $_SESSION['uname'] = $name;
            $stmt->close();
            header('Location: board.php'); exit;
        } else {
            $msg = "Invalid username or password.";
            $stmt->close();
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Sign in</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Sign in</h2>
  <?php if($msg) echo "<p style='color:red;'>".htmlspecialchars($msg)."</p>"; ?>
  <form method="post" action="signin.php">
    <label>Username</label><br><input name="username" required><br><br>
    <label>Password</label><br><input type="password" name="password" required><br><br>
    <button>Sign in</button>
  </form>
  <p>No account? <a href="signup.php">Create one</a></p>
</body></html>
