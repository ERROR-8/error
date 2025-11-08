<?php
// join.php
require_once 'db_conn.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['display_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $passc = $_POST['password_confirm'] ?? '';

    if ($name === '' || $email === '' || $pass === '') {
        $message = "Please complete all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif ($pass !== $passc) {
        $message = "Passwords do not match.";
    } else {
        // prepared statement to check existing email
        $stmt = $mysqli->prepare("SELECT id_person FROM people WHERE login_email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Email already used. Try signing in.";
            $stmt->close();
        } else {
            $stmt->close();
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $ins = $mysqli->prepare("INSERT INTO people (display_name, login_email, secret_pass) VALUES (?, ?, ?)");
            $ins->bind_param('sss', $name, $email, $hash);
            if ($ins->execute()) {
                // redirect to signin with a query param
                header('Location: signin.php?joined=1');
                exit;
            } else {
                $message = "Registration error. Try again.";
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
  <title>Join — Create Account</title>
  <style>
    body{font-family: Arial; max-width:600px; margin:24px}
    input{padding:8px;width:100%;margin:6px 0}
    .msg{background:#f4f4f4;padding:10px;border:1px solid #ddd;margin-bottom:12px}
  </style>
</head>
<body>
  <h2>Create new account</h2>
  <?php if ($message): ?><div class="msg"><?= htmlspecialchars($message) ?></div><?php endif; ?>

  <form method="post" action="join.php" autocomplete="off">
    <label>Full name</label><br>
    <input type="text" name="display_name" required><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br>

    <label>Confirm Password</label><br>
    <input type="password" name="password_confirm" required><br>

    <button type="submit">Create Account</button>
  </form>

  <p>Already registered? <a href="signin.php">Sign in here</a></p>
</body>
</html>
