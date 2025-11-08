<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = trim($_POST['uname'] ?? '');
    $pass  = $_POST['pass'] ?? '';

    if ($uname === '' || $pass === '') {
        $msg = "Enter both fields.";
    } else {
        $stmt = mysqli_prepare($mysqli, "SELECT wid, upass FROM writers WHERE uname = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $uname);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $wid, $hash);
        if (mysqli_stmt_fetch($stmt) && password_verify($pass, $hash)) {
            $_SESSION['writer_id'] = $wid;
            $_SESSION['uname'] = $uname;
            mysqli_stmt_close($stmt);
            header('Location: dashboard.php'); exit;
        } else {
            $msg = "Invalid username or password.";
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Sign in</title></head>
<body style="font-family:Arial;max-width:800px;margin:24px">
  <h2>Sign in</h2>
  <?php if ($msg) echo "<p style='color:red;'>".esc($msg)."</p>"; ?>
  <form method="post">
    <label>Username</label><br><input name="uname" required><br><br>
    <label>Password</label><br><input type="password" name="pass" required><br><br>
    <button>Sign in</button>
  </form>
  <p><a href="signup.php">Create account</a> | <a href="site.php">View site</a></p>
</body></html>
