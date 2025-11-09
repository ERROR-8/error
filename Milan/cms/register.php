<?php
require 'db.php'; 

$statusMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEntry = trim($_POST['uname'] ?? '');
    $passEntry = $_POST['upass'] ?? '';

    if (empty($userEntry) || empty($passEntry)) {
        $statusMessage = "All fields must be filled.";
    } else {
        $hashedPassword = password_hash($passEntry, PASSWORD_DEFAULT);
        
        $insertUserQuery = "INSERT INTO users (username, password_hash) VALUES (?, ?)";
        
        try {
            $stmt = $dbConnect->prepare($insertUserQuery);
            $stmt->execute([$userEntry, $hashedPassword]);

            $_SESSION['user_id'] = $dbConnect->lastInsertId();
            $_SESSION['username'] = $userEntry;

            header('Location: manage.php'); 
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $statusMessage = "Username is already taken.";
            } else {
                error_log("Registration PDO Error: " . $e->getMessage());
                $statusMessage = "Registration failed due to a system error.";
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><title>Create Account</title>
    <style>body{font-family:Arial;max-width:700px;margin:24px;}</style>
</head>
<body>
    <h2>Register a New Account</h2>
    <?php if (!empty($statusMessage)): ?>
        <p style="color:red;"><?= sanitize_output($statusMessage); ?></p>
    <?php endif; ?>
    
    <form method="post">
        <label>Username</label><br><input type="text" name="uname" required><br>
        <label>Password</label><br><input type="password" name="upass" required><br>
        <button type="submit">Submit Registration</button>
    </form>
    
    <p>
        <a href="login.php">Back to Login</a> | 
        <a href="home.php">View Public Site</a>
    </p>
</body>
</html>