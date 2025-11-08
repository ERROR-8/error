<?php
require 'db.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: site.php'); exit; }
$stmt = $mysqli->prepare("SELECT p.*, m.member_name FROM blog_posts p JOIN members m ON p.author_id = m.member_id WHERE p.post_id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$post = $res->fetch_assoc();
$stmt->close();
if (!$post || (!$post['published'] && (empty($_SESSION['member_id']) || $_SESSION['member_id'] != $post['author_id']))) {
    header('Location: site.php'); exit;
}
?>
<!doctype html><html><head><meta charset="utf-8"><title><?= esc($post['title']) ?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <p><a href="site.php">← Back</a></p>
  <h1><?= esc($post['title']) ?></h1>
  <p style="color:#666">By <?= esc($post['member_name']) ?> on <?= $post['created_at'] ?></p>
  <div style="border:1px solid #eee;padding:12px;margin-top:12px"><?= nl2br(esc($post['body'])) ?></div>

  <?php if (!empty($_SESSION['member_id']) && $_SESSION['member_id'] == $post['author_id']): ?>
    <p><a href="manage.php?edit=<?= $id ?>">Edit</a> | <a href="manage.php?delete=<?= $id ?>" onclick="return confirm('Delete?')">Delete</a></p>
  <?php endif; ?>
</body></html>
