<?php
require 'db.php';
$res = mysqli_query($conn, "SELECT p.id, p.title, p.created_at, u.username
                            FROM posts p JOIN users u ON p.user_id = u.id
                            ORDER BY p.created_at DESC");
$posts = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Easy Forum</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
<div style="float:right;">
  <?php if(!empty($_SESSION['user'])): ?>
    Welcome <?=htmlspecialchars($_SESSION['user'])?> |
    <a href="create.php">New Post</a> |
    <a href="logout.php">Logout</a>
  <?php else: ?>
    <a href="login.php">Login</a> | <a href="register.php">Register</a>
  <?php endif; ?>
</div>
<div style="clear:both"></div>

<h2>Forum Posts</h2>
<?php if(empty($posts)): ?>
  <p>No posts yet. <?php if(!empty($_SESSION['user'])) echo '<a href="create.php">Add one</a>.'; ?></p>
<?php else: foreach($posts as $p): ?>
  <div style="border:1px solid #ccc;padding:12px;margin-bottom:10px;">
    <h3><a href="post.php?id=<?=$p['id']?>"><?=htmlspecialchars($p['title'])?></a></h3>
    <p style="color:#666;">by <?=htmlspecialchars($p['username'])?> on <?=$p['created_at']?></p>
  </div>
<?php endforeach; endif; ?>
</body></html>
