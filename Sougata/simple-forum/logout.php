<?php
require 'db.php';

// Ensure a session is active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Remove all session variables
$_SESSION = [];

// If session cookies are used, expire the cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'] ?? '/',
        $params['domain'] ?? '',
        $params['secure'] ?? false,
        $params['httponly'] ?? true
    );
}

// Destroy the session data on the server
session_unset();
session_destroy();

// Redirect to threads list
header('Location: threads.php');
exit;
?>