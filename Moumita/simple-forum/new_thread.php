<?php
// new_thread.php
require 'db.php';
if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    if ($title === '' || $body === '') {
        $message = "Title and body required.";
    } else {
        $stmt = mysqli_prepare($mysqli, "INSERT INTO threads (user_id, title, body) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'iss', $_SESSION['user_id'], $title, $body);
        if (mysqli_stmt_execute($stmt)) {
            $id = mysqli_insert_id($mysqli);
            mysqli_stmt_close($stmt);
            header('Location: thread.php?id=' . $id); exit;
        } else {
            $message = "Failed to create thread.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>New Thread</title></head>
<body style="font-family:Arial;max-width:700px;margin:24px">
  <h2>Create Thread</h2>
  <?php if ($message) echo "<p style='color:red;'>".htmlspecialchars($message)."</p>"; ?>
  <form method="post" action="new_thread.php">
    <label>Title</label><br><input name="title" style="width:100%" required><br><br>
    <label>Body</label><br><textarea name="body" rows="6" style="width:100%" required></textarea><br><br>
    <button type="submit">Create</button>
  </form>
  <p><a href="threads.php">Back to threads</a></p>
</body>
</html>
