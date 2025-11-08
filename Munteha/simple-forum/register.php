<?php
// register.php
require 'config.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $message = "Fill both fields.";
  } else {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:u, :p)");
    try {
      $stmt->execute([':u'=>$username, ':p'=>$hash]);
      // login immediately
      $_SESSION['user_id'] = $db->lastInsertId();
      $_SESSION['username'] = $username;
      header('Location: home.php'); exit;
    } catch (PDOException $e) {
      $message = "Username already taken.";
    }
  }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Create account</h2>
  <?php if ($message) echo "<p style='color:red;'>".htmlspecialchars($message)."</p>"; ?>
  <form method="post" action="register.php">
    <label>Username</label><br>
    <input name="username" required><br><br>
    <label>Password</label><br>
    <input type="password" name="password" required><br><br>
    <button>Create</button>
  </form>
  <p>Have account? <a href="login.php">Login</a></p>
</body></html>
