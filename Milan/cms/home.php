<?php
require 'db.php';

$query_stmt = $dbConnect->query("SELECT post_id, title, created_at FROM posts WHERE is_public = 1 ORDER BY created_at DESC");
$public_posts = $query_stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>SimplePress Blog</title>
</head>
<body style="font-family:Arial;max-width:900px;margin:24px;">
    <div style="float:right;">
        <a href="login.php">Login</a>
    </div>
    <div style="clear:both;"></div>
    <h1>SimplePress Blog</h1>

    <?php if (!$public_posts): ?>
        <p>No posts yet.</p>
    <?php else: 
        foreach ($public_posts as $post_data): ?>
            <div style="border:1px solid #eee;padding:12px;margin-bottom:12px;">
                <h2>
                    <a href="view.php?id=<?= $post_data['post_id'] ?>">
                        <?= sanitize_output($post_data['title']) ?>
                    </a>
                </h2>
                <p style="color:#666">
                    Published on <?= $post_data['created_at'] ?>
                </p>
            </div>
    <?php endforeach;
    endif; ?>
</body>
</html>