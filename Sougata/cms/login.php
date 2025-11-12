<?php
require_once 'db.php';

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameInput = trim($_POST['username'] ?? '');
    $passwordInput = $_POST['password'] ?? '';

    try {
        $db = connect_db();
        $sql = 'SELECT user_id, password_hash FROM users WHERE username = :uname LIMIT 1';
        $stmt = $db->prepare($sql);
        $stmt->execute([':uname' => $usernameInput]);
        $user = $stmt->fetch();

        if ($user && password_verify($passwordInput, $user['password_hash'])) {
            // Prevent session fixation
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $usernameInput;

            header('Location: manage.php');
            exit;
        } else {
            $login_error = 'Invalid username or password.';
        }
    } catch (PDOException $e) {
        error_log('[LOGIN] DB error: ' . $e->getMessage());
        $login_error = 'An error occurred. Please try again later.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User Login</title>
    <style>body{font-family:Arial, sans-serif;max-width:700px;margin:24px;}</style>
</head>
<body>
    <h2>Log In</h2>

    <?php if ($login_error !== ''): ?>
        <p style="color:red;"><?= escape_html($login_error) ?></p>
    <?php endif; ?>

    <form method="post" novalidate>
        <label>Username</label><br>
        <input type="text" name="username" required autocomplete="username"><br>

        <label>Password</label><br>
        <input type="password" name="password" required autocomplete="current-password"><br>

        <button type="submit">Log in</button>
    </form>

    <p>
        <a href="register.php">Create account</a> |
        <a href="home.php">Public site</a>
    </p>
</body>
</html>