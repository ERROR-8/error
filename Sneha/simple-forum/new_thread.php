<?php
require 'db.php';

if (empty($_SESSION['SESS_USER_ID'])) {
    header('Location: login.php');
    exit;
}

$msg = '';
$member_pk = $_SESSION['SESS_USER_ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_in = trim($_POST['t'] ?? '');
    $body_in = trim($_POST['b'] ?? '');

    if (empty($title_in) || empty($body_in)) {
        $msg = "Title and body required.";
    } else {
        $sql = "INSERT INTO forum_posts (member_id, subject, content) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        mysqli_stmt_bind_param($stmt, 'iss', $member_pk, $title_in, $body_in);
        
        if (mysqli_stmt_execute($stmt)) {
            $new_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);
            header("Location: thread.php?id=$new_id"); 
            exit;
        } else {
            $msg = "Error creating post.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Post</title>
    <style>body{font-family:Arial;max-width:700px;margin:24px;}</style>
</head>
<body>
    <h2>New Discussion Post</h2>
    <?php if (!empty($msg)): ?>
        <p style="color:red;"><?= htmlspecialchars($msg); ?></p>
    <?php endif; ?>
    
    <form method="post" action="new_thread.php">
        <label>Title</label><br>
        <input name="t" style="width:100%" required><br><br>
        <label>Body</label><br>
        <textarea name="b" rows="6" style="width:100%" required></textarea><br><br>
        <button type="submit">Submit Post</button>
    </form>
    
    <p><a href="threads.php">Back to Threads</a></p>
</body>
</html>