<?php
// login.php
require 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $msg = 'Fill both fields.';
    } else {
        $stmt = $pdo->prepare("SELECT id, password FROM authors WHERE username = :u LIMIT 1");
        $stmt->execute([':u'=>$username]);
        $author = $stmt->fetch();
        if ($author && password_verify($password, $author['password'])) {
            session_regenerate_id(true);
            $_SESSION['author_id'] = $author['id'];
            $_SESSION['username'] = $username;
            header('Location: admin.php'); exit;
        } else {
            $msg = 'Invalid credentials.';
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title></head>
<body style="font-family:Arial;max-width:800px;margin:24px">
  <h2>Author Login</h2>
  <?php if ($msg) echo '<p style="color:red;">'.h($msg).'</p>'; ?>
  <form method="post">
    <label>Username</label><br>
    <input name="username" required><br><br>
    <label>Password</label><br>
    <input type="password" name="password" required><br><br>
    <button>Login</button>
  </form>
  <p><a href="register.php">Create account</a> | <a href="index.php">View site</a></p>
</body></html>
