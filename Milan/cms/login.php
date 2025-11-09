<?php
require 'db.php'; 

$loginMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputName = trim($_POST['uname'] ?? '');
    $inputPass = $_POST['upass'] ?? '';

    $findUserQuery = "SELECT user_id, password_hash FROM users WHERE username = :name_param LIMIT 1";
    $stmt = $dbConnect->prepare($findUserQuery);
    $stmt->execute([':name_param' => $inputName]);
    
    $userData = $stmt->fetch();

    if ($userData && password_verify($inputPass, $userData['password_hash'])) {
        $_SESSION['user_id'] = $userData['user_id'];
        $_SESSION['username'] = $inputName;
        
        header('Location: manage.php');
        exit;
    } else {
        $loginMessage = "Invalid username or password.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><title>User Login</title>
    <style>body{font-family:Arial;max-width:700px;margin:24px;}</style>
</head>
<body>
    <h2>Log In</h2>
    <?php if (!empty($loginMessage)): ?>
        <p style="color:red;"><?= sanitize_output($loginMessage); ?></p>
    <?php endif; ?>
    
    <form method="post">
        <label>Username</label><br><input type="text" name="uname" required><br>
        <label>Password</label><br><input type="password" name="upass" required><br>
        <button type="submit">Log in</button>
    </form>
    
    <p>
        <a href="register.php">Create account</a> | 
        <a href="home.php">Public site</a>
    </p>
</body>
</html>