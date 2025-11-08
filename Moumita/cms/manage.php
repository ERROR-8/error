<?php
require 'db.php';
if (empty($_SESSION['uid'])) { header('Location: login.php'); exit; }
$uid = $_SESSION['uid'];

// Delete
if (!empty($_GET['del'])) {
  $pid = (int)$_GET['del'];
  $pdo->prepare("DELETE FROM posts WHERE pid = :id AND uid = :u")->execute([':id'=>$pid, ':u'=>$uid]);
  header('Location: manage.php'); exit;
}

// Save (create/update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pid = (int)($_POST['pid'] ?? 0);
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  $is_public = isset($_POST['is_public']) ? 1 : 0;

  if ($title !== '' && $content !== '') {
    $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($title));
    $slug = trim($slug, '-') ?: 'post';
    $i = 1;
    while (true) {
      $q = $pdo->prepare("SELECT pid FROM posts WHERE slug = :s" . ($pid ? " AND pid <> :p" : ""));
      $params = [':s'=>$slug];
      if ($pid) $params[':p'] = $pid;
      $q->execute($params);
      if (!$q->fetch()) break;
      $slug = $slug . '-' . $i++;
    }

    if ($pid) {
      $u = $pdo->prepare("UPDATE posts SET title=:t, slug=:s, content=:c, is_public=:pub, updated_at=NOW() WHERE pid=:id AND uid=:u");
      $u->execute([':t'=>$title, ':s'=>$slug, ':c'=>$content, ':pub'=>$is_public, ':id'=>$pid, ':u'=>$uid]);
    } else {
      $i = $pdo->prepare("INSERT INTO posts (title, slug, content, uid, is_public) VALUES (:t,:s,:c,:u,:pub)");
      $i->execute([':t'=>$title, ':s'=>$slug, ':c'=>$content, ':u'=>$uid, ':pub'=>$is_public]);
    }
    header('Location: manage.php'); exit;
  }
}

// Load posts
$posts = $pdo->prepare("SELECT * FROM posts WHERE uid = :u ORDER BY created_at DESC");
$posts->execute([':u'=>$uid]);
$list = $posts->fetchAll();

// Edit
$edit = null;
if (!empty($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $p = $pdo->prepare("SELECT * FROM posts WHERE pid = :id AND uid = :u");
  $p->execute([':id'=>$id, ':u'=>$uid]);
  $edit = $p->fetch();
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Manage</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
<div style="float:right">Logged in as <?= clean($_SESSION['uname']) ?> | <a href="logout.php">Logout</a></div>
<div style="clear:both"></div>

<h2>Your Posts</h2>
<p><a href="home.php">Public site</a></p>

<?php if (!$list): ?>
  <p>No posts yet.</p>
<?php else: foreach ($list as $p): ?>
  <div style="border:1px solid #ddd;padding:10px;margin-bottom:10px">
    <h3><?= clean($p['title']) ?> <?= $p['is_public'] ? '' : '<em>(Private)</em>' ?></h3>
    <p><a href="manage.php?edit=<?= $p['pid'] ?>">Edit</a> |
       <a href="manage.php?del=<?= $p['pid'] ?>" onclick="return confirm('Delete?')">Delete</a> |
       <a href="view.php?id=<?= $p['pid'] ?>">View</a></p>
  </div>
<?php endforeach; endif; ?>

<hr>
<h2><?= $edit ? 'Edit Post' : 'Create Post' ?></h2>
<form method="post">
  <input type="hidden" name="pid" value="<?= $edit ? $edit['pid'] : 0 ?>">
  <label>Title</label><br><input name="title" style="width:100%" value="<?= $edit ? clean($edit['title']) : '' ?>" required><br><br>
  <label>Content</label><br><textarea name="content" rows="8" style="width:100%" required><?= $edit ? clean($edit['content']) : '' ?></textarea><br><br>
  <label><input type="checkbox" name="is_public" <?= $edit ? ($edit['is_public']?'checked':''):'checked' ?>> Public</label><br><br>
  <button><?= $edit ? 'Update' : 'Create' ?></button>
  <?php if($edit): ?><a href="manage.php" style="margin-left:10px">Cancel</a><?php endif; ?>
</form>
</body></html>
