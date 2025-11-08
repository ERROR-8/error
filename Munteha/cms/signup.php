<?php
require 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $pass = $_POST['pass'] ?? '';
    if ($name === '' || $pass === '') $msg = "Fill both fields.";
    else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO members (member_name, member_pass) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $hash);
        if (@$stmt->execute()) {
            $_SESSION['member_id'] = $stmt->insert_id;
            $_SESSION['member_name'] = $name;
            $stmt->close();
            header('Location: manage.php'); exit;
        } else {
            $msg = "Name taken or error.";
            $stmt->close();
        }
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Sign up</title></head>
<body style="font-family:Arial;max-width:800px;margin:24px">
  <h2>Create account</h2>
  <?php if($msg) echo "<p style='color:red;'>".esc($msg)."</p>"; ?>
  <form method="post">
    <label>Name</label><br><input name="name" required><br><br>
    <label>Password</label><br><input type="password" name="pass" required><br><br>
    <button>Create</button>
  </form>
  <p><a href="login.php">Login</a> | <a href="site.php">Public site</a></p>
</body></html>
