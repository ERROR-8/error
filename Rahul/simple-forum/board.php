<?php
// board.php
require 'config.php';
$res = $mysqli->query("SELECT p.pid, p.title, p.created_at, u.uname
    FROM posts p JOIN users u ON p.user_id = u.uid
    ORDER BY p.created_at DESC");
$posts = $res->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Board</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <div style="float:right">
    <?php if(!empty($_SESSION['uname'])): ?>
      Hello <?=htmlspecialchars($_SESSION['uname'])?> | <a href="newpost.php">New post</a> | <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="signin.php">Sign in</a> | <a href="signup.php">Sign up</a>
    <?php endif; ?>
  </div>
  <div style="clear:both"></div>

  <h2>Posts</h2>
  <?php if(empty($posts)): ?>
    <p>No posts yet. <?php if(!empty($_SESSION['uname'])) echo '<a href="newpost.php">Create one</a>.'; ?></p>
  <?php else: foreach($posts as $p): ?>
    <div style="border:1px solid #ddd;padding:12px;margin-bottom:12px;">
      <h3><a href="post.php?id=<?= $p['pid'] ?>"><?= htmlspecialchars($p['title']) ?></a></h3>
      <p style="color:#666;font-size:13px">by <?= htmlspecialchars($p['uname']) ?> on <?= $p['created_at'] ?></p>
    </div>
  <?php endforeach; endif; ?>
</body></html>
