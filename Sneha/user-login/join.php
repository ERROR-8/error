<?php
require_once 'db_conn.php';
session_start();

$user_reg_msg = '';
$user_reg_status = 0; // 0=none, 1=success, 2=error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dname = trim($_POST['dname'] ?? '');
    $email_addr = trim($_POST['email'] ?? '');
    $pass1 = $_POST['pass1'] ?? '';
    $pass2 = $_POST['pass2'] ?? '';
    
    // Simple validation checks
    if (empty($dname) || empty($email_addr) || empty($pass1) || empty($pass2)) {
        $user_reg_msg = "Please fill out all required fields.";
    } elseif ($pass1 !== $pass2) {
        $user_reg_msg = "Passwords do not match.";
    } elseif (!filter_var($email_addr, FILTER_VALIDATE_EMAIL)) {
        $user_reg_msg = "Invalid email format.";
    } else {
        // Check if email already exists
        $sql_check = "SELECT member_pk FROM members WHERE email_address = ?";
        $stmt_check = $db_instance->prepare($sql_check);
        $stmt_check->bind_param('s', $email_addr);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows > 0) {
            $user_reg_msg = "That email is already in use. Try signing in.";
        } else {
            $hashed_pass = password_hash($pass1, PASSWORD_DEFAULT);
            
            // Insert new user
            $sql_insert = "INSERT INTO members (display_name, email_address, secure_pass) VALUES (?, ?, ?)";
            $stmt_insert = $db_instance->prepare($sql_insert);
            
            // 'sss' for three strings
            $stmt_insert->bind_param('sss', $dname, $email_addr, $hashed_pass);
            
            if ($stmt_insert->execute()) {
                $user_reg_status = 1;
                $user_reg_msg = "Account created!";
                header('Location: signin.php?joined=1');
                exit;
            } else {
                $user_reg_status = 2;
                $user_reg_msg = "Registration error. Try again.";
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
    <title>Create User Account</title>
    <style>body{font-family:Arial;max-width:600px;margin:24px;} .msg-box{padding:8px;border:1px solid;}</style>
</head>
<body>
    <h2>Create New Account</h2>
    <?php if (!empty($user_reg_msg)): ?>
        <div class="msg-box" style="color:<?= $user_reg_status === 1 ? 'green' : 'red' ?>; border-color:<?= $user_reg_status === 1 ? '#0a0' : '#a00' ?>;">
            <?= htmlspecialchars($user_reg_msg) ?>
        </div>
    <?php endif; ?>
    
    <form method="post" action="join.php" autocomplete="off">
        <label>Display Name</label><br><input type="text" name="dname" required><br><br>
        <label>Email Address</label><br><input type="email" name="email" required><br><br>
        <label>Password</label><br><input type="password" name="pass1" required><br><br>
        <label>Confirm Password</label><br><input type="password" name="pass2" required><br><br>
        <button type="submit">Complete Registration</button>
    </form>
    
    <p>Already registered? <a href="signin.php">Sign In here</a></p>
</body>
</html>