<?php
require 'db.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$current_user_id = $_SESSION['user_id'];
$status_msg = ''; 
$post_id_to_edit = null;

// --- DELETE LOGIC ---
if (isset($_GET['del'])) {
    $delete_id = (int)$_GET['del'];
    if ($delete_id > 0) {
        $delete_q = "DELETE FROM posts WHERE post_id = :id AND user_uid = :uid";
        $stmt_del = $dbConnect->prepare($delete_q);
        $stmt_del->execute([':id' => $delete_id, ':uid' => $current_user_id]);
    }
    header('Location: manage.php'); 
    exit;
}

// --- CREATE/UPDATE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id_param = (int)$_POST['pid'] ?? 0;
    $post_title = trim($_POST['title'] ?? '');
    $post_content = trim($_POST['content'] ?? '');
    $is_public_flag = (int)(isset($_POST['public']) ? 1 : 0);

    if (empty($post_title) || empty($post_content)) {
        $status_msg = "Title and content cannot be empty.";
    } else {
        // Generate a new slug
        $new_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $post_title)));

        // Check for duplicate slug, excluding the current post if editing
        $slug_check_q = "SELECT post_id FROM posts WHERE slug = :slug_param AND post_id != :id_param LIMIT 1";
        $stmt_slug = $dbConnect->prepare($slug_check_q);
        $stmt_slug->execute([':slug_param' => $new_slug, ':id_param' => $post_id_param]);
        
        if ($stmt_slug->fetch()) {
            $status_msg = "A post with this title already exists. Try changing the title.";
        } else {
            $post_data_array = [
                ':title' => $post_title,
                ':slug' => $new_slug,
                ':content' => $post_content,
                ':user_id' => $current_user_id,
                ':is_pub' => $is_public_flag
            ];

            if ($post_id_param > 0) {
                // Update existing post
                $update_q = "UPDATE posts SET 
                    title = :title, slug = :slug, content = :content, is_public = :is_pub, updated_at = NOW() 
                    WHERE post_id = :pid AND user_uid = :user_id";
                
                $stmt_update = $dbConnect->prepare($update_q);
                $post_data_array[':pid'] = $post_id_param;
                $stmt_update->execute($post_data_array);
            } else {
                // Insert new post
                $insert_q = "INSERT INTO posts 
                    (title, slug, content, user_uid, is_public, created_at, updated_at) 
                    VALUES (:title, :slug, :content, :user_id, :is_pub, NOW(), NOW())";
                
                $stmt_insert = $dbConnect->prepare($insert_q);
                $stmt_insert->execute($post_data_array);
            }
            header('Location: manage.php');
            exit;
        }
    }
}

// --- EDIT PREP (LOAD DATA) ---
$post_data_to_edit = null;
if (isset($_GET['edit'])) {
    $post_id_to_edit = (int)$_GET['edit'];
    if ($post_id_to_edit > 0) {
        $edit_q = "SELECT * FROM posts WHERE post_id = :id AND user_uid = :uid";
        $stmt_edit = $dbConnect->prepare($edit_q);
        $stmt_edit->execute([':id' => $post_id_to_edit, ':uid' => $current_user_id]);
        $post_data_to_edit = $stmt_edit->fetch();
        if (!$post_data_to_edit) {
            $post_id_to_edit = null; // Prevent form from appearing if not found
        }
    }
}

// --- LOAD USER'S POSTS FOR LIST ---
$list_q = "SELECT post_id, title, is_public FROM posts WHERE user_uid = :uid ORDER BY created_at DESC";
$stmt_list = $dbConnect->prepare($list_q);
$stmt_list->execute([':uid' => $current_user_id]);
$user_posts_list = $stmt_list->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Manage Content</title>
    <style>body{font-family:Arial;max-width:900px;margin:24px;}</style>
</head>
<body>
    <div style="float:right;">
        Logged in as <b><?= sanitize_output($_SESSION['username']) ?></b> | 
        <a href="logout.php">Logout</a>
    </div>
    <p><a href="home.php">Public Site</a></p>
    <h2>Your Posts</h2>

    <?php if (!empty($status_msg)): ?>
        <p style="color:red;"><?= sanitize_output($status_msg) ?></p>
    <?php endif; ?>

    <?php if (!$user_posts_list): ?>
        <p>You haven't created any posts yet.</p>
    <?php else: ?>
        <?php foreach ($user_posts_list as $p): ?>
            <div style="border:1px solid #ccc;padding:10px;margin-bottom:10px;">
                <h3>
                    <?= sanitize_output($p['title']) ?> 
                    <em style="font-size: 80%; color: <?= $p['is_public'] ? 'green' : 'red' ?>;">
                        (<?= $p['is_public'] ? 'Public' : 'Private' ?>)
                    </em>
                </h3>
                <p>
                    <a href="manage.php?edit=<?= $p['post_id'] ?>">Edit</a>
                    |
                    <a href="manage.php?del=<?= $p['post_id'] ?>" onclick="return confirm('Delete this post?');">Delete</a>
                    |
                    <a href="view.php?id=<?= $p['post_id'] ?>" target="_blank">View</a>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <hr>

    <h2><?= $post_id_to_edit ? 'Edit Post' : 'Create New Post' ?></h2>
    <form method="post">
        <input type="hidden" name="pid" value="<?= $post_id_to_edit ?>">
        
        <label>Title</label><br>
        <input 
            type="text" 
            name="title" 
            style="width:100%;" 
            required 
            value="<?= $post_data_to_edit ? sanitize_output($post_data_to_edit['title']) : '' ?>"
        ><br><br>

        <label>Content</label><br>
        <textarea 
            name="content" 
            rows="10" 
            style="width:100%;" 
            required
        ><?= $post_data_to_edit ? sanitize_output($post_data_to_edit['content']) : '' ?></textarea><br>
        
        <input 
            type="checkbox" 
            name="public" 
            id="public_check" 
            <?= $post_data_to_edit && $post_data_to_edit['is_public'] ? 'checked' : '' ?>
        >
        <label for="public_check">Publish Post</label><br><br>

        <button type="submit"><?= $post_id_to_edit ? 'Save Changes' : 'Create Post' ?></button>
        
        <?php if ($post_id_to_edit): ?>
            <a href="manage.php" style="margin-left:10px;">Cancel Edit</a>
        <?php endif; ?>
    </form>
</body>
</html>