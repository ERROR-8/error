<?php
session_start();

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params_cookie = session_get_cookie_params();
    setcookie(session_name(), '', time() - 36000,
        $params_cookie['path'], $params_cookie['domain'],
        $params_cookie['secure'], $params_cookie['httponly']
    );
}

session_destroy();
header('Location: signin.php');
exit;
?>