<?php
require 'db_connect.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $pass = $_POST['pass'] ?? '';
    if ($name === '' || $pass === '') $msg = "Fill both fields.";
    else {
        $q = $db->prepare("SELECT editor_id, editor_pass FROM editors WHERE editor_name = :n LIMIT 1");
        $q->execute([':n'=>$name]);
        $row = $q->fetch();
        if ($row && password_verify($pass, $row['editor_pass'])) {
            session_regenerate_id(true);
            $_SESSION['editor_id'] = $row['editor_id'];
            $_SESSION['editor_name'] = $name;
            header('Location: manage.php'); exit;
        } else $msg = "Invalid login.";
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login</title></head>
<body style="font-family:Arial;max-width:800px;margin:24px">
  <h2>Editor login</h2>
  <?php if($msg) echo "<p style='color:red;'>".safe($msg)."</p>"; ?>
  <form method="post">
    <label>Name</label><br><input name="name" required><br><br>
    <label>Password</label><br><input type="password" name="pass" required><br><br>
    <button>Login</button>
  </form>
  <p><a href="signup_editor.php">Create editor</a> | <a href="home.php">Home</a></p>
</body></html>
