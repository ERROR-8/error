<?php
// home.php
session_start();
if (empty($_SESSION['acc_id'])) {
    header("Location: login_user.php");
    exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Home</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Welcome, <?= htmlspecialchars($_SESSION['acc_name']) ?></h2>
  <p>Your account ID: <?= htmlspecialchars($_SESSION['acc_id']) ?></p>
  <p><a href="signout_user.php">Sign out</a></p>
</body>
</html>
