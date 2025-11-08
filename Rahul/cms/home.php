<?php
require 'db_connect.php';
$stm = $db->query("SELECT entry_id, title, created_on FROM entries WHERE is_live = 1 ORDER BY created_on DESC");
$rows = $stm->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Blog</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <div style="float:right"><a href="login_editor.php">Editor login</a></div><div style="clear:both"></div>
  <h1>Blog</h1>
  <?php if (empty($rows)) echo "<p>No posts yet.</p>"; else: foreach ($rows as $r): ?>
    <div style="border:1px solid #eee;padding:12px;margin-bottom:12px">
      <h2><a href="entry.php?id=<?= $r['entry_id'] ?>"><?= safe($r['title']) ?></a></h2>
      <p style="color:#666">Posted on <?= $r['created_on'] ?></p>
    </div>
  <?php endforeach; endif; ?>
</body></html>
