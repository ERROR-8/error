<?php
// signin.php
require_once 'db_conn.php';
session_start();

$info = '';
if (isset($_GET['joined'])) {
    $info = "Account created. You may sign in.";
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $pass       = $_POST['password'] ?? '';

    if ($identifier === '' || $pass === '') {
        $error = "Please enter both fields.";
    } else {
        // find by email or name
        $stmt = $mysqli->prepare("SELECT id_person, display_name, login_email, secret_pass FROM people WHERE login_email = ? OR display_name = ? LIMIT 1");
        $stmt->bind_param('ss', $identifier, $identifier);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($pass, $row['secret_pass'])) {
                session_regenerate_id(true);
                $_SESSION['person_id'] = $row['id_person'];
                $_SESSION['person_name'] = $row['display_name'];
                header('Location: home.php');
                exit;
            } else {
                $error = "Wrong password.";
            }
        } else {
            $error = "No account found with that email or name.";
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
  <style>body{font-family:Arial;max-width:600px;margin:24px} input{padding:8px;width:100%;margin:6px 0}.err{color:#900}.ok{color:#060}</style>
</head>
<body>
  <h2>Sign In</h2>
  <?php if ($info): ?><p class="ok"><?= htmlspecialchars($info) ?></p><?php endif; ?>
  <?php if ($error): ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <form method="post" action="signin.php" autocomplete="off">
    <label>Email or Name</label><br>
    <input type="text" name="identifier" required><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br>

    <button type="submit">Sign In</button>
  </form>
  <p>New user? <a href="join.php">Create account</a></p>
</body>
</html>
