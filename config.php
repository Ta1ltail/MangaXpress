<?php
// ─── Database Configuration ──────────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'shop_db');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

// ─── Security Helpers ─────────────────────────────────────────────────────────
function e($str)
{
    return htmlspecialchars((string) $str, ENT_QUOTES, 'UTF-8');
}

function sanitize($conn, $str)
{
    return mysqli_real_escape_string($conn, trim($str));
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return isset($_SESSION['admin_id']);
}

function requireLogin()
{
    if (!isLoggedIn())
        redirect('login.php');
}

function requireAdmin()
{
    if (!isAdmin())
        redirect('login.php');
}

function flashMessage($type, $text)
{
    $_SESSION['flash'] = ['type' => $type, 'text' => $text];
}

function getFlash()
{
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}
?>