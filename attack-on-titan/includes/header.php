<?php
require_once __DIR__ . '/../includes/functions.php';
// Jika database sudah dimuat, ambil data homepage
$homepage = [];
try {
    $homepage = getDB()->query("SELECT * FROM homepage LIMIT 1")->fetch() ?: [];
} catch(Exception $e) { $homepage = []; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Attack On Titan') ?> | Shingeki no Kyojin</title>
    <meta name="description" content="Portal informasi lengkap Attack on Titan – season, karakter, sejarah, dan kreator.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Cinzel:wght@400;600;700&family=Lato:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <?= $extraCSS ?? '' ?>
</head>
<body>

<!-- ── Navigation ─────────────────────────────────────────── -->
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <?php
        $navLogo = '';
        foreach (['png','jpg','webp','jpeg'] as $ext) {
            if (file_exists(__DIR__ . '/../assets/images/logo-aot.' . $ext)) {
                $navLogo = SITE_URL . '/assets/images/logo-aot.' . $ext;
                break;
            }
        }
        ?>
        <a class="nav-brand" href="<?= SITE_URL ?>">
            <?php if ($navLogo): ?>
                <img src="<?= $navLogo ?>" alt="AOT Logo"
                     style="height:44px;width:auto;object-fit:contain">
            <?php else: ?>
                <span class="brand-wings">⚔</span>
                <span>AOT</span>
            <?php endif; ?>
        </a>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </button>

        <ul class="nav-links" id="navLinks">
            <li><a href="<?= SITE_URL ?>/index.php" class="nav-link <?= ($activePage ?? '') === 'home' ? 'active' : '' ?>">Beranda</a></li>
            <li><a href="<?= SITE_URL ?>/history.php" class="nav-link <?= ($activePage ?? '') === 'history' ? 'active' : '' ?>">Sejarah</a></li>
            <li><a href="<?= SITE_URL ?>/creator.php" class="nav-link <?= ($activePage ?? '') === 'creator' ? 'active' : '' ?>">Kreator</a></li>
            <li><a href="<?= SITE_URL ?>/seasons.php" class="nav-link <?= ($activePage ?? '') === 'seasons' ? 'active' : '' ?>">Season</a></li>
            <li><a href="<?= SITE_URL ?>/characters.php" class="nav-link <?= ($activePage ?? '') === 'characters' ? 'active' : '' ?>">Karakter</a></li>
            <?php if (isLoggedIn()): ?>
                <?php if (isAdmin()): ?>
                    <li><a href="<?= SITE_URL ?>/admin/index.php" class="nav-link nav-admin"><i class="fas fa-cog"></i> Admin</a></li>
                <?php endif; ?>
                <li><a href="<?= SITE_URL ?>/logout.php" class="nav-link nav-logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php else: ?>
                <li><a href="<?= SITE_URL ?>/login.php" class="nav-link nav-login">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="flash-container">
<?php showFlash(); ?>
</div>
