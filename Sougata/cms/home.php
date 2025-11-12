<?php
require_once 'db.php';

try {
    $stmt = $pdo_conn->prepare('SELECT post_id, title, created_at FROM posts WHERE is_public = 1 ORDER BY created_at DESC');
    $stmt->execute();
    $public_posts = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('[HOME] Query error: ' . $e->getMessage());
    $public_posts = [];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SimplePress Blog</title>
</head>
<body style="font-family:Arial, sans-serif;max-width:900px;margin:24px;">
    <div style="text-align:right;">
        <a href="login.php">Login</a>
    </div>

    <h1>SimplePress Blog</h1>

    <?php if (empty($public_posts)): ?>
        <p>No posts yet.</p>
    <?php else: ?>
        <?php foreach ($public_posts as $post): ?>
            <div style="border:1px solid #eee;padding:12px;margin-bottom:12px;">
                <h2>
                    <a href="view.php?id=<?= (int)$post['post_id'] ?>">
                        <?= escape_html($post['title']) ?>
                    </a>
                </h2>
                <p style="color:#666">
                    Published on <?= escape_html($post['created_at']) ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>