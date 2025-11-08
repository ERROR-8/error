<?php
require 'db.php';
$id = (int)($_GET['id'] ?? 0);
if($id <= 0) { header("Location: index.php"); exit; }

// fetch post
$stmt = mysqli_prepare($conn, "SELECT p.title, p.content, p.created_at, u.username
                               FROM posts p JOIN users u ON p.user_id=u.id WHERE p.id=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);
if(!$post){ header("Location: index.php"); exit; }

// add reply
$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST' && !empty($_SESSION['user_id'])){
  $text = trim($_POST['message']);
  if($text==='') $msg="Message required.";
  else {
    $add = mysqli_prepare($conn, "INSERT INTO replies (post_id, user_id, message) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($add, "iis", $id, $_SESSION['user_id'], $text);
    mysqli_stmt_execute($add);
    mysqli_stmt_close($add);
    header("Location: post.php?id=$id"); exit;
  }
}

// fetch replies
$r = mysqli_prepare($conn, "SELECT r.message, r.created_at, u.username
                            FROM replies r JOIN users u ON r.user_id=u.id
                            WHERE r.post_id=? ORDER BY r.created_at ASC");
mysqli_stmt_bind_param($r, "i", $id);
mysqli_stmt_execute($r);
$res2 = mysqli_stmt_get_result($r);
$replies = mysqli_fetch_all($res2, MYSQLI_ASSOC);
mysqli_stmt_close($r);
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?=htmlspecialchars($post['title'])?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
<p><a href="index.php">← Back</a></p>
<h2><?=htmlspecialchars($post['title'])?></h2>
<p style="color:#666">by <?=htmlspecialchars($post['username'])?> on <?=$post['created_at']?></p>
<div style="border:1px solid #ccc;padding:12px;margin-bottom:18px"><?=nl2br(htmlspecialchars($post['content']))?></div>

<h3>Replies (<?=count($replies)?>)</h3>
<?php if(empty($replies)) echo "<p>No replies yet.</p>"; else foreach($replies as $r): ?>
  <div style="border-top:1px solid #eee;padding:8px 0;">
    <p><?=nl2br(htmlspecialchars($r['message']))?></p>
    <p style="color:#666;font-size:13px">— <?=htmlspecialchars($r['username'])?>, <?=$r['created_at']?></p>
  </div>
<?php endforeach; ?>

<?php if(empty($_SESSION['user_id'])): ?>
  <p><a href="login.php">Login</a> to reply.</p>
<?php else: ?>
  <?php if($msg) echo "<p style='color:red;'>$msg</p>"; ?>
  <form method="post">
    <textarea name="message" rows="4" style="width:100%" required></textarea><br><br>
    <button>Reply</button>
  </form>
<?php endif; ?>
</body></html>
