<?php
require_once 'db_conn.php';
session_start();

$login_feedback = '';
$login_error = '';

$join_success_msg = isset($_GET['joined']) ? "Account successfully created. Please sign in." : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['id'] ?? '');
    $password = $_POST['p'] ?? '';

    if (empty($identifier) || empty($password)) {
        $login_error = "Both identification and password are required.";
    } else {
        // Query checks both email_address AND display_name
        $sql = "SELECT member_pk, display_name, secure_pass FROM members WHERE email_address = ? OR display_name = ? LIMIT 1";
        $stmt = $db_instance->prepare($sql);
        
        // 'ss' for two strings (identifier is used twice)
        $stmt->bind_param('ss', $identifier, $identifier);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($record = $result->fetch_assoc()) {
            
            if (password_verify($password, $record['secure_pass'])) {
                // Successful login
                $_SESSION['USER_PK'] = $record['member_pk'];
                $_SESSION['USER_DN'] = $record['display_name'];
                
                $stmt->close();
                header('Location: home.php');
                exit;
            } else {
                $login_error = "Incorrect password.";
            }
        } else {
            $login_error = "No account found with that identifier.";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Sign In</title>
    <style>body{font-family:Arial;max-width:600px;margin:24px;}</style>
</head>
<body>
    <h2>Sign In</h2>
    
    <?php if (!empty($join_success_msg)): ?>
        <p style="color:green;"><?= htmlspecialchars($join_success_msg); ?></p>
    <?php endif; ?>
    
    <?php if (!empty($login_error)): ?>
        <p style="color:red;"><?= htmlspecialchars($login_error); ?></p>
    <?php endif; ?>
    
    <form method="post" action="signin.php" autocomplete="off">
        <label>Email or Display Name</label><br><input type="text" name="id" required><br><br>
        <label>Password</label><br><input type="password" name="p" required><br><br>
        <button type="submit">Sign In</button>
    </form>
    
    <p>New user? <a href="join.php">Create account</a></p>
</body>
</html>