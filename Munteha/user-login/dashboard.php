<?php
// dashboard.php
session_start();
if (empty($_SESSION['member_id'])) {
    header('Location: signin.php');
    exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Dashboard</title></head>
<body style="font-family:arial;max-width:600px;margin:24px">
  <h2>Welcome, <?= htmlspecialchars($_SESSION['member_name']) ?></h2>
  <p>This is your dashboard. You can log out below.</p>
  <p><a href="signout.php">Sign out</a></p>
</body>
</html>
