<?php
// thread.php
require 'db.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: threads.php'); exit; }

// fetch thread
$stmt = mysqli_prepare($mysqli, "SELECT t.id, t.title, t.body, t.created_at, u.username FROM threads t JOIN users u ON t.user_id = u.id WHERE t.id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$thread = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);
if (!$thread) { header('Location: threads.php'); exit; }

// handle reply
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['user_id'])) {
    $body = trim($_POST['body'] ?? '');
    if ($body === '') { $msg = "Reply cannot be empty."; }
    else {
        $ins = mysqli_prepare($mysqli, "INSERT INTO replies (thread_id, user_id, body) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($ins, 'iis', $id, $_SESSION['user_id'], $body);
        if (mysqli_stmt_execute($ins)) {
            mysqli_stmt_close($ins);
            header('Location: thread.php?id=' . $id); exit;
        } else {
            $msg = "Failed to add reply.";
        }
        mysqli_stmt_close($ins);
    }
}

// fetch replies
$r = mysqli_prepare($mysqli, "SELECT r.body, r.created_at, u.username FROM replies r JOIN users u ON r.user_id = u.id WHERE r.thread_id = ? ORDER BY r.created_at ASC");
mysqli_stmt_bind_param($r, 'i', $id);
mysqli_stmt_execute($r);
$res2 = mysqli_stmt_get_result($r);
$replies = mysqli_fetch_all($res2, MYSQLI_ASSOC);
mysqli_stmt_close($r);
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title><?= htmlspecialchars($thread['title']) ?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <p><a href="threads.php">← Back to threads</a></p>
  <h2><?= htmlspecialchars($thread['title']) ?></h2>
  <p style="color:#666">by <?= htmlspecialchars($thread['username']) ?> on <?= $thread['created_at'] ?></p>
  <div style="border:1px solid #ddd;padding:12px;margin-bottom:18px"><?= nl2br(htmlspecialchars($thread['body'])) ?></div>

  <h3>Replies (<?= count($replies) ?>)</h3>
  <?php if (empty($replies)) echo "<p>No replies yet.</p>"; else:
    foreach ($replies as $rep): ?>
      <div style="border-top:1px solid #eee;padding:8px 0;">
        <p><?= nl2br(htmlspecialchars($rep['body'])) ?></p>
        <p style="color:#666;font-size:13px">— <?= htmlspecialchars($rep['username']) ?>, <?= $rep['created_at'] ?></p>
      </div>
  <?php endforeach; endif; ?>

  <?php if (empty($_SESSION['user_id'])): ?>
    <p><a href="login.php">Login</a> to reply.</p>
  <?php else: ?>
    <?php if ($msg) echo "<p style='color:red;'>".htmlspecialchars($msg)."</p>"; ?>
    <form method="post" action="thread.php?id=<?= $id ?>">
      <textarea name="body" rows="4" style="width:100%" required></textarea><br><br>
      <button type="submit">Post Reply</button>
    </form>
  <?php endif; ?>
</body>
</html>
