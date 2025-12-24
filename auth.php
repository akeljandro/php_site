<?php
// Start session
session_start();

// Simple authentication configuration
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'password123'); // Change this in production!

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Login function
function login($username, $password) {
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = time();
        return true;
    }
    return false;
}

// Logout function
function logout() {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

// Protect page - redirect to login if not authenticated
function requireAuth() {
    if (!isLoggedIn()) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
        exit();
    }
}

// Check if session has expired (optional timeout)
function isSessionExpired() {
    if (!isset($_SESSION['login_time'])) {
        return true;
    }
    $timeout = 3600; // 1 hour
    return (time() - $_SESSION['login_time']) > $timeout;
}
?>
