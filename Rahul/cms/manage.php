<?php
require 'db_connect.php';
if (empty($_SESSION['editor_id'])) { header('Location: login_editor.php'); exit; }
$eid = (int)$_SESSION['editor_id'];
$msg = '';

// delete (GET ?del=ID)
if (!empty($_GET['del'])) {
    $delId = (int)$_GET['del'];
    $d = $db->prepare("DELETE FROM entries WHERE entry_id = :id AND editor_id = :eid");
    $d->execute([':id'=>$delId, ':eid'=>$eid]);
    header('Location: manage.php'); exit;
}

// handle create/update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entry_id = (int)($_POST['entry_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $body  = trim($_POST['body'] ?? '');
    $live  = isset($_POST['live']) ? 1 : 0;

    if ($title === '' || $body === '') $msg = "Title and body required.";
    else {
        // make slug
        $base = preg_replace('/[^a-z0-9]+/i','-', strtolower($title));
        $base = trim($base, '-');
        $slug = $base ?: 'entry';
        // ensure unique slug
        $i = 1;
        while (true) {
            if ($entry_id) {
                $q = $db->prepare("SELECT entry_id FROM entries WHERE slug = :s AND entry_id <> :id LIMIT 1");
                $q->execute([':s'=>$slug, ':id'=>$entry_id]);
            } else {
                $q = $db->prepare("SELECT entry_id FROM entries WHERE slug = :s LIMIT 1");
                $q->execute([':s'=>$slug]);
            }
            if (!$q->fetch()) break;
            $slug = $base . '-' . $i++;
        }

        if ($entry_id) {
            $u = $db->prepare("UPDATE entries SET title=:t, slug=:s, body=:b, is_live=:l, updated_on = NOW() WHERE entry_id=:id AND editor_id=:eid");
            $u->execute([':t'=>$title, ':s'=>$slug, ':b'=>$body, ':l'=>$live, ':id'=>$entry_id, ':eid'=>$eid]);
            header('Location: manage.php'); exit;
        } else {
            $ins = $db->prepare("INSERT INTO entries (title, slug, body, editor_id, is_live) VALUES (:t,:s,:b,:eid,:l)");
            $ins->execute([':t'=>$title, ':s'=>$slug, ':b'=>$body, ':eid'=>$eid, ':l'=>$live]);
            header('Location: manage.php'); exit;
        }
    }
}

// load entries for editor
$stm = $db->prepare("SELECT entry_id, title, is_live, created_on, updated_on FROM entries WHERE editor_id = :eid ORDER BY created_on DESC");
$stm->execute([':eid'=>$eid]);
$list = $stm->fetchAll();

// load edit target
$edit = null;
if (!empty($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $q = $db->prepare("SELECT * FROM entries WHERE entry_id = :id AND editor_id = :eid LIMIT 1");
    $q->execute([':id'=>$editId, ':eid'=>$eid]);
    $edit = $q->fetch();
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Manage entries</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <div style="float:right">Hello <?= safe($_SESSION['editor_name']) ?> | <a href="logout_editor.php">Logout</a></div>
  <div style="clear:both"></div>

  <h2>Your entries</h2>
  <p><a href="home.php">Public site</a></p>

  <?php if (empty($list)): ?><p>No entries yet.</p><?php else: foreach ($list as $it): ?>
    <div style="border:1px solid #eee;padding:10px;margin-bottom:10px">
      <h3><?= safe($it['title']) ?> <?= $it['is_live'] ? '' : '<em>(draft)</em>' ?></h3>
      <p style="color:#666">Created: <?= $it['created_on'] ?> | Updated: <?= $it['updated_on'] ?></p>
      <p><a href="manage.php?edit=<?= $it['entry_id'] ?>">Edit</a> | <a href="manage.php?del=<?= $it['entry_id'] ?>" onclick="return confirm('Delete?')">Delete</a> | <a href="entry.php?id=<?= $it['entry_id'] ?>">View</a></p>
    </div>
  <?php endforeach; endif; ?>

  <hr>

  <h2><?= $edit ? 'Edit entry' : 'Create entry' ?></h2>
  <?php if ($msg) echo "<p style='color:red;'>".safe($msg)."</p>"; ?>
  <form method="post">
    <input type="hidden" name="entry_id" value="<?= $edit ? (int)$edit['entry_id'] : 0 ?>">
    <label>Title</label><br><input name="title" style="width:100%" value="<?= $edit ? safe($edit['title']) : '' ?>" required><br><br>
    <label>Body</label><br><textarea name="body" rows="8" style="width:100%" required><?= $edit ? safe($edit['body']) : '' ?></textarea><br><br>
    <label><input type="checkbox" name="live" <?= $edit ? ($edit['is_live'] ? 'checked' : '') : 'checked' ?>> Publish</label><br><br>
    <button><?= $edit ? 'Save' : 'Create' ?></button>
    <?php if ($edit): ?><a href="manage.php" style="margin-left:10px">Cancel</a><?php endif; ?>
  </form>
</body></html>
