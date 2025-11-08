<?php
require 'db.php';
$id = (int)($_GET['id'] ?? 0);
if($id<=0) { header('Location: home.php'); exit; }

// fetch topic
$stmt = mysqli_prepare($conn, "SELECT t.title, t.content, t.created, u.name
  FROM topics t JOIN users u ON t.user_id=u.id WHERE t.id=? LIMIT 1");
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$topic = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);
if(!$topic){ header('Location: home.php'); exit; }

// reply submit
$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST' && !empty($_SESSION['id'])){
  $reply = trim($_POST['reply']);
  if($reply==='') $msg="Reply can't be empty.";
  else {
    $add = mysqli_prepare($conn, "INSERT INTO replies (topic_id, user_id, reply) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($add,"iis",$id,$_SESSION['id'],$reply);
    mysqli_stmt_execute($add);
    mysqli_stmt_close($add);
    header("Location: view.php?id=$id"); exit;
  }
}

// fetch replies
$r = mysqli_prepare($conn,"SELECT r.reply,r.created,u.name FROM replies r JOIN users u ON r.user_id=u.id WHERE r.topic_id=? ORDER BY r.created ASC");
mysqli_stmt_bind_param($r,"i",$id);
mysqli_stmt_execute($r);
$res2 = mysqli_stmt_get_result($r);
$replies = mysqli_fetch_all($res2,MYSQLI_ASSOC);
mysqli_stmt_close($r);
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?=htmlspecialchars($topic['title'])?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
<p><a href="home.php">← Back</a></p>
<h2><?=htmlspecialchars($topic['title'])?></h2>
<p style="color:#666">by <?=htmlspecialchars($topic['name'])?> on <?=$topic['created']?></p>
<div style="border:1px solid #ddd;padding:12px;margin-bottom:18px"><?=nl2br(htmlspecialchars($topic['content']))?></div>

<h3>Replies (<?=count($replies)?>)</h3>
<?php if(empty($replies)) echo "<p>No replies yet.</p>"; else foreach($replies as $r): ?>
  <div style="border-top:1px solid #eee;padding:8px 0;">
    <p><?=nl2br(htmlspecialchars($r['reply']))?></p>
    <p style="color:#666;font-size:13px">— <?=htmlspecialchars($r['name'])?>, <?=$r['created']?></p>
  </div>
<?php endforeach; ?>

<?php if(empty($_SESSION['id'])): ?>
  <p><a href="login.php">Login</a> to reply.</p>
<?php else: ?>
  <?php if($msg) echo "<p style='color:red;'>$msg</p>"; ?>
  <form method="post">
    <textarea name="reply" rows="4" style="width:100%" required></textarea><br><br>
    <button>Post reply</button>
  </form>
<?php endif; ?>
</body></html>
