<?php
// Ensure a session is active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require login
if (empty($_SESSION['USER_ID_PK'])) {
    header('Location: signin.php');
    exit;
}

$userDisplay = htmlspecialchars((string)($_SESSION['USER_NAME_DN'] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Protected Area</title>
    <style>body{font-family:Arial, sans-serif;max-width:600px;margin:24px;}</style>
</head>
<body>
    <h2>Welcome, <?= $userDisplay ?></h2>
    <p>You have successfully entered the protected area.</p>
    <p><a href="logout.php">Sign Out of Profile</a></p>
</body>
</html>