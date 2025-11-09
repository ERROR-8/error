<?php
require 'db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php'); exit;

if (isset($_GET['del'])) {
    $stmt = $db_conn->prepare("DELETE FROM posts WHERE pid = :id AND uid = :u");
    $stmt->execute([':id'=>$_GET['del'], ':u'=>$_SESSION['user_id']]);
    header('Location: manage.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = (int)($_POST['pid'] ?? 0);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $is_public = (int)($_POST['is_public'] ?? 0);
    $slug = str_replace(' ', '-', strtolower($title));

    $stmt = $db_conn->prepare("SELECT pid FROM posts WHERE slug = :s AND pid != :pid");
    $stmt->execute([':s'=>$slug, ':pid'=>$pid]);
    $slug_check = $stmt->fetch();

    if ($slug_check) {
        $slug = $slug.'-'.time();
    }
    
    $uid = $_SESSION['user_id'];

    if ($pid) {
        $stmt = $db_conn->prepare("UPDATE posts SET title=:t, slug=:s, content=:c, is_public=:p, updated_at=NOW() WHERE pid=:id AND uid=:u");
        $stmt->execute([':t'=>$title, ':s'=>$slug, ':c'=>$content, ':p'=>$is_public, ':id'=>$pid, ':u'=>$uid]);
    } else {
        $stmt = $db_conn->prepare("INSERT INTO posts (title, slug, content, uid, is_public) VALUES (:t, :s, :c, :u, :p)");
        $stmt->execute([':t'=>$title, ':s'=>$slug, ':c'=>$content, ':u'=>$uid, ':p'=>$is_public]);
    }
    header('Location: manage.php'); exit;
}

$stmt = $db_conn->prepare("SELECT * FROM posts WHERE uid = :u ORDER BY created_at DESC");
$stmt->execute([':u'=>$_SESSION['user_id']]);
$entry_list = $stmt->fetchAll();

$is_editing = (int)($_GET['edit'] ?? 0);
if ($is_editing) {
    $stmt = $db_conn->prepare("SELECT * FROM posts WHERE pid = :id AND uid = :u");
    $stmt->execute([':id'=>$is_editing, ':u'=>$_SESSION['user_id']]);
    $current_entry = $stmt->fetch(); 
    if (!$current_entry) $is_editing = null;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Manage Content</title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 0 auto; padding-top: 50px; line-height: 1.6;">

<p style="text-align: right;">Welcome: <?= $_SESSION['username'] ?> | <a href="logout.php">Sign Out</a></p>

<h3><a href="home.php">View Public Blog</a></h3>

<h2>Your Content Dashboard</h2>

<?php 
if (!$entry_list): ?>
    <p>No entries found. Create one below.</p>
<?php else: foreach ($entry_list as $entry): ?>
    <div style="border-bottom: 1px dashed #cccccc; padding: 15px 0; margin-bottom: 20px;">
        <h3><?= sanitize_output($entry['title']) ?> 
            <em style="color:#7f8c8d; font-weight: normal; font-size: 0.9em;"><?= $entry['is_public'] ? '(Public)' : '(Private)' ?></em>
        </h3>
        <p>
            <a href="manage.php?del=<?= $entry['pid'] ?>" onclick="return confirm('Delete?');">Delete</a> | 
            <a href="manage.php?edit=<?= $entry['pid'] ?>">Edit</a> | 
            <a href="view.php?id=<?= $entry['pid'] ?>">View</a>
        </p>
    </div>
<?php endforeach; endif; ?>

<h2><?= $is_editing ? 'Edit Existing Entry' : 'Create New Entry' ?></h2>

<form method="post">
    <input type="hidden" name="pid" value="<?= $is_editing ? $current_entry['pid'] : 0 ?>">
    <label>Title</label><br><input type="text" name="title" style="width:100%;" required 
        value="<?= $is_editing ? sanitize_output($current_entry['title']) : '' ?>"><br>
    <label>Content</label><br>
    <textarea name="content" style="width:100%;height:200px;" required><?= $is_editing ? sanitize_output($current_entry['content']) : '' ?></textarea><br>
    <label>Public/Private</label><br>
    <input type="checkbox" name="is_public" value="1" 
        <?= $is_editing && $current_entry['is_public'] ? 'checked' : '' ?>> Public/Live<br><br>
    <button><?= $is_editing ? 'Update Entry' : 'Publish Entry' ?></button>
    <?php if ($is_editing): ?><a href="manage.php" style="margin-left:10px;">Clear Form</a><?php endif; ?>
</form>
</body>
</html>