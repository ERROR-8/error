<?php
require 'db.php';
$res = $mysqli->query("SELECT post_id, title, created_at FROM blog_posts WHERE published = 1 ORDER BY created_at DESC");
$rows = $res->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Blog</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <div style="float:right"><a href="login.php">Login</a></div><div style="clear:both"></div>
  <h1>Blog</h1>
  <?php if (empty($rows)) echo "<p>No posts yet.</p>"; else: foreach ($rows as $r): ?>
    <div style="border:1px solid #eee;padding:12px;margin-bottom:12px">
      <h2><a href="post.php?id=<?= $r['post_id'] ?>"><?= esc($r['title']) ?></a></h2>
      <p style="color:#666">Posted on <?= $r['created_at'] ?></p>
    </div>
  <?php endforeach; endif; ?>
</body></html>
