<?php
require 'db.php';

$res = mysqli_query($conn, "SELECT t.id, t.title, t.created, u.name
  FROM topics t JOIN users u ON t.user_id = u.id
  ORDER BY t.created DESC");
$topics = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Mini Forum</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
<div style="float:right">
  <?php if(!empty($_SESSION['name'])): ?>
    Hi <?=htmlspecialchars($_SESSION['name'])?> |
    <a href="newtopic.php">New Topic</a> |
    <a href="logout.php">Logout</a>
  <?php else: ?>
    <a href="login.php">Login</a> | <a href="register.php">Register</a>
  <?php endif; ?>
</div>
<div style="clear:both"></div>

<h2>Forum Topics</h2>
<?php if(empty($topics)): ?>
  <p>No topics yet. <?php if(!empty($_SESSION['name'])) echo '<a href="newtopic.php">Create one</a>.'; ?></p>
<?php else: foreach($topics as $t): ?>
  <div style="border:1px solid #ddd;padding:12px;margin-bottom:12px;">
    <h3><a href="view.php?id=<?=$t['id']?>"><?=htmlspecialchars($t['title'])?></a></h3>
    <p style="color:#666;font-size:13px;">by <?=htmlspecialchars($t['name'])?> on <?=$t['created']?></p>
  </div>
<?php endforeach; endif; ?>
</body></html>
