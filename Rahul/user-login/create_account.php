<?php
// create_account.php
require 'conn.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $pass2 = $_POST['password_confirm'] ?? '';

    if ($name === '' || $email === '' || $pass === '') {
        $msg = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Please provide a valid email.";
    } elseif ($pass !== $pass2) {
        $msg = "Passwords must match.";
    } else {
        // check existing email
        $stmt = $DB->prepare("SELECT acc_id FROM accounts WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $msg = "Email already registered.";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $ins = $DB->prepare("INSERT INTO accounts (name, email, pwd) VALUES (:name, :email, :pwd)");
            $ok = $ins->execute([':name'=>$name, ':email'=>$email, ':pwd'=>$hash]);
            if ($ok) {
                header("Location: login_user.php?registered=1");
                exit;
            } else {
                $msg = "Registration failed, try again.";
            }
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Create Account</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Create account</h2>
  <?php if ($msg): ?><div style="color:#900;margin-bottom:12px"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

  <form method="post" action="create_account.php" autocomplete="off">
    <label>Full name</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirm Password</label><br>
    <input type="password" name="password_confirm" required><br><br>

    <button type="submit">Create Account</button>
  </form>
  <p>Already have account? <a href="login_user.php">Sign in</a></p>
</body>
</html>
