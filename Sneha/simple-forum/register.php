<?php
require 'db.php';

$query_status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_user = trim($_POST['u'] ?? '');
    $form_pass = $_POST['p'] ?? '';

    if (empty($form_user) || empty($form_pass)) {
        $query_status = "Missing fields.";
    } else {
        $hash = password_hash($form_pass, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO members (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        mysqli_stmt_bind_param($stmt, 'ss', $form_user, $hash);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['SESS_USER_ID'] = mysqli_insert_id($conn); 
            $_SESSION['SESS_UNAME'] = $form_user;
            
            mysqli_stmt_close($stmt);
            header('Location: threads.php'); 
            exit;
        } else {
            $query_status = "Username may exist.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register Account</title>
    <style>body{font-family:Arial;max-width:700px;margin:24px;}</style>
</head>
<body>
    <h2>Sign Up</h2>
    <?php if (!empty($query_status)): ?>
        <p style="color:red;"><?= htmlspecialchars($query_status); ?></p>
    <?php endif; ?>
    
    <form method="post" action="register.php">
        <label>Username</label><br><input name="u" required><br><br>
        <label>Password</label><br><input type="password" name="p" required><br><br>
        <button type="submit">Sign Up</button>
    </form>
    
    <p>Existing user? <a href="login.php">Log In</a></p>
</body>
</html>