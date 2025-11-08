<?php
// admin.php
require 'db.php';
if (empty($_SESSION['author_id'])) { header('Location: login.php'); exit; }
$aid = (int)$_SESSION['author_id'];
$msg = '';

// handle delete (via GET ?delete=ID)
if (!empty($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $d = $pdo->prepare("DELETE FROM posts WHERE id = :id AND author_id = :aid");
    $d->execute([':id'=>$id, ':aid'=>$aid]);
    header('Location: admin.php'); exit;
}

// handle create/update (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = (int)($_POST['post_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $published = isset($_POST['published']) ? 1 : 0;

    if ($title === '' || $content === '') $msg = 'Title and content required.';
    else {
        // simple slug
        $base = preg_replace('/[^a-z0-9]+/i','-', strtolower($title));
        $base = trim($base, '-');
        $slug = $base ?: 'post';
        // ensure unique slug
        $i = 1;
        while (true) {
            $q = $pdo->prepare("SELECT id FROM posts WHERE slug = :s " . ($post_id ? "AND id <> :id" : "LIMIT 1"));
            $params = [':s'=>$slug];
            if ($post_id) $params[':id'] = $post_id;
            $q->execute($params);
            if (!$q->fetch()) break;
            $slug = $base . '-' . $i++;
        }

        if ($post_id) {
            $u = $pdo->prepare("UPDATE posts SET title=:t, slug=:s, content=:c, published=:p, updated_at=NOW() WHERE id=:id AND author_id=:aid");
            $u->execute([':t'=>$title, ':s'=>$slug, ':c'=>$content, ':p'=>$published, ':id'=>$post_id, ':aid'=>$aid]);
            header('Location: admin.php'); exit;
        } else {
            $ins = $pdo->prepare("INSERT INTO posts (title, slug, content, author_id, published) VALUES (:t,:s,:c,:aid,:p)");
            $ins->execute([':t'=>$title, ':s'=>$slug, ':c'=>$content, ':aid'=>$aid, ':p'=>$published]);
            header('Location: admin.php'); exit;
        }
    }
}

// load posts for listing
$stmt = $pdo->prepare("SELECT * FROM posts WHERE author_id = :aid ORDER BY created_at DESC");
$stmt->execute([':aid'=>$aid]);
$posts = $stmt->fetchAll();

// load edit target if ?edit=ID
$edit = null;
if (!empty($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $q = $pdo->prepare("SELECT * FROM posts WHERE id = :id AND author_id = :aid LIMIT 1");
    $q->execute([':id'=>$id, ':aid'=>$aid]);
    $edit = $q->fetch();
    if (!$edit) header('Location: admin.php');
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Admin</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <div style="float:right">Logged in as <?= h($_SESSION['username']) ?> | <a href="logout.php">Logout</a></div>
  <div style="clear:both"></div>

  <h2>Your Posts</h2>
  <p><a href="index.php">View public site</a></p>

  <?php if (empty($posts)): ?>
    <p>No posts yet.</p>
  <?php else: foreach ($posts as $p): ?>
    <div style="border:1px solid #eee;padding:10px;margin-bottom:10px">
      <h3><?= h($p['title']) ?> <?= $p['published'] ? '' : '<em>(Draft)</em>' ?></h3>
      <p style="color:#666">Created: <?= $p['created_at'] ?> | Updated: <?= $p['updated_at'] ?></p>
      <p>
        <a href="admin.php?edit=<?= $p['id'] ?>">Edit</a> |
        <a href="admin.php?delete=<?= $p['id'] ?>" onclick="return confirm('Delete?')">Delete</a> |
        <a href="view.php?id=<?= $p['id'] ?>">View</a>
      </p>
    </div>
  <?php endforeach; endif; ?>

  <hr>
  <h2><?= $edit ? 'Edit Post' : 'Create New Post' ?></h2>
  <?php if ($msg) echo '<p style="color:red;">'.h($msg).'</p>'; ?>
  <form method="post">
    <input type="hidden" name="post_id" value="<?= $edit ? (int)$edit['id'] : 0 ?>">
    <label>Title</label><br>
    <input name="title" style="width:100%" value="<?= $edit ? h($edit['title']) : '' ?>" required><br><br>

    <label>Content</label><br>
    <textarea name="content" rows="8" style="width:100%" required><?= $edit ? h($edit['content']) : '' ?></textarea><br><br>

    <label><input type="checkbox" name="published" <?= $edit ? ($edit['published'] ? 'checked' : '') : 'checked' ?>> Publish</label><br><br>

    <button><?= $edit ? 'Save changes' : 'Create post' ?></button>
    <?php if ($edit): ?><a href="admin.php" style="margin-left:10px">Cancel</a><?php endif; ?>
  </form>
</body></html>
