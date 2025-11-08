<?php
require 'db_connect.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $pass = $_POST['pass'] ?? '';
    if ($name === '' || $pass === '') $msg = "Fill both fields.";
    else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $ins = $db->prepare("INSERT INTO editors (editor_name, editor_pass) VALUES (:n,:p)");
        try {
            $ins->execute([':n'=>$name, ':p'=>$hash]);
            $_SESSION['editor_id'] = $db->lastInsertId();
            $_SESSION['editor_name'] = $name;
            header('Location: manage.php'); exit;
        } catch (Exception $e) {
            $msg = "Name taken or error.";
        }
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Sign up</title></head>
<body style="font-family:Arial;max-width:800px;margin:24px">
  <h2>Create editor</h2>
  <?php if($msg) echo "<p style='color:red;'>".safe($msg)."</p>"; ?>
  <form method="post">
    <label>Name</label><br><input name="name" required><br><br>
    <label>Password</label><br><input type="password" name="pass" required><br><br>
    <button>Create</button>
  </form>
  <p><a href="login_editor.php">Login</a> | <a href="home.php">Public site</a></p>
</body></html>
