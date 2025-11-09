<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u_in = trim($_POST['u'] ?? '');
    $p_in = $_POST['p'] ?? '';

    if (empty($u_in) || empty($p_in)) {
        $message = "Empty credentials.";
    } else {
        $sql = "SELECT member_id, password FROM members WHERE username = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);
        
        mysqli_stmt_bind_param($stmt, 's', $u_in);
        mysqli_stmt_execute($stmt);
        
        $res = mysqli_stmt_get_result($stmt);
        
        if ($record = mysqli_fetch_assoc($res)) {
            
            if (password_verify($p_in, $record['password'])) {
                $_SESSION['SESS_USER_ID'] = $record['member_id'];
                $_SESSION['SESS_UNAME'] = $u_in;
                
                mysqli_stmt_close($stmt);
                header('Location: threads.php');
                exit;
            }
        }
        
        $message = "Login failed.";
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Login</title>
    <style>body{font-family:Arial;max-width:700px;margin:24px;}</style>
</head>
<body>
    <h2>Log In</h2>
    <?php if (!empty($message)): ?>
        <p style="color:red;"><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>
    
    <form method="post" action="login.php">
        <label>Username</label><br><input name="u" required><br><br>
        <label>Password</label><br><input type="password" name="p" required><br><br>
        <button type="submit">Log In</button>
    </form>
    
    <p>New? <a href="register.php">Register</a></p>
</body>
</html>