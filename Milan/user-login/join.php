<?php
require_once 'db_conn.php';
session_start();

$feedback_message = '';
$is_success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_dn = trim($_POST['dn'] ?? '');
    $user_em = trim($_POST['em'] ?? '');
    $pass_a = $_POST['p1'] ?? '';
    $pass_b = $_POST['p2'] ?? '';
    
    if (empty($user_dn) || empty($user_em) || empty($pass_a) || empty($pass_b)) {
        $feedback_message = "All form fields must be completed.";
    } elseif ($pass_a !== $pass_b) {
        $feedback_message = "Passwords must match exactly.";
    } elseif (!filter_var($user_em, FILTER_VALIDATE_EMAIL)) {
        $feedback_message = "Email address is invalid.";
    } else {
        // Check for existing user
        $stmt_check = $auth_conn->prepare("SELECT user_pk FROM auth_users WHERE user_email = ?");
        $stmt_check->bind_param('s', $user_em);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows > 0) {
            $feedback_message = "An account with this email already exists.";
        } else {
            $pass_hash = password_hash($pass_a, PASSWORD_DEFAULT);
            
            // Insert the new user
            $stmt_insert = $auth_conn->prepare("INSERT INTO auth_users (display_name, user_email, password_hash) VALUES (?, ?, ?)");
            $stmt_insert->bind_param('sss', $user_dn, $user_em, $pass_hash);
            
            if ($stmt_insert->execute()) {
                $is_success = true;
                header('Location: signin.php?status=created');
                exit;
            } else {
                $feedback_message = "Registration failed due to a server error.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Setup</title>
    <style>body{font-family:Arial;max-width:600px;margin:24px;} .msg-success{color:green; border: 1px solid #0a0; padding:8px;} .msg-error{color:red; border: 1px solid #a00; padding:8px;}</style>
</head>
<body>
    <h2>Create User Profile</h2>
    <?php if (!empty($feedback_message)): ?>
        <div class="<?= $is_success ? 'msg-success' : 'msg-error' ?>">
            <?= htmlspecialchars($feedback_message) ?>
        </div>
    <?php endif; ?>
    
    <form method="post" action="join.php" autocomplete="off">
        <label>Display Name</label><br><input type="text" name="dn" required><br><br>
        <label>Email Address</label><br><input type="email" name="em" required><br><br>
        <label>Password</label><br><input type="password" name="p1" required><br><br>
        <label>Confirm Password</label><br><input type="password" name="p2" required><br><br>
        <button type="submit">Complete Setup</button>
    </form>
    
    <p>Already joined? <a href="signin.php">Access Profile</a></p>
</body>
</html>