<?php
require_once 'db.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$db = connect_db();
$currentUserId = (int)$_SESSION['user_id'];
$statusMessage = '';
$editingPostId = null;

// DELETE (via ?del=ID)
if (isset($_GET['del'])) {
    $delId = (int)$_GET['del'];
    if ($delId > 0) {
        try {
            $q = "DELETE FROM posts WHERE post_id = :pid AND user_uid = :uid";
            $st = $db->prepare($q);
            $st->execute([':pid' => $delId, ':uid' => $currentUserId]);
        } catch (PDOException $e) {
            error_log('[MANAGE][DELETE] ' . $e->getMessage());
        }
    }
    header('Location: manage.php');
    exit;
}

// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = isset($_POST['pid']) ? (int)$_POST['pid'] : 0;
    $title = trim((string)($_POST['title'] ?? ''));
    $content = trim((string)($_POST['content'] ?? ''));
    $isPublic = isset($_POST['public']) ? 1 : 0;

    if ($title === '' || $content === '') {
        $statusMessage = 'Title and content cannot be empty.';
    } else {
        // make slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $title), '-'));

        try {
            // check duplicate slug (exclude current post when updating)
            $checkSql = "SELECT post_id FROM posts WHERE slug = :slug AND post_id != :exclude LIMIT 1";
            $stc = $db->prepare($checkSql);
            $stc->execute([':slug' => $slug, ':exclude' => $pid]);
            if ($stc->fetch()) {
                $statusMessage = 'A post with this title/slug already exists. Change the title.';
            } else {
                if ($pid > 0) {
                    $updateSql = "UPDATE posts SET title = :title, slug = :slug, content = :content, is_public = :is_public, updated_at = NOW()
                                  WHERE post_id = :pid AND user_uid = :uid";
                    $stu = $db->prepare($updateSql);
                    $stu->execute([
                        ':title' => $title,
                        ':slug' => $slug,
                        ':content' => $content,
                        ':is_public' => $isPublic,
                        ':pid' => $pid,
                        ':uid' => $currentUserId
                    ]);
                } else {
                    $insertSql = "INSERT INTO posts (title, slug, content, user_uid, is_public, created_at, updated_at)
                                  VALUES (:title, :slug, :content, :uid, :is_public, NOW(), NOW())";
                    $sti = $db->prepare($insertSql);
                    $sti->execute([
                        ':title' => $title,
                        ':slug' => $slug,
                        ':content' => $content,
                        ':uid' => $currentUserId,
                        ':is_public' => $isPublic
                    ]);
                }
                header('Location: manage.php');
                exit;
            }
        } catch (PDOException $e) {
            error_log('[MANAGE][SAVE] ' . $e->getMessage());
            $statusMessage = 'An error occurred while saving. Please try again.';
        }
    }
}

// LOAD post for editing (via ?edit=ID)
$editRow = null;
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    if ($eid > 0) {
        try {
            $q = "SELECT * FROM posts WHERE post_id = :pid AND user_uid = :uid LIMIT 1";
            $ste = $db->prepare($q);
            $ste->execute([':pid' => $eid, ':uid' => $currentUserId]);
            $editRow = $ste->fetch();
            if ($editRow) {
                $editingPostId = (int)$editRow['post_id'];
            } else {
                $editingPostId = null;
            }
        } catch (PDOException $e) {
            error_log('[MANAGE][EDITLOAD] ' . $e->getMessage());
        }
    }
}

// LIST user's posts
try {
    $listQ = "SELECT post_id, title, is_public FROM posts WHERE user_uid = :uid ORDER BY created_at DESC";
    $stl = $db->prepare($listQ);
    $stl->execute([':uid' => $currentUserId]);
    $myPosts = $stl->fetchAll();
} catch (PDOException $e) {
    error_log('[MANAGE][LIST] ' . $e->getMessage());
    $myPosts = [];
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Manage Content</title>
    <style>body{font-family:Arial, sans-serif;max-width:900px;margin:24px;}</style>
</head>
<body>
    <div style="float:right;">
        Logged in as <b><?= escape_html($_SESSION['username'] ?? '') ?></b> |
        <a href="logout.php">Logout</a>
    </div>

    <p><a href="home.php">Public Site</a></p>
    <h2>Your Posts</h2>

    <?php if ($statusMessage !== ''): ?>
        <p style="color:red;"><?= escape_html($statusMessage) ?></p>
    <?php endif; ?>

    <?php if (empty($myPosts)): ?>
        <p>You haven't created any posts yet.</p>
    <?php else: ?>
        <?php foreach ($myPosts as $row): ?>
            <div style="border:1px solid #ccc;padding:10px;margin-bottom:10px;">
                <h3>
                    <?= escape_html($row['title']) ?>
                    <em style="font-size:80%; color: <?= $row['is_public'] ? 'green' : 'red' ?>;">
                        (<?= $row['is_public'] ? 'Public' : 'Private' ?>)
                    </em>
                </h3>
                <p>
                    <a href="manage.php?edit=<?= (int)$row['post_id'] ?>">Edit</a> |
                    <a href="manage.php?del=<?= (int)$row['post_id'] ?>" onclick="return confirm('Delete this post?');">Delete</a> |
                    <a href="view.php?id=<?= (int)$row['post_id'] ?>" target="_blank">View</a>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <hr>

    <h2><?= $editingPostId ? 'Edit Post' : 'Create New Post' ?></h2>
    <form method="post">
        <input type="hidden" name="pid" value="<?= $editingPostId ?? 0 ?>">

        <label>Title</label><br>
        <input type="text" name="title" style="width:100%;" required
               value="<?= $editRow ? escape_html($editRow['title']) : '' ?>"><br><br>

        <label>Content</label><br>
        <textarea name="content" rows="10" style="width:100%;" required><?= $editRow ? escape_html($editRow['content']) : '' ?></textarea><br>

        <input type="checkbox" name="public" id="public_check" <?= $editRow && $editRow['is_public'] ? 'checked' : '' ?>>
        <label for="public_check">Publish Post</label><br><br>

        <button type="submit"><?= $editingPostId ? 'Save Changes' : 'Create Post' ?></button>
        <?php if ($editingPostId): ?>
            <a href="manage.php" style="margin-left:10px;">Cancel Edit</a>
        <?php endif; ?>
    </form>
</body>
</html>