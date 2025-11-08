<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = trim($_POST['uname'] ?? '');
    $pass  = $_POST['pass'] ?? '';

    if ($uname === '' || $pass === '') {
        $msg = "Fill both fields.";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($mysqli, "INSERT INTO writers (uname, upass) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, 'ss', $uname, $hash);
        if (@mysqli_stmt_execute($stmt)) {
            $_SESSION['writer_id'] = mysqli_insert_id($mysqli);
            $_SESSION['uname'] = $uname;
            mysqli_stmt_close($stmt);
            header('Location: dashboard.php'); exit;
        } else {
            $msg = "Username taken or error.";
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Sign up</title></head>
<body style="font-family:Arial;max-width:800px;margin:24px">
  <h2>Create writer account</h2>
  <?php if ($msg) echo "<p style='color:red;'>".esc($msg)."</p>"; ?>
  <form method="post">
    <label>Username</label><br><input name="uname" required><br><br>
    <label>Password</label><br><input type="password" name="pass" required><br><br>
    <button>Create account</button>
  </form>
  <p><a href="signin.php">Sign in</a> | <a href="site.php">View site</a></p>
</body></html>
