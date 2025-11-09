<?php
session_start();

if (empty($_SESSION['USER_PK'])) {
    header('Location: signin.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Home</title>
    <style>body{font-family:Arial;max-width:600px;margin:24px;}</style>
</head>
<body>
    <h2>Hello, <?= htmlspecialchars($_SESSION['USER_DN']) ?></h2>
    <p>This is a protected user page content.</p>
    <p><a href="logout.php">Sign Out</a></p>
</body>
</html>