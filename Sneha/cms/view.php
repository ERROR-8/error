<?php
require 'db.php';

$pid = (int)($_GET['id'] ?? 0); 
$stmt = $db_conn->prepare("SELECT p.*, u.uname FROM posts p JOIN users u ON p.uid = u.uid WHERE p.pid = :pid LIMIT 1"); 
$stmt->execute([':pid'=>$pid]);
$article = $stmt->fetch();

if (!$article || (!$article['is_public'] && (empty($_SESSION['user_id']) || $_SESSION['user_id'] != $article['uid']))) { 
    header('Location: home.php'); exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8">
<title><?= sanitize_output($article['title']) ?></title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 0 auto; padding-top: 50px; line-height: 1.6;">

<p><a href="home.php">Return to Public Blog</a></p>
<h1><?= sanitize_output($article['title']) ?></h1>
<p style="color:#7f8c8d; font-size: 0.9em;">By <?= sanitize_output($article['uname']) ?> on <?= $article['created_at'] ?></p>
<div style="padding:15px 0 30px 0;"><?= nl2br(sanitize_output($article['content'])) ?></div>
<?php
if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $article['uid']): ?>
<p><a href="manage.php?edit=<?= $article['pid'] ?>">Edit</a> | <a href="manage.php?del=<?= $article['pid'] ?>" onclick="return confirm('Delete?');">Delete</a></p>
<?php endif; ?>
</body>
</html>