<?php
require 'db.php';
if(empty($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  if ($title==='' || $content==='') $msg = "Fill all fields.";
  else {
    $stmt = mysqli_prepare($conn, "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iss", $_SESSION['user_id'], $title, $content);
    mysqli_stmt_execute($stmt);
    $id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    header("Location: post.php?id=$id"); exit;
  }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>New Post</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
<h2>New Post</h2>
<?php if($msg) echo "<p style='color:red;'>$msg</p>"; ?>
<form method="post">
  <label>Title</label><br><input name="title" style="width:100%" required><br><br>
  <label>Content</label><br><textarea name="content" rows="6" style="width:100%" required></textarea><br><br>
  <button>Post</button>
</form>
<p><a href="index.php">Back</a></p>
</body></html>
