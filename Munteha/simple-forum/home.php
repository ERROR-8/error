<?php
// home.php
require 'config.php';

// fetch threads (latest first)
$stmt = $db->query("SELECT t.id, t.title, t.created_at, u.username
                    FROM threads t JOIN users u ON t.user_id = u.id
                    ORDER BY t.created_at DESC");
$threads = $stmt->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Forum Home</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <div style="float:right;">
    <?php if (!empty($_SESSION['username'])): ?>
      Hello <?=htmlspecialchars($_SESSION['username'])?> | <a href="new_thread.php">New thread</a> | <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a> | <a href="register.php">Register</a>
    <?php endif; ?>
  </div>
  <div style="clear:both"></div>

  <h2>Threads</h2>
  <?php if (empty($threads)): ?>
    <p>No threads yet.</p>
  <?php else: foreach ($threads as $t): ?>
    <div style="border:1px solid #ddd;padding:12px;margin-bottom:12px;">
      <h3><a href="thread.php?id=<?= $t['id'] ?>"><?= htmlspecialchars($t['title']) ?></a></h3>
      <p style="color:#666">by <?= htmlspecialchars($t['username']) ?> on <?= $t['created_at'] ?></p>
    </div>
  <?php endforeach; endif; ?>
</body></html>
