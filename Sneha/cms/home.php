<?php
require 'db.php';

$stmt = $db_conn->query("SELECT pid, title, created_at FROM posts WHERE is_public = 1 ORDER BY created_at DESC");
$post_list = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Daily Web Journal</title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 0 auto; padding-top: 50px; line-height: 1.6;">

<h1>Daily Web Journal</h1>
<p style="text-align: right;"><a href="login.php">Sign In</a></p>

<?php if (!$post_list): ?>
<p>No posts yet.</p><?php else: foreach ($post_list as $post_data): ?>
    <div style="border-bottom: 1px dashed #cccccc; padding: 15px 0; margin-bottom: 20px;">
        <h2><a href="view.php?id=<?= $post_data['pid'] ?>"><?= sanitize_output($post_data['title']) ?></a></h2>
        <p style="color:#7f8c8d; font-size: 0.9em;">Posted on <?= $post_data['created_at'] ?></p>
    </div>
<?php endforeach; endif; ?>
</body>
</html>