<?php
// thread.php
require 'config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: home.php'); exit; }

// fetch thread
$stmt = $db->prepare("SELECT t.id, t.title, t.content, t.created_at, u.username, t.user_id
                      FROM threads t JOIN users u ON t.user_id = u.id
                      WHERE t.id = :id LIMIT 1");
$stmt->execute([':id'=>$id]);
$thread = $stmt->fetch();
if (!$thread) { header('Location: home.php'); exit; }

// fetch replies
$r = $db->prepare("SELECT r.content, r.created_at, u.username
                   FROM replies r JOIN users u ON r.user_id = u.id
                   WHERE r.thread_id = :id ORDER BY r.created_at ASC");
$r->execute([':id'=>$id]);
$replies = $r->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?= htmlspecialchars($thread['title']) ?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <p><a href="home.php">← Back to threads</a></p>
  <h2><?= htmlspecialchars($thread['title']) ?></h2>
  <p style="color:#666">by <?= htmlspecialchars($thread['username']) ?> on <?= $thread['created_at'] ?></p>
  <div style="border:1px solid #ddd;padding:12px;margin-bottom:18px"><?= nl2br(htmlspecialchars($thread['content'])) ?></div>

  <h3>Replies (<?= count($replies) ?>)</h3>
  <?php if (empty($replies)): ?><p>No replies yet.</p><?php else:
    foreach ($replies as $rep): ?>
      <div style="border-top:1px solid #eee;padding:8px 0;">
        <p><?= nl2br(htmlspecialchars($rep['content'])) ?></p>
        <p style="color:#666;font-size:13px">— <?= htmlspecialchars($rep['username']) ?>, <?= $rep['created_at'] ?></p>
      </div>
  <?php endforeach; endif; ?>

  <?php if (empty($_SESSION['user_id'])): ?>
    <p><a href="login.php">Login</a> to reply.</p>
  <?php else: ?>
    <form method="post" action="submit_reply.php">
      <input type="hidden" name="thread_id" value="<?= $id ?>">
      <textarea name="content" rows="4" style="width:100%" required></textarea><br><br>
      <button>Post reply</button>
    </form>
  <?php endif; ?>
</body></html>
