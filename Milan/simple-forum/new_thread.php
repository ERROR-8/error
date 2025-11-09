<?php
require 'db.php';

if (empty($_SESSION['auth_id'])) {
    header('Location: login.php');
    exit;
}

$new_thread_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $thread_title = trim($_POST['title'] ?? '');
    $thread_body = trim($_POST['body'] ?? '');

    if (empty($thread_title) || empty($thread_body)) {
        $new_thread_msg = "Title and body are required.";
    } else {
        $stmt_insert = mysqli_prepare($link, "INSERT INTO threads (user_id, title, body) VALUES (?, ?, ?)");
        
        mysqli_stmt_bind_param($stmt_insert, 'iss', $_SESSION['auth_id'], $thread_title, $thread_body);
        
        if (mysqli_stmt_execute($stmt_insert)) {
            $thread_pk = mysqli_insert_id($link);
            mysqli_stmt_close($stmt_insert);
            header("Location: thread.php?id=$thread_pk"); 
            exit;
        } else {
            $new_thread_msg = "Failed to create thread.";
        }
        mysqli_stmt_close($stmt_insert);
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Discussion Thread</title>
    <style>body{font-family:Arial;max-width:700px;margin:24px;}</style>
</head>
<body>
    <h2>Start a New Thread</h2>
    <?php if (!empty($new_thread_msg)): ?>
        <p style="color:red;"><?= htmlspecialchars($new_thread_msg); ?></p>
    <?php endif; ?>
    
    <form method="post" action="new_thread.php">
        <label>Title</label><br>
        <input name="title" style="width:100%" required><br><br>
        <label>Body</label><br>
        <textarea name="body" rows="6" style="width:100%" required></textarea><br><br>
        <button type="submit">Create Thread</button>
    </form>
    
    <p><a href="threads.php">Back to Threads</a></p>
</body>
</html>