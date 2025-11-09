<?php
require 'db.php';

$t_id = (int)($_GET['id'] ?? 0);
if ($t_id === 0) {
    header('Location: threads.php');
    exit;
}

$reply_msg = '';
$current_member_id = $_SESSION['SESS_USER_ID'] ?? 0;

// --- FETCH THREAD DATA ---
$sql_thread = "SELECT t.thread_id, t.subject, t.content, t.post_date, m.username 
    FROM forum_posts t JOIN members m ON t.member_id = m.member_id 
    WHERE t.thread_id = ? LIMIT 1";

$stmt_thread = mysqli_prepare($conn, $sql_thread);

mysqli_stmt_bind_param($stmt_thread, 'i', $t_id);
mysqli_stmt_execute($stmt_thread);
$res_thread = mysqli_stmt_get_result($stmt_thread);
$current_post_data = mysqli_fetch_assoc($res_thread);
mysqli_stmt_close($stmt_thread);

if (!$current_post_data) {
    header('Location: threads.php');
    exit;
}

// --- REPLY POSTING LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $current_member_id > 0) {
    $reply_text = trim($_POST['r_body'] ?? '');
    
    if (empty($reply_text)) {
        $reply_msg = "Reply cannot be empty.";
    } else {
        $sql_reply = "INSERT INTO thread_comments (thread_id, member_id, reply_text) VALUES (?, ?, ?)";
        $stmt_reply = mysqli_prepare($conn, $sql_reply);
        
        mysqli_stmt_bind_param($stmt_reply, 'iis', $t_id, $current_member_id, $reply_text);
        
        if (mysqli_stmt_execute($stmt_reply)) {
            mysqli_stmt_close($stmt_reply);
            header("Location: thread.php?id=$t_id");
            exit;
        } else {
            $reply_msg = "Failed to post reply.";
        }
        mysqli_stmt_close($stmt_reply);
    }
}

// --- FETCH COMMENTS ---
$sql_comments = "SELECT c.reply_text, c.reply_date, m.username 
    FROM thread_comments c JOIN members m ON c.member_id = m.member_id 
    WHERE c.thread_id = ? ORDER BY c.reply_date ASC";

$stmt_comments = mysqli_prepare($conn, $sql_comments);

mysqli_stmt_bind_param($stmt_comments, 'i', $t_id);
mysqli_stmt_execute($stmt_comments);
$res_comments = mysqli_stmt_get_result($stmt_comments);
$comments_array = mysqli_fetch_all($res_comments, MYSQLI_ASSOC);
mysqli_stmt_close($stmt_comments);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($current_post_data['subject']) ?></title>
    <style>body{font-family:Arial;max-width:900px;margin:24px;}</style>
</head>
<body>
    <p><a href="threads.php">Back to Threads</a></p>
    <h2><?= htmlspecialchars($current_post_data['subject']) ?></h2>

    <p style="color:#666;">
        by **<?= htmlspecialchars($current_post_data['username']) ?>** on **<?= $current_post_data['post_date'] ?>**
    </p>
    <div style="border:1px solid #ddd;padding:12px;margin-bottom:12px;">
        <?= nl2br(htmlspecialchars($current_post_data['content'])) ?>
    </div>
    
    <h3>Replies (<?= count($comments_array) ?>)</h3>
    
    <?php if (empty($comments_array)): ?>
        <p>Be the first to reply.</p>
    <?php else:
        foreach ($comments_array as $comment): ?>
            <div style="border:1px solid #eee;padding:8px;margin-bottom:8px;">
                <p>
                    <?= nl2br(htmlspecialchars($comment['reply_text'])) ?>
                </p>
                <p style="color:#666;font-size:12px;">
                    by **<?= htmlspecialchars($comment['username']) ?>** at **<?= $comment['reply_date'] ?>**
                </p>
            </div>
        <?php endforeach;
    endif; ?>

    <hr>
    
    <?php if ($current_member_id === 0): ?>
        <p><a href="login.php">Log in</a> to reply.</p>
    <?php else: ?>
        <h4>Post a Reply</h4>
        <?php if (!empty($reply_msg)): ?>
            <p style="color:red;"><?= htmlspecialchars($reply_msg); ?></p>
        <?php endif; ?>
        
        <form method="post" action="thread.php?id=<?= $t_id ?>">
            <textarea name="r_body" rows="4" style="width:100%" required></textarea><br>
            <button type="submit">Submit Reply</button>
        </form>
    <?php endif; ?>
</body>
</html>