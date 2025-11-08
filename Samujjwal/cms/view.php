<?php
require 'db.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT p.*, a.username FROM posts p JOIN authors a ON p.author_id = a.id WHERE p.id = :id AND p.published = 1 LIMIT 1");
$stmt->execute([':id'=>$id]);
$post = $stmt->fetch();
if (!$post) { header('Location: index.php'); exit; }
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?= h($post['title']) ?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <p><a href="index.php">← Back</a></p>
  <h1><?= h($post['title']) ?></h1>
  <p style="color:#666">By <?= h($post['username']) ?> on <?= $post['created_at'] ?></p>
  <div style="border:1px solid #eee;padding:12px;margin-top:12px"><?= nl2br(h($post['content'])) ?></div>
  <?php if (!empty($_SESSION['author_id']) && $_SESSION['author_id'] == $post['author_id']): ?>
    <p><a href="admin.php?edit=<?= $post['id'] ?>">Edit</a> | <a href="admin.php?delete=<?= $post['id'] ?>" onclick="return confirm('Delete?')">Delete</a></p>
  <?php endif; ?>
</body></html>
