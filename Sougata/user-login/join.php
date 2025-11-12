<?php
require_once 'db_conn.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = '';
$ok = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $displayName = trim($_POST['dn'] ?? '');
    $email       = trim($_POST['em'] ?? '');
    $pwd1        = $_POST['p1'] ?? '';
    $pwd2        = $_POST['p2'] ?? '';

    if ($displayName === '' || $email === '' || $pwd1 === '' || $pwd2 === '') {
        $message = 'All fields are required.';
    } elseif ($pwd1 !== $pwd2) {
        $message = 'Passwords do not match.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please provide a valid email address.';
    } else {
        // check existing account
        $check = $auth_conn->prepare('SELECT user_pk FROM auth_users WHERE user_email = ? LIMIT 1');
        $check->bind_param('s', $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = 'An account with that email already exists.';
            $check->close();
        } else {
            $check->close();
            $hash = password_hash($pwd1, PASSWORD_DEFAULT);

            $ins = $auth_conn->prepare('INSERT INTO auth_users (display_name, user_email, password_hash) VALUES (?, ?, ?)');
            $ins->bind_param('sss', $displayName, $email, $hash);

            if ($ins->execute()) {
                $ins->close();
                header('Location: signin.php?status=created');
                exit;
            } else {
                $message = 'Registration failed. Please try again later.';
                $ins->close();
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Account</title>
    <style>
        body{font-family:Arial, sans-serif;max-width:600px;margin:24px;}
        .ok{color:green;border:1px solid #0a0;padding:8px;}
        .err{color:#900;border:1px solid #900;padding:8px;}
    </style>
</head>
<body>
    <h2>Register</h2>

    <?php if ($message !== ''): ?>
        <div class="<?= $ok ? 'ok' : 'err' ?>"><?= htmlspecialchars($message, ENT_QUOTES | ENT_HTML5) ?></div>
    <?php endif; ?>

    <form method="post" action="join.php" autocomplete="off">
        <label>Display name</label><br>
        <input type="text" name="dn" required><br><br>

        <label>Email</label><br>
        <input type="email" name="em" required><br><br>

        <label>Password</label><br>
        <input type="password" name="p1" required><br><br>

        <label>Confirm password</label><br>
        <input type="password" name="p2" required><br><br>

        <button type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="signin.php">Sign in</a></p>
</body>
</html>