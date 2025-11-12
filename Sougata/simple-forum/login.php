<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $message = 'Please fill both fields.';
    } else {
        $stmt = mysqli_prepare($link, 'SELECT user_id, password FROM users WHERE username = ? LIMIT 1');
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $user_id, $pw_hash);

            if (mysqli_stmt_fetch($stmt)) {
                if (password_verify($password, $pw_hash)) {
                    // login success
                    $_SESSION['auth_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    mysqli_stmt_close($stmt);
                    header('Location: threads.php');
                    exit;
                }
            }

            mysqli_stmt_close($stmt);
        }
        $message = 'Invalid username or password.';
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
    <?php if ($message !== ''): ?>
        <p style="color:red;"><?= htmlspecialchars($message, ENT_QUOTES | ENT_HTML5) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Username</label><br>
        <input name="username" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Log in</button>
    </form>

    <p>New? <a href="register.php">Register here</a></p>
</body>
</html>