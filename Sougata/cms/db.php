<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuration (kept out of global scope as constants)
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'blog_assignment_db');
define('DB_USER', 'blog_user');
define('DB_PASS', 'strong_password');
define('DB_CHARSET', 'utf8mb4');

/**
 * Get a PDO connection (singleton)
 *
 * @return PDO
 */
function connect_db(): PDO
{
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Log the internal error for administrators; show a generic message to users
        error_log('[DB] Connection failed: ' . $e->getMessage());
        http_response_code(500);
        exit('Service temporarily unavailable. Please try again later.');
    }
}

// Create the connection for use by the application
$pdo_conn = connect_db();

/**
 * Escape output for safe HTML rendering
 *
 * @param mixed $value
 * @return string
 */
function escape_html($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
?>