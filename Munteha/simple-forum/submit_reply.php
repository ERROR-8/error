<?php
// submit_reply.php
require 'config.php';
if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$thread_id = (int)($_POST['thread_id'] ?? 0);
$content = trim($_POST['content'] ?? '');
if ($thread_id <= 0 || $content === '') { header('Location: home.php'); exit; }

$ins = $db->prepare("INSERT INTO replies (thread_id, user_id, content) VALUES (:tid, :uid, :c)");
$ins->execute([':tid'=>$thread_id, ':uid'=>$_SESSION['user_id'], ':c'=>$content]);
header('Location: thread.php?id=' . $thread_id);
exit;
