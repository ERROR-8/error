<?php
require 'db.php';
$alert = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['uname']);
    $pass = $_POST['upass'];

    $stmt = $db_conn->prepare("SELECT uid, upass FROM users WHERE uname = :n LIMIT 1");
    $stmt->execute([':n'=>$name]);
    $user_data = $stmt->fetch();

    if ($user_data && password_verify($pass, $user_data['upass'])) {
        $_SESSION['user_id'] = $user_data['uid'];
        $_SESSION['username'] = $name;
        header('Location: manage.php'); exit;
    } else {
        $alert = "Invalid login credentials.";
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>User Sign In</title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 0 auto; padding-top: 50px; line-height: 1.6;">
<h2>User Sign In</h2>
<?php
if($alert) echo "<p style='color:red;'>".sanitize_output($alert).".</p>"; ?>
<form method="post">
    <label>Username</label><br><input type="text" name="uname" required><br>
    <label>Password</label><br><input type="password" name="upass" required><br>
    <button>Sign In</button>
</form>
<p><a href="register.php">Register Now</a> | <a href="home.php">View Public Blog</a></p>
</body>
</html>