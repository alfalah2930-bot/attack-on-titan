<?php
// ============================================================
// Admin Header — path absolut agar tidak ada masalah relatif
// ============================================================

// Naik 2 level: admin/includes/ -> admin/ -> root/
$_fnPath = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'functions.php';
if (!file_exists($_fnPath)) {
    die('<pre style="color:red">ERROR: Tidak dapat menemukan includes/functions.php&#10;Dicari di: ' . $_fnPath . '&#10;&#10;Pastikan struktur folder benar:&#10;attack-on-titan/&#10;├── admin/&#10;│   └── includes/&#10;│       └── header.php  (file ini)&#10;└── includes/&#10;    └── functions.php</pre>');
}
require_once $_fnPath;
requireAdmin();
$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin') ?> | AOT Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body class="admin-body">

<!-- ── Sidebar ──────────────────────────────────────────────── -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        ⚔ AOT Admin
        <small>Dashboard Panel</small>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section">Menu Utama</div>
        <a href="<?= SITE_URL ?>/admin/index.php" class="sidebar-link <?= ($activePage??'')==='dashboard'?'active':'' ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <div class="sidebar-section">Kelola Konten</div>
        <a href="<?= SITE_URL ?>/admin/homepage.php" class="sidebar-link <?= ($activePage??'')==='homepage'?'active':'' ?>">
            <i class="fas fa-home"></i> Kelola Home
        </a>
        <a href="<?= SITE_URL ?>/admin/seasons.php" class="sidebar-link <?= ($activePage??'')==='seasons'?'active':'' ?>">
            <i class="fas fa-film"></i> Kelola Season
        </a>
        <a href="<?= SITE_URL ?>/admin/characters.php" class="sidebar-link <?= ($activePage??'')==='characters'?'active':'' ?>">
            <i class="fas fa-users"></i> Kelola Karakter
        </a>
        <a href="<?= SITE_URL ?>/admin/creator.php" class="sidebar-link <?= ($activePage??'')==='creator'?'active':'' ?>">
            <i class="fas fa-pen-nib"></i> Kelola Kreator
        </a>
        <div class="sidebar-section">Manajemen</div>
        <a href="<?= SITE_URL ?>/admin/users.php" class="sidebar-link <?= ($activePage??'')==='users'?'active':'' ?>">
            <i class="fas fa-user-cog"></i> Kelola User
        </a>
        <div class="sidebar-section">Aksi</div>
        <a href="<?= SITE_URL ?>/index.php" class="sidebar-link" target="_blank">
            <i class="fas fa-external-link-alt"></i> Lihat Website
        </a>
        <a href="<?= SITE_URL ?>/logout.php" class="sidebar-link danger">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>

<!-- ── Main ─────────────────────────────────────────────────── -->
<main class="admin-main">
    <header class="admin-header">
        <div style="display:flex;align-items:center;gap:14px">
            <button onclick="toggleSidebar()" style="background:none;border:none;color:var(--text-muted);font-size:1.1rem;cursor:pointer" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <span class="admin-header-title"><?= e($pageTitle ?? 'Dashboard') ?></span>
        </div>
        <div class="admin-header-user">
            <i class="fas fa-user-shield"></i>
            <span><?= e($currentUser['username'] ?? 'Admin') ?></span>
        </div>
    </header>
    <div class="admin-content">
    <?php showFlash(); ?>
