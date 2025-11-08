<?php
// new_thread.php
require 'config.php';
if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $content = trim($_POST['content'] ?? '');
  if ($title === '' || $content === '') $msg = "Provide title and content.";
  else {
    $ins = $db->prepare("INSERT INTO threads (user_id, title, content) VALUES (:uid, :t, :c)");
    $ins->execute([':uid'=>$_SESSION['user_id'], ':t'=>$title, ':c'=>$content]);
    header('Location: thread.php?id=' . $db->lastInsertId()); exit;
  }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>New Thread</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Create thread</h2>
  <?php if ($msg) echo "<p style='color:red;'>".htmlspecialchars($msg)."</p>"; ?>
  <form method="post" action="new_thread.php">
    <label>Title</label><br><input name="title" style="width:100%" required><br><br>
    <label>Content</label><br><textarea name="content" rows="6" style="width:100%" required></textarea><br><br>
    <button>Create</button>
  </form>
  <p><a href="home.php">Back</a></p>
</body></html>
