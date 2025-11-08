<?php
// register.php
require 'db.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $message = "Fill both fields.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($mysqli, "INSERT INTO users (username, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, 'ss', $username, $hash);
        if (@mysqli_stmt_execute($stmt)) {
            // log user in
            $_SESSION['user_id'] = mysqli_insert_id($mysqli);
            $_SESSION['username'] = $username;
            mysqli_stmt_close($stmt);
            header('Location: threads.php'); exit;
        } else {
            $message = "Username might be taken.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Register</h2>
  <?php if ($message) echo "<p style='color:red;'>".htmlspecialchars($message)."</p>"; ?>
  <form method="post" action="register.php">
    <label>Username</label><br><input name="username" required><br><br>
    <label>Password</label><br><input type="password" name="password" required><br><br>
    <button type="submit">Create account</button>
  </form>
  <p>Have account? <a href="login.php">Login</a></p>
</body>
</html>
