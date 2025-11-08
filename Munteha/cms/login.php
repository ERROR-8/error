<?php
require 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $pass = $_POST['pass'] ?? '';
    if ($name === '' || $pass === '') $msg = "Fill both fields.";
    else {
        $stmt = $mysqli->prepare("SELECT member_id, member_pass FROM members WHERE member_name = ? LIMIT 1");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($id, $hash);
        if ($stmt->fetch() && password_verify($pass, $hash)) {
            $_SESSION['member_id'] = $id;
            $_SESSION['member_name'] = $name;
            $stmt->close();
            header('Location: manage.php'); exit;
        } else {
            $msg = "Wrong name or password.";
            $stmt->close();
        }
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login</title></head>
<body style="font-family:Arial;max-width:800px;margin:24px">
  <h2>Login</h2>
  <?php if($msg) echo "<p style='color:red;'>".esc($msg)."</p>"; ?>
  <form method="post">
    <label>Name</label><br><input name="name" required><br><br>
    <label>Password</label><br><input type="password" name="pass" required><br><br>
    <button>Login</button>
  </form>
  <p><a href="signup.php">Create account</a> | <a href="site.php">Public site</a></p>
</body></html>
