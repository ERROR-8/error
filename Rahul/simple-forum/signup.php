<?php
// signup.php
require 'config.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    if ($name === '' || $pass === '') {
        $msg = "Fill both fields.";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO users (uname, upass) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $hash);
        if (@$stmt->execute()) {
            // auto-login
            $_SESSION['uid'] = $stmt->insert_id;
            $_SESSION['uname'] = $name;
            $stmt->close();
            header('Location: board.php'); exit;
        } else {
            $msg = "Username taken or error.";
            $stmt->close();
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Sign up</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Create account</h2>
  <?php if($msg) echo "<p style='color:red;'>".htmlspecialchars($msg)."</p>"; ?>
  <form method="post" action="signup.php">
    <label>Username</label><br><input name="username" required><br><br>
    <label>Password</label><br><input type="password" name="password" required><br><br>
    <button>Create</button>
  </form>
  <p>Have account? <a href="signin.php">Sign in</a></p>
</body></html>
