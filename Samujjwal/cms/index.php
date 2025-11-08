<?php
require 'db.php';
$stmt = $pdo->query("SELECT p.id, p.title, p.slug, p.created_at, a.username
                     FROM posts p JOIN authors a ON p.author_id = a.id
                     WHERE p.published = 1
                     ORDER BY p.created_at DESC");
$posts = $stmt->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Blog</title></head>
<body style="font-family: Arial; max-width:900px;margin:24px">
  <div style="float:right"><a href="login.php">Author login</a></div><div style="clear:both"></div>
  <h1>Blog</h1>
  <?php if (empty($posts)): ?><p>No posts yet.</p><?php else: foreach ($posts as $p): ?>
    <div style="border:1px solid #eee;padding:12px;margin-bottom:12px">
      <h2><a href="view.php?id=<?= $p['id'] ?>"><?= h($p['title']) ?></a></h2>
      <p style="color:#666">By <?= h($p['username']) ?> on <?= $p['created_at'] ?></p>
      <p><a href="view.php?id=<?= $p['id'] ?>">Read more</a></p>
    </div>
  <?php endforeach; endif; ?>
</body></html>
