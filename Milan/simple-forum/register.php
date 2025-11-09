<?php
require 'db.php';

$auth_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_identity = trim($_POST['username'] ?? '');
    $user_password = $_POST['password'] ?? '';

    if (empty($user_identity) || empty($user_password)) {
        $auth_message = "All fields required.";
    } else {
        $pwd_hash = password_hash($user_password, PASSWORD_DEFAULT);
        
        $stmt_register = mysqli_prepare($link, "INSERT INTO users (username, password) VALUES (?, ?)");
        
        mysqli_stmt_bind_param($stmt_register, 'ss', $user_identity, $pwd_hash);
        
        if (mysqli_stmt_execute($stmt_register)) {
            $_SESSION['auth_id'] = mysqli_insert_id($link);
            $_SESSION['username'] = $user_identity;
            
            mysqli_stmt_close($stmt_register);
            header('Location: threads.php'); 
            exit;
        } else {
            $auth_message = "That username might be taken.";
        }
        mysqli_stmt_close($stmt_register);
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forum Register</title>
    <style>body{font-family:Arial;max-width:700px;margin:24px;}</style>
</head>
<body>
    <h2>Create Forum Account</h2>
    <?php if (!empty($auth_message)): ?>
        <p style="color:red;"><?= htmlspecialchars($auth_message); ?></p>
    <?php endif; ?>
    
    <form method="post" action="register.php">
        <label>Username</label><br><input name="username" required><br><br>
        <label>Password</label><br><input type="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>
    
    <p>Have an account? <a href="login.php">Log In</a></p>
</body>
</html>