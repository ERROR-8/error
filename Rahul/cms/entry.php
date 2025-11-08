<?php
require 'db_connect.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: home.php'); exit; }
$q = $db->prepare("SELECT e.*, ed.editor_name FROM entries e JOIN editors ed ON e.editor_id = ed.editor_id WHERE e.entry_id = :id LIMIT 1");
$q->execute([':id'=>$id]);
$entry = $q->fetch();
if (!$entry || (!$entry['is_live'] && (empty($_SESSION['editor_id']) || $_SESSION['editor_id'] != $entry['editor_id']))) {
    header('Location: home.php'); exit;
}
?>
<!doctype html><html><head><meta charset="utf-8"><title><?= safe($entry['title']) ?></title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <p><a href="home.php">← Back</a></p>
  <h1><?= safe($entry['title']) ?></h1>
  <p style="color:#666">By <?= safe($entry['editor_name']) ?> on <?= $entry['created_on'] ?></p>
  <div style="border:1px solid #eee;padding:12px;margin-top:12px"><?= nl2br(safe($entry['body'])) ?></div>
  <?php if (!empty($_SESSION['editor_id']) && $_SESSION['editor_id'] == $entry['editor_id']): ?>
    <p><a href="manage.php?edit=<?= $id ?>">Edit</a> | <a href="manage.php?del=<?= $id ?>" onclick="return confirm('Delete?')">Delete</a></p>
  <?php endif; ?>
</body></html>
