<?php
// login_user.php
require 'conn.php';
session_start();

$error = '';
if (isset($_GET['registered'])) {
    $error = "Account created — you may sign in.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? ''); // email or name
    $password   = $_POST['password'] ?? '';

    if ($identifier === '' || $password === '') {
        $error = "Please fill both fields.";
    } else {
        $stmt = $DB->prepare("SELECT acc_id, name, email, pwd FROM accounts WHERE email = :id OR name = :id LIMIT 1");
        $stmt->execute([':id' => $identifier]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['pwd'])) {
            session_regenerate_id(true);
            $_SESSION['acc_id'] = $row['acc_id'];
            $_SESSION['acc_name'] = $row['name'];
            header("Location: home.php");
            exit;
        } else {
            $error = "Invalid login.";
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Sign In</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Sign in</h2>
  <?php if ($error): ?><div style="margin-bottom:12px;color:<?= (isset($_GET['registered']) ? '#060' : '#900') ?>"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <form method="post" action="login_user.php" autocomplete="off">
    <label>Email or Full name</label><br>
    <input type="text" name="identifier" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Sign In</button>
  </form>
  <p>New user? <a href="create_account.php">Create account</a></p>
</body>
</html>
