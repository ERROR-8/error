<?php
// home.php
session_start();
if (empty($_SESSION['person_id'])) {
    header('Location: signin.php');
    exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Home</title></head>
<body style="font-family:Arial;max-width:600px;margin:24px">
  <h2>Hi, <?= htmlspecialchars($_SESSION['person_name']) ?></h2>
  <p>Welcome to your page. This is a simple protected area.</p>
  <p><a href="logout.php">Log out</a></p>
</body>
</html>
