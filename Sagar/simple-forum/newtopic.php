<?php
require 'db.php';
if(empty($_SESSION['id'])) { header('Location: login.php'); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);

  if($title===''||$content==='') $msg="All fields required.";
  else {
    $stmt = mysqli_prepare($conn, "INSERT INTO topics (user_id, title, content) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iss", $_SESSION['id'], $title, $content);
    if (mysqli_stmt_execute($stmt)) {
      $id = mysqli_insert_id($conn);
      header("Location: view.php?id=$id"); exit;
    } else $msg = "Failed to add topic.";
    mysqli_stmt_close($stmt);
  }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>New Topic</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
<h2>New Topic</h2>
<?php if($msg) echo "<p style='color:red;'>$msg</p>"; ?>
<form method="post">
  <label>Title</label><br><input name="title" style="width:100%" required><br><br>
  <label>Content</label><br><textarea name="content" rows="6" style="width:100%" required></textarea><br><br>
  <button>Create</button>
</form>
<p><a href="home.php">Back</a></p>
</body></html>
