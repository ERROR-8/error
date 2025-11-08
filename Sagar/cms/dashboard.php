<?php
require 'db.php';
if (empty($_SESSION['writer_id'])) { header('Location: signin.php'); exit; }
$wid = (int)$_SESSION['writer_id'];
$msg = '';

// Delete (GET ?delete=ID)
if (!empty($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $d = mysqli_prepare($mysqli, "DELETE FROM articles WHERE aid = ? AND writer_id = ?");
    mysqli_stmt_bind_param($d, 'ii', $id, $wid);
    mysqli_stmt_execute($d);
    mysqli_stmt_close($d);
    header('Location: dashboard.php'); exit;
}

// Create / Update (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aid = (int)($_POST['aid'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $body  = trim($_POST['body'] ?? '');
    $live  = isset($_POST['live']) ? 1 : 0;

    if ($title === '' || $body === '') {
        $msg = "Title and body required.";
    } else {
        // simple slug
        $base = preg_replace('/[^a-z0-9]+/i','-', strtolower($title));
        $base = trim($base, '-');
        $slug = $base ?: 'post';
        // ensure unique slug
        $i = 1;
        while (true) {
            if ($aid > 0) {
                $q = mysqli_prepare($mysqli, "SELECT aid FROM articles WHERE slug = ? AND aid <> ? LIMIT 1");
                mysqli_stmt_bind_param($q, 'si', $slug, $aid);
            } else {
                $q = mysqli_prepare($mysqli, "SELECT aid FROM articles WHERE slug = ? LIMIT 1");
                mysqli_stmt_bind_param($q, 's', $slug);
            }
            mysqli_stmt_execute($q);
            mysqli_stmt_store_result($q);
            if (mysqli_stmt_num_rows($q) === 0) { mysqli_stmt_close($q); break; }
            mysqli_stmt_close($q);
            $slug = $base . '-' . $i++;
        }

        if ($aid > 0) {
            $u = mysqli_prepare($mysqli, "UPDATE articles SET title = ?, slug = ?, body = ?, live = ?, updated_at = NOW() WHERE aid = ? AND writer_id = ?");
            mysqli_stmt_bind_param($u, 'ssiiii', $title, $slug, $body, $live, $aid, $wid);
            mysqli_stmt_execute($u);
            mysqli_stmt_close($u);
            header('Location: dashboard.php'); exit;
        } else {
            $ins = mysqli_prepare($mysqli, "INSERT INTO articles (title, slug, body, writer_id, live) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($ins, 'sssii', $title, $slug, $body, $wid, $live);
            mysqli_stmt_execute($ins);
            mysqli_stmt_close($ins);
            header('Location: dashboard.php'); exit;
        }
    }
}

// Load writer's articles
$res = mysqli_prepare($mysqli, "SELECT aid, title, live, created_at, updated_at FROM articles WHERE writer_id = ? ORDER BY created_at DESC");
mysqli_stmt_bind_param($res, 'i', $wid);
mysqli_stmt_execute($res);
$result = mysqli_stmt_get_result($res);
$articles = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($res);

// If editing (?edit=ID), load article
$edit = null;
if (!empty($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    $q = mysqli_prepare($mysqli, "SELECT aid, title, body, live FROM articles WHERE aid = ? AND writer_id = ? LIMIT 1");
    mysqli_stmt_bind_param($q, 'ii', $eid, $wid);
    mysqli_stmt_execute($q);
    $r = mysqli_stmt_get_result($q);
    $edit = mysqli_fetch_assoc($r);
    mysqli_stmt_close($q);
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Dashboard</title></head>
<body style="font-family:Arial;max-width:900px;margin:24px">
  <div style="float:right">Logged as <?= esc($_SESSION['uname']) ?> | <a href="signout.php">Sign out</a></div>
  <div style="clear:both"></div>

  <h2>Your articles</h2>
  <p><a href="site.php">View site</a></p>

  <?php if (empty($articles)): ?>
    <p>No articles yet.</p>
  <?php else: foreach ($articles as $a): ?>
    <div style="border:1px solid #eee;padding:10px;margin-bottom:10px">
      <h3><?= esc($a['title']) ?> <?= $a['live'] ? '' : '<em>(draft)</em>' ?></h3>
      <p style="color:#666">Created: <?= $a['created_at'] ?> | Updated: <?= $a['updated_at'] ?></p>
      <p>
        <a href="dashboard.php?edit=<?= $a['aid'] ?>">Edit</a> |
        <a href="dashboard.php?delete=<?= $a['aid'] ?>" onclick="return confirm('Delete?')">Delete</a> |
        <a href="article.php?id=<?= $a['aid'] ?>">View</a>
      </p>
    </div>
  <?php endforeach; endif; ?>

  <hr>
  <h2><?= $edit ? 'Edit article' : 'Create new article' ?></h2>
  <?php if ($msg) echo "<p style='color:red;'>".esc($msg)."</p>"; ?>
  <form method="post">
    <input type="hidden" name="aid" value="<?= $edit ? (int)$edit['aid'] : 0 ?>">
    <label>Title</label><br>
    <input name="title" style="width:100%" value="<?= $edit ? esc($edit['title']) : '' ?>" required><br><br>

    <label>Body</label><br>
    <textarea name="body" rows="8" style="width:100%" required><?= $edit ? esc($edit['body']) : '' ?></textarea><br><br>

    <label><input type="checkbox" name="live" <?= $edit ? ($edit['live'] ? 'checked' : '') : 'checked' ?>> Publish</label><br><br>

    <button><?= $edit ? 'Save changes' : 'Create article' ?></button>
    <?php if ($edit): ?><a href="dashboard.php" style="margin-left:10px">Cancel</a><?php endif; ?>
  </form>
</body></html>
