<?php
require 'db.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: site.php'); exit; }

$stmt = mysqli_prepare($mysqli, "SELECT a.title, a.body, a.created_at, w.uname, a.writer_id, a.live FROM articles a JOIN writers w ON a.writer_id = w.wid WHERE a.aid = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$article = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$article) { header('Location: site.php'); exit; }
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?= esc($article['title']) ?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <p><a href="site.php">← Back</a></p>
  <h1><?= esc($article['title']) ?></h1>
  <p style="color:#666">By <?= esc($article['uname']) ?> on <?= $article['created_at'] ?></p>
  <div style="border:1px solid #eee;padding:12px;margin-top:12px"><?= nl2br(esc($article['body'])) ?></div>

  <?php if (!empty($_SESSION['writer_id']) && $_SESSION['writer_id'] == $article['writer_id']): ?>
    <p><a href="dashboard.php?edit=<?= $id ?>">Edit</a> | <a href="dashboard.php?delete=<?= $id ?>" onclick="return confirm('Delete?')">Delete</a></p>
  <?php endif; ?>
</body></html>
