<?php
// signup.php
require_once 'db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $pass2 = $_POST['password2'] ?? '';

    if ($name === '' || $email === '' || $pass === '') {
        $message = "Please fill all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Enter a valid email.";
    } elseif ($pass !== $pass2) {
        $message = "Passwords do not match.";
    } else {
        // check if email exists
        $stmt = $mysqli->prepare("SELECT member_id FROM members WHERE contact_email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "This email is already registered.";
            $stmt->close();
        } else {
            $stmt->close();
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $ins = $mysqli->prepare("INSERT INTO members (full_name, contact_email, pass_hash) VALUES (?, ?, ?)");
            $ins->bind_param('sss', $name, $email, $hash);
            if ($ins->execute()) {
                $message = "Account created. You can <a href='signin.php'>log in</a> now.";
            } else {
                $message = "Registration error: try again.";
            }
            $ins->close();
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sign Up</title>
  <style>
    body{font-family:arial;max-width:600px;margin:24px}
    input{padding:8px;width:100%;margin-bottom:10px}
    .msg{padding:8px;background:#f3f3f3;border:1px solid #ddd}
  </style>
</head>
<body>
  <h2>Create account</h2>
  <?php if ($message): ?>
    <div class="msg"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <form method="post" action="signup.php" autocomplete="off">
    <label>Full name</label><br>
    <input type="text" name="name" required><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br>

    <label>Repeat password</label><br>
    <input type="password" name="password2" required><br>

    <button type="submit">Sign Up</button>
  </form>

  <p>Already registered? <a href="signin.php">Sign in</a></p>
</body>
</html>
