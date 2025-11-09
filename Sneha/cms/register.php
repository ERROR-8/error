<?php
require 'db.php';

$alert = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['uname']);
    $pass = $_POST['upass'];

    if (empty($name) || empty($pass)) {
        $alert = "Fill all fields.";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $db_conn->prepare("INSERT INTO users (uname, upass) VALUES (:n, :p)");
        try {
            $stmt->execute([':n'=>$name, ':p'=>$hash]);
            $_SESSION['user_id'] = $db_conn->lastInsertId();
            $_SESSION['username'] = $name;
            header('Location: manage.php'); exit;
        } catch (Exception $e) {
            $alert = "Username already exists.";
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>New User Registration</title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 0 auto; padding-top: 50px; line-height: 1.6;">
<h2>New User Registration</h2>
<?php 
if($alert) echo "<p style='color:red;'>".sanitize_output($alert).".</p>"; ?>
<form method="post">
    <label>Username</label><br><input type="text" name="uname" required><br>
    <label>Password</label><br><input type="password" name="upass" required><br>
    <button>Create Account</button>
</form>
<p><a href="login.php">Sign In</a> | <a href="home.php">View Public Blog</a></p>
</body>
</html>