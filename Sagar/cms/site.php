<?php
require 'db.php';
$res = mysqli_query($mysqli, "SELECT a.aid, a.title, a.created_at, w.uname
                             FROM articles a JOIN writers w ON a.writer_id = w.wid
                             WHERE a.live = 1
                             ORDER BY a.created_at DESC");
$rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Simple Blog</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <div style="float:right"><a href="signin.php">Writer sign in</a></div><div style="clear:both"></div>
  <h1>Blog</h1>

  <?php if (empty($rows)): ?><p>No articles yet.</p><?php else: foreach ($rows as $r): ?>
    <div style="border:1px solid #eee;padding:12px;margin-bottom:12px">
      <h2><a href="article.php?id=<?= $r['aid'] ?>"><?= esc($r['title']) ?></a></h2>
      <p style="color:#666">By <?= esc($r['uname']) ?> on <?= $r['created_at'] ?></p>
      <p><a href="article.php?id=<?= $r['aid'] ?>">Read more</a></p>
    </div>
  <?php endforeach; endif; ?>
</body></html>
