<?php
require 'db.php';
if (empty($_SESSION['member_id'])) { header('Location: login.php'); exit; }
$uid = (int)$_SESSION['member_id'];
$msg = '';

// DELETE (GET ?delete=ID)
if (!empty($_GET['delete'])) {
    $pid = (int)$_GET['delete'];
    $d = $mysqli->prepare("DELETE FROM blog_posts WHERE post_id = ? AND author_id = ?");
    $d->bind_param('ii', $pid, $uid);
    $d->execute();
    $d->close();
    header('Location: manage.php'); exit;
}

// CREATE / UPDATE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = (int)($_POST['post_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $body  = trim($_POST['body'] ?? '');
    $published = isset($_POST['published']) ? 1 : 0;

    if ($title === '' || $body === '') $msg = "Title & body required.";
    else {
        // slug
        $base = preg_replace('/[^a-z0-9]+/i','-', strtolower($title));
        $base = trim($base, '-');
        $slug = $base ?: 'post';
        // ensure unique slug
        $i = 1;
        while (true) {
            if ($post_id > 0) {
                $q = $mysqli->prepare("SELECT post_id FROM blog_posts WHERE slug = ? AND post_id <> ? LIMIT 1");
                $q->bind_param('si', $slug, $post_id);
            } else {
                $q = $mysqli->prepare("SELECT post_id FROM blog_posts WHERE slug = ? LIMIT 1");
                $q->bind_param('s', $slug);
            }
            $q->execute();
            $q->store_result();
            if ($q->num_rows === 0) { $q->close(); break; }
            $q->close();
            $slug = $base . '-' . $i++;
        }

        if ($post_id > 0) {
            $u = $mysqli->prepare("UPDATE blog_posts SET title=?, slug=?, body=?, published=?, updated_at=NOW() WHERE post_id=? AND author_id=?");
            $u->bind_param('sssiii', $title, $slug, $body, $published, $post_id, $uid);
            $u->execute();
            $u->close();
            header('Location: manage.php'); exit;
        } else {
            $ins = $mysqli->prepare("INSERT INTO blog_posts (title, slug, body, author_id, published) VALUES (?, ?, ?, ?, ?)");
            $ins->bind_param('sssii', $title, $slug, $body, $uid, $published);
            $ins->execute();
            $ins->close();
            header('Location: manage.php'); exit;
        }
    }
}

// load posts of this author
$stmt = $mysqli->prepare("SELECT post_id, title, published, created_at, updated_at FROM blog_posts WHERE author_id = ? ORDER BY created_at DESC");
$stmt->bind_param('i', $uid);
$stmt->execute();
$res = $stmt->get_result();
$posts = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// load edit target
$edit = null;
if (!empty($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    $q = $mysqli->prepare("SELECT * FROM blog_posts WHERE post_id = ? AND author_id = ? LIMIT 1");
    $q->bind_param('ii', $eid, $uid);
    $q->execute();
    $r = $q->get_result();
    $edit = $r->fetch_assoc();
    $q->close();
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Manage</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <div style="float:right">Hi <?= esc($_SESSION['member_name']) ?> | <a href="logout.php">Logout</a></div><div style="clear:both"></div>
  <h2>Your posts</h2>
  <p><a href="site.php">Public site</a></p>

  <?php if (empty($posts)): ?><p>No posts yet.</p><?php else: foreach ($posts as $p): ?>
    <div style="border:1px solid #eee;padding:10px;margin-bottom:10px">
      <h3><?= esc($p['title']) ?> <?= $p['published'] ? '' : '<em>(draft)</em>' ?></h3>
      <p style="color:#666">Created: <?= $p['created_at'] ?> | Updated: <?= $p['updated_at'] ?></p>
      <p><a href="manage.php?edit=<?= $p['post_id'] ?>">Edit</a> | <a href="manage.php?delete=<?= $p['post_id'] ?>" onclick="return confirm('Delete?')">Delete</a> | <a href="post.php?id=<?= $p['post_id'] ?>">View</a></p>
    </div>
  <?php endforeach; endif; ?>

  <hr>
  <h2><?= $edit ? 'Edit post' : 'Create post' ?></h2>
  <?php if($msg) echo "<p style='color:red;'>".esc($msg)."</p>"; ?>
  <form method="post">
    <input type="hidden" name="post_id" value="<?= $edit ? (int)$edit['post_id'] : 0 ?>">
    <label>Title</label><br><input name="title" style="width:100%" value="<?= $edit ? esc($edit['title']) : '' ?>" required><br><br>
    <label>Body</label><br><textarea name="body" rows="8" style="width:100%" required><?= $edit ? esc($edit['body']) : '' ?></textarea><br><br>
    <label><input type="checkbox" name="published" <?= $edit ? ($edit['published'] ? 'checked' : '') : 'checked' ?>> Publish</label><br><br>
    <button><?= $edit ? 'Save' : 'Create' ?></button>
    <?php if ($edit): ?><a href="manage.php" style="margin-left:10px">Cancel</a><?php endif; ?>
  </form>
</body></html>
