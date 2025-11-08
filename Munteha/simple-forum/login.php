<?php
// login.php
require 'config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $message = "Fill both fields.";
  } else {
    $stmt = $db->prepare("SELECT id, password FROM users WHERE username = :u LIMIT 1");
    $stmt->execute([':u'=>$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $username;
      header('Location: home.php'); exit;
    } else {
      $message = "Invalid credentials.";
    }
  }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Login</h2>
  <?php if ($message) echo "<p style='color:red;'>".htmlspecialchars($message)."</p>"; ?>
  <form method="post" action="login.php">
    <label>Username</label><br>
    <input name="username" required><br><br>
    <label>Password</label><br>
    <input type="password" name="password" required><br><br>
    <button>Login</button>
  </form>
  <p>No account? <a href="register.php">Register</a></p>
</body></html>
