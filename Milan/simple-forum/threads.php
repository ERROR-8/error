<?php
require 'db.php';

$res_threads = mysqli_query($link, "SELECT t.thread_id, t.title, t.created_at, u.username 
    FROM threads t JOIN users u ON t.user_id = u.user_id 
    ORDER BY t.created_at DESC");

$discussion_list = mysqli_fetch_all($res_threads, MYSQLI_ASSOC);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Discussion Threads</title>
    <style>body{font-family:Arial;max-width:900px;margin:24px;}</style>
</head>
<body>
    <div style="float:right;">
        <?php if (!empty($_SESSION['username'])): ?>
            Hello **<?= htmlspecialchars($_SESSION['username']) ?>** | 
            <a href="new_thread.php">New Thread</a> | 
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a> | 
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
    <div style="clear:both;"></div>

    <h2>Current Discussion Topics</h2>

    <?php if (empty($discussion_list)): ?>
        <p>No threads posted yet. 
        <?php if (!empty($_SESSION['auth_id'])) echo '<a href="new_thread.php">Be the first to create one.</a>'; ?></p>
    <?php else: 
        foreach ($discussion_list as $topic): ?>
            <div style="border:1px solid #ddd;padding:12px;margin-bottom:12px;">
                <h3>
                    <a href="thread.php?id=<?= $topic['thread_id'] ?>">
                        <?= htmlspecialchars($topic['title']) ?>
                    </a>
                </h3>
                <p style="color:#666;font-size:14px;">
                    by **<?= htmlspecialchars($topic['username']) ?>** on **<?= $topic['created_at'] ?>**
                </p>
            </div>
        <?php endforeach;
    endif; ?>
</body>
</html>