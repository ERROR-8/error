<?php
require 'db.php';

$requested_id = (int)($_GET['id'] ?? 0);

$fetch_post_q = "SELECT 
    p.*, 
    u.username 
FROM 
    posts p 
JOIN 
    users u ON p.user_uid = u.user_id 
WHERE 
    p.post_id = :post_id_param 
LIMIT 1";

$stmt = $dbConnect->prepare($fetch_post_q);
$stmt->execute([':post_id_param' => $requested_id]);

$post_details = $stmt->fetch();

if (!$post_details || 
    (!$post_details['is_public'] && 
     (empty($_SESSION['user_id']) || $_SESSION['user_id'] != $post_details['user_uid'])
    )
) {
    header('Location: home.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= sanitize_output($post_details['title']) ?></title>
    <style>body{font-family:Arial;max-width:900px;margin:24px;}</style>
</head>
<body>
    <p><a href="home.php">Back</a></p>
    <h1><?= sanitize_output($post_details['title']) ?></h1>
    <p style="color:#666">
        By <?= sanitize_output($post_details['username']) ?> on <?= $post_details['created_at'] ?>
    </p>
    <div style="border:1px solid #ddd;padding:12px;margin-top:12px;">
        <?= nl2br(sanitize_output($post_details['content'])) ?>
    </div>

    <?php 
    $is_author = !empty($_SESSION['user_id']) && $_SESSION['user_id'] == $post_details['user_uid'];
    if ($is_author): ?>
        <p>
            <a href="manage.php?edit=<?= $post_details['post_id'] ?>">Edit</a>
            |
            <a href="manage.php?del=<?= $post_details['post_id'] ?>" onclick="return confirm('Delete this post?');">Delete</a>
        </p>
    <?php endif; ?>
</body>
</html>