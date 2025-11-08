<?php
// newpost.php
require 'config.php';
if (empty($_SESSION['uid'])) { header('Location: signin.php'); exit; }
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    if ($title === '' || $body === '') { $msg = "Title & body required."; }
    else {
        $stmt = $mysqli->prepare("INSERT INTO posts (user_id, title, body) VALUES (?, ?, ?)");
        $stmt->bind_param('iss', $_SESSION['uid'], $title, $body);
        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            $stmt->close();
            header("Location: post.php?id=$id"); exit;
        } else {
            $msg = "Could not create post.";
            $stmt->close();
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>New post</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>New post</h2>
  <?php if($msg) echo "<p style='color:red;'>".htmlspecialchars($msg)."</p>"; ?>
  <form method="post" action="newpost.php">
    <label>Title</label><br><input name="title" style="width:100%" required><br><br>
    <label>Body</label><br><textarea name="body" rows="8" style="width:100%" required></textarea><br><br>
    <button>Create</button>
  </form>
  <p><a href="board.php">Back</a></p>
</body></html>
