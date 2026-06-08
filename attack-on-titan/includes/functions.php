<?php
// ============================================================
// Authentication & Helper Functions
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Path absolut ke config — bekerja dari manapun file ini dipanggil
$_configPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
if (!file_exists($_configPath)) {
    die('<pre style="color:red">ERROR: Tidak dapat menemukan config/database.php dari: ' . __DIR__ . '</pre>');
}
require_once $_configPath;

// ── Auth Helpers ─────────────────────────────────────────────

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '/login.php');
        exit;
    }
}

function requireAdmin() {
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '/login.php');
        exit;
    }
    if (!isAdmin()) {
        header('Location: ' . SITE_URL . '/index.php');
        exit;
    }
}

function getCurrentUser() {
    if (!isLoggedIn()) return null;
    $db   = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

// ── Flash Messages ───────────────────────────────────────────

function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function showFlash() {
    $flash = getFlash();
    if ($flash) {
        $cls = $flash['type'] === 'success' ? 'flash-success' : 'flash-error';
        echo '<div class="flash-msg ' . $cls . '">' . htmlspecialchars($flash['message']) . '</div>';
    }
}

// ── Image Upload ─────────────────────────────────────────────

function uploadImage($file, $subdir = '') {
    if (empty($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) return null;

    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $finfo   = finfo_open(FILEINFO_MIME_TYPE);
    $mime    = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowed)) return false;
    if ($file['size'] > 5 * 1024 * 1024) return false; // max 5MB

    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = uniqid('img_', true) . '.' . $ext;
    $subdir   = $subdir ? trim($subdir, '/\\') . DIRECTORY_SEPARATOR : '';
    $dir      = UPLOAD_PATH . $subdir;

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
        return ($subdir ? str_replace(DIRECTORY_SEPARATOR, '/', trim($subdir, '/\\')) . '/' : '') . $filename;
    }
    return false;
}

function getImageUrl($path, $placeholder = 'placeholder.jpg') {
    if (empty($path)) return SITE_URL . '/assets/images/' . $placeholder;
    if (strpos($path, 'http') === 0) return $path;
    return SITE_URL . '/uploads/' . ltrim(str_replace('\\', '/', $path), '/');
}

// ── Sanitize ─────────────────────────────────────────────────

function e($str) {
    return htmlspecialchars((string)($str ?? ''), ENT_QUOTES, 'UTF-8');
}

function sanitize($str) {
    return trim(strip_tags((string)($str ?? '')));
}

// ── Redirect ─────────────────────────────────────────────────

function redirect($url) {
    header('Location: ' . $url);
    exit;
}
