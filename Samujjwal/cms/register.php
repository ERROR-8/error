<?php
// register.php
require 'db.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $msg = 'Fill both fields.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO authors (username, password) VALUES (:u, :p)");
        try {
            $stmt->execute([':u'=>$username, ':p'=>$hash]);
            // log in
            $_SESSION['author_id'] = $pdo->lastInsertId();
            $_SESSION['username'] = $username;
            header('Location: admin.php'); exit;
        } catch (Exception $e) {
            $msg = 'Username already exists.';
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register</title></head>
<body style="font-family:Arial;max-width:800px;margin:24px">
  <h2>Create Author</h2>
  <?php if ($msg) echo '<p style="color:red;">'.h($msg).'</p>'; ?>
  <form method="post">
    <label>Username</label><br>
    <input name="username" required><br><br>
    <label>Password</label><br>
    <input type="password" name="password" required><br><br>
    <button>Create</button>
  </form>
  <p><a href="login.php">Login</a> | <a href="index.php">View site</a></p>
</body></html>
