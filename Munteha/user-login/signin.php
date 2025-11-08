<?php
// signin.php
require_once 'db_connect.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? ''); // can be name or email
    $pass  = $_POST['password'] ?? '';

    if ($login === '' || $pass === '') {
        $error = "Both fields required.";
    } else {
        // try finding by email first, then by name
        $stmt = $mysqli->prepare("SELECT member_id, full_name, contact_email, pass_hash FROM members WHERE contact_email = ? OR full_name = ? LIMIT 1");
        $stmt->bind_param('ss', $login, $login);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            if (password_verify($pass, $row['pass_hash'])) {
                // login success
                session_regenerate_id(true);
                $_SESSION['member_id'] = $row['member_id'];
                $_SESSION['member_name'] = $row['full_name'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No account found.";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sign In</title>
  <style>body{font-family:arial;max-width:600px;margin:24px} input{padding:8px;width:100%;margin-bottom:10px}.err{color:#900}</style>
</head>
<body>
  <h2>Sign In</h2>
  <?php if ($error): ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <form method="post" action="signin.php" autocomplete="off">
    <label>Email or Full name</label><br>
    <input type="text" name="login" required><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br>

    <button type="submit">Sign In</button>
  </form>

  <p>New? <a href="signup.php">Create an account</a></p>
</body>
</html>
