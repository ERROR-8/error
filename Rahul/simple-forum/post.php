<?php
// post.php
require 'config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: board.php'); exit; }

// fetch post
$stmt = $mysqli->prepare("SELECT p.pid, p.title, p.body, p.created_at, u.uname, p.user_id
    FROM posts p JOIN users u ON p.user_id = u.uid WHERE p.pid = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$post = $res->fetch_assoc();
$stmt->close();
if (!$post) { header('Location: board.php'); exit; }

// handle comment submit (inline simple)
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['uid'])) {
    $c = trim($_POST['comment'] ?? '');
    if ($c === '') $err = "Comment required.";
    else {
        $ins = $mysqli->prepare("INSERT INTO comments (post_id, user_id, body) VALUES (?, ?, ?)");
        $ins->bind_param('iis', $id, $_SESSION['uid'], $c);
        if ($ins->execute()) {
            $ins->close();
            header("Location: post.php?id=$id"); exit;
        } else {
            $err = "Could not add comment.";
            $ins->close();
        }
    }
}

// fetch comments
$cm = $mysqli->prepare("SELECT c.body, c.created_at, u.uname FROM comments c JOIN users u ON c.user_id = u.uid WHERE c.post_id = ? ORDER BY c.created_at ASC");
$cm->bind_param('i', $id);
$cm->execute();
$comments = $cm->get_result()->fetch_all(MYSQLI_ASSOC);
$cm->close();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?= htmlspecialchars($post['title']) ?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <p><a href="board.php">← Back to board</a></p>
  <h2><?= htmlspecialchars($post['title']) ?></h2>
  <p style="color:#666">by <?= htmlspecialchars($post['uname']) ?> on <?= $post['created_at'] ?></p>
  <div style="border:1px solid #ddd;padding:12px;margin-bottom:18px"><?= nl2br(htmlspecialchars($post['body'])) ?></div>

  <h3>Comments (<?= count($comments) ?>)</h3>
  <?php if (empty($comments)) echo "<p>No comments yet.</p>"; else:
    foreach($comments as $c): ?>
      <div style="border-top:1px solid #eee;padding:8px 0;">
        <p><?= nl2br(htmlspecialchars($c['body'])) ?></p>
        <p style="color:#666;font-size:13px">— <?= htmlspecialchars($c['uname']) ?>, <?= $c['created_at'] ?></p>
      </div>
  <?php endforeach; endif; ?>

  <?php if (empty($_SESSION['uid'])): ?>
    <p><a href="signin.php">Sign in</a> to comment.</p>
  <?php else: ?>
    <?php if ($err) echo "<p style='color:red;'>".htmlspecialchars($err)."</p>"; ?>
    <form method="post" action="post.php?id=<?= $id ?>">
      <textarea name="comment" rows="4" style="width:100%" required></textarea><br><br>
      <button>Post comment</button>
    </form>
  <?php endif; ?>
</body></html>
