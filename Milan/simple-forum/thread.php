<?php
require 'db.php';

$target_id = (int)($_GET['id'] ?? 0);
if ($target_id === 0) {
    header('Location: threads.php');
    exit;
}

$reply_status_msg = '';

$main_thread_data = null;
$stmt_thread = mysqli_prepare($link, "SELECT t.thread_id, t.title, t.body, t.created_at, u.username 
    FROM threads t JOIN users u ON t.user_id = u.user_id 
    WHERE t.thread_id = ? LIMIT 1");

mysqli_stmt_bind_param($stmt_thread, 'i', $target_id);
mysqli_stmt_execute($stmt_thread);
$thread_result = mysqli_stmt_get_result($stmt_thread);
$main_thread_data = mysqli_fetch_assoc($thread_result);
mysqli_stmt_close($stmt_thread);

if (!$main_thread_data) {
    header('Location: threads.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['auth_id'])) {
    $new_reply_body = trim($_POST['reply_body'] ?? '');
    
    if (empty($new_reply_body)) {
        $reply_status_msg = "Reply content cannot be empty.";
    } else {
        $stmt_reply = mysqli_prepare($link, "INSERT INTO replies (thread_id, user_id, body) VALUES (?, ?, ?)");
        
        mysqli_stmt_bind_param($stmt_reply, 'iis', $target_id, $_SESSION['auth_id'], $new_reply_body);
        
        if (mysqli_stmt_execute($stmt_reply)) {
            mysqli_stmt_close($stmt_reply);
            header("Location: thread.php?id=$target_id");
            exit;
        } else {
            $reply_status_msg = "Failed to add reply.";
        }
        mysqli_stmt_close($stmt_reply);
    }
}

$stmt_replies = mysqli_prepare($link, "SELECT r.reply_id, r.body, r.created_at, u.username 
    FROM replies r JOIN users u ON r.user_id = u.user_id 
    WHERE r.thread_id = ? ORDER BY r.created_at ASC");

mysqli_stmt_bind_param($stmt_replies, 'i', $target_id);
mysqli_stmt_execute($stmt_replies);
$replies_result = mysqli_stmt_get_result($stmt_replies);
$reply_list = mysqli_fetch_all($replies_result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt_replies);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($main_thread_data['title']) ?></title>
    <style>body{font-family:Arial;max-width:900px;margin:24px;}</style>
</head>
<body>
    <p><a href="threads.php">Back to Threads</a></p>
    <h2><?= htmlspecialchars($main_thread_data['title']) ?></h2>

    <p style="color:#666;">
        by **<?= htmlspecialchars($main_thread_data['username']) ?>** on **<?= $main_thread_data['created_at'] ?>**
    </p>
    <div style="border:1px solid #ddd;padding:12px;margin-bottom:12px;">
        <?= nl2br(htmlspecialchars($main_thread_data['body'])) ?>
    </div>
    
    <h3>Replies (<?= count($reply_list) ?>)</h3>
    
    <?php if (empty($reply_list)): ?>
        <p>No replies yet.</p>
    <?php else:
        foreach ($reply_list as $reply): ?>
            <div style="border:1px solid #eee;padding:8px;margin-bottom:8px;">
                <p>
                    <?= nl2br(htmlspecialchars($reply['body'])) ?>
                </p>
                <p style="color:#666;font-size:12px;">
                    by **<?= htmlspecialchars($reply['username']) ?>** at **<?= $reply['created_at'] ?>**
                </p>
            </div>
        <?php endforeach;
    endif; ?>

    <hr>
    
    <?php if (empty($_SESSION['auth_id'])): ?>
        <p><a href="login.php">Log in</a> to reply to this thread.</p>
    <?php else: ?>
        <h4>Post a Reply</h4>
        <?php if (!empty($reply_status_msg)): ?>
            <p style="color:red;"><?= htmlspecialchars($reply_status_msg); ?></p>
        <?php endif; ?>
        
        <form method="post" action="thread.php?id=<?= $target_id ?>">
            <textarea name="reply_body" rows="4" style="width:100%" required></textarea><br>
            <button type="submit">Post Reply</button>
        </form>
    <?php endif; ?>
</body>
</html>