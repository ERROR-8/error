<?php
require 'db.php';

$login_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_user = trim($_POST['username'] ?? '');
    $login_pass = $_POST['password'] ?? '';

    if (empty($login_user) || empty($login_pass)) {
        $login_msg = "Please fill both fields.";
    } else {
        $stmt_login = mysqli_prepare($link, "SELECT user_id, password FROM users WHERE username = ? LIMIT 1");
        
        mysqli_stmt_bind_param($stmt_login, 's', $login_user);
        mysqli_stmt_execute($stmt_login);
        
        $result_meta = mysqli_stmt_get_result($stmt_login);
        
        if ($user_data = mysqli_fetch_assoc($result_meta)) {
            
            if (password_verify($login_pass, $user_data['password'])) {
                $_SESSION['auth_id'] = $user_data['user_id'];
                $_SESSION['username'] = $login_user;
                
                mysqli_stmt_close($stmt_login);
                header('Location: threads.php');
                exit;
            }
        }
        
        $login_msg = "Invalid username or password.";
        mysqli_stmt_close($stmt_login);
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forum Login</title>
    <style>body{font-family:Arial;max-width:700px;margin:24px;}</style>
</head>
<body>
    <h2>User Login</h2>
    <?php if (!empty($login_msg)): ?>
        <p style="color:red;"><?= htmlspecialchars($login_msg); ?></p>
    <?php endif; ?>
    
    <form method="post" action="login.php">
        <label>Username</label><br><input name="username" required><br><br>
        <label>Password</label><br><input type="password" name="password" required><br><br>
        <button type="submit">Log in</button>
    </form>
    
    <p>New? <a href="register.php">Register here</a></p>
</body>
</html>