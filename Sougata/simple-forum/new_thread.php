<?php
require 'db.php';

if (empty($_SESSION['auth_id'])) {
    header('Location: login.php');
    exit;
}

$notice = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body  = trim($_POST['body'] ?? '');

    if ($title === '' || $body === '') {
        $notice = 'Title and body are required.';
    } else {
        $userId = (int)($_SESSION['auth_id']);
        $stmt = mysqli_prepare($link, "INSERT INTO threads (user_id, title, body) VALUES (?, ?, ?)");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iss', $userId, $title, $body);

            if (mysqli_stmt_execute($stmt)) {
                $threadId = mysqli_insert_id($link);
                mysqli_stmt_close($stmt);
                header('Location: thread.php?id=' . (int)$threadId);
                exit;
            }

            mysqli_stmt_close($stmt);
            $notice = 'Failed to create thread.';
        } else {
            $notice = 'Database error.';
        }
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

    <?php if ($notice !== ''): ?>
        <p style="color:red;"><?= htmlspecialchars($notice, ENT_QUOTES | ENT_HTML5) ?></p>
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