<?php
require 'db.php';
$id = (int)($_GET['id'] ?? 0);
$q = $pdo->prepare("SELECT p.*, u.uname FROM posts p JOIN users u ON p.uid = u.uid WHERE p.pid = :id LIMIT 1");
$q->execute([':id'=>$id]);
$post = $q->fetch();
if (!$post || (!$post['is_public'] && (empty($_SESSION['uid']) || $_SESSION['uid'] != $post['uid']))) {
  header('Location: home.php'); exit;
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?= clean($post['title']) ?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
<p><a href="home.php">← Back</a></p>
<h1><?= clean($post['title']) ?></h1>
<p style="color:#666">By <?= clean($post['uname']) ?> on <?= $post['created_at'] ?></p>
<div style="border:1px solid #ddd;padding:12px;margin-top:12px"><?= nl2br(clean($post['content'])) ?></div>
<?php if (!empty($_SESSION['uid']) && $_SESSION['uid'] == $post['uid']): ?>
<p><a href="manage.php?edit=<?= $post['pid'] ?>">Edit</a> | <a href="manage.php?del=<?= $post['pid'] ?>" onclick="return confirm('Delete?')">Delete</a></p>
<?php endif; ?>
</body></html>
