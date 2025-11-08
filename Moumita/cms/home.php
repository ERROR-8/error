<?php
require 'db.php';
$q = $pdo->query("SELECT pid, title, created_at FROM posts WHERE is_public = 1 ORDER BY created_at DESC");
$rows = $q->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>SimplePress Blog</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
<div style="float:right"><a href="login.php">Login</a></div><div style="clear:both"></div>
<h1>SimplePress Blog</h1>
<?php if (!$rows): ?><p>No posts yet.</p><?php else: foreach ($rows as $r): ?>
  <div style="border:1px solid #eee;padding:12px;margin-bottom:12px">
    <h2><a href="view.php?id=<?= $r['pid'] ?>"><?= clean($r['title']) ?></a></h2>
    <p style="color:#666">Posted on <?= $r['created_at'] ?></p>
  </div>
<?php endforeach; endif; ?>
</body></html>
