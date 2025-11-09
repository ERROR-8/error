<?php
session_start();

if (empty($_SESSION['USER_ID_PK'])) {
    header('Location: signin.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Protected Area</title>
    <style>body{font-family:Arial;max-width:600px;margin:24px;}</style>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['USER_NAME_DN']) ?></h2>
    <p>You have successfully entered the protected area.</p>
    <p><a href="logout.php">Sign Out of Profile</a></p>
</body>
</html>