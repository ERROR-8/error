<?php
require 'db.php';

$sql = "SELECT t.thread_id, t.subject, t.post_date, m.username 
    FROM forum_posts t JOIN members m ON t.member_id = m.member_id 
    ORDER BY t.post_date DESC";

$res = mysqli_query($conn, $sql);
$post_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forum Threads</title>
    <style>body{font-family:Arial;max-width:900px;margin:24px;}</style>
</head>
<body>
    <div style="float:right;">
        <?php if (!empty($_SESSION['SESS_UNAME'])): ?>
            Hello, **<?= htmlspecialchars($_SESSION['SESS_UNAME']) ?>** | 
            <a href="new_thread.php">Post New Thread</a> | 
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a> | 
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
    <div style="clear:both;"></div>

    <h2>Forum Topics</h2>

    <?php if (empty($post_list)): ?>
        <p>No threads. 
        <?php if (!empty($_SESSION['SESS_USER_ID'])) echo '<a href="new_thread.php">Create one now.</a>'; ?></p>
    <?php else: 
        foreach ($post_list as $item): ?>
            <div style="border:1px solid #ddd;padding:12px;margin-bottom:12px;">
                <h3>
                    <a href="thread.php?id=<?= $item['thread_id'] ?>">
                        <?= htmlspecialchars($item['subject']) ?>
                    </a>
                </h3>
                <p style="color:#666;font-size:14px;">
                    by **<?= htmlspecialchars($item['username']) ?>** on **<?= $item['post_date'] ?>**
                </p>
            </div>
        <?php endforeach;
    endif; ?>
</body>
</html>