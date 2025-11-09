<?php
require_once 'db_conn.php';
session_start();

$message = '';

$creation_status = isset($_GET['status']) && $_GET['status'] === 'created' ? "Profile successfully created. Please log in." : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth_id = trim($_POST['auth_id'] ?? '');
    $auth_pwd = $_POST['auth_pwd'] ?? '';

    if (empty($auth_id) || empty($auth_pwd)) {
        $message = "Authentication fields cannot be blank.";
    } else {
        // Select by email or display name
        $sql = "SELECT user_pk, display_name, password_hash FROM auth_users WHERE user_email = ? OR display_name = ? LIMIT 1";
        $stmt = $auth_conn->prepare($sql);
        
        $stmt->bind_param('ss', $auth_id, $auth_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user_data = $result->fetch_assoc()) {
            
            if (password_verify($auth_pwd, $user_data['password_hash'])) {
                // Set session data
                $_SESSION['USER_ID_PK'] = $user_data['user_pk'];
                $_SESSION['USER_NAME_DN'] = $user_data['display_name'];
                
                $stmt->close();
                header('Location: home.php');
                exit;
            } else {
                $message = "Incorrect password provided.";
            }
        } else {
            $message = "User identification not found.";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile Access</title>
    <style>body{font-family:Arial;max-width:600px;margin:24px;}</style>
</head>
<body>
    <h2>Access Profile</h2>
    
    <?php if (!empty($creation_status)): ?>
        <p style="color:green;"><?= htmlspecialchars($creation_status); ?></p>
    <?php endif; ?>
    
    <?php if (!empty($message)): ?>
        <p style="color:red;"><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>
    
    <form method="post" action="signin.php" autocomplete="off">
        <label>Email or Display Name</label><br><input type="text" name="auth_id" required><br><br>
        <label>Password</label><br><input type="password" name="auth_pwd" required><br><br>
        <button type="submit">Access Profile</button>
    </form>
    
    <p>New user? <a href="join.php">Create profile</a></p>
</body>
</html>