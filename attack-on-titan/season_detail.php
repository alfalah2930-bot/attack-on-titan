<?php
require_once __DIR__ . '/includes/functions.php';
$db = getDB();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$season = $db->prepare("SELECT * FROM seasons WHERE id = ?");
$season->execute([$id]);
$season = $season->fetch();
if (!$season) { header('Location: seasons.php'); exit; }

$prev = $db->prepare("SELECT id,title FROM seasons WHERE season_number < ? ORDER BY season_number DESC LIMIT 1");
$prev->execute([$season['season_number']]);
$prev = $prev->fetch();

$next = $db->prepare("SELECT id,title FROM seasons WHERE season_number > ? ORDER BY season_number ASC LIMIT 1");
$next->execute([$season['season_number']]);
$next = $next->fetch();

$pageTitle = $season['title'];
$activePage = 'seasons';
require_once __DIR__ . '/includes/header.php';
?>

<div style="margin-top:var(--nav-h)"></div>

<section class="section season-detail">
    <div class="container">

        <!-- Back -->
        <div class="breadcrumb">
            <a href="seasons.php">Season</a>
            <span>/</span>
            <span class="current"><?= e($season['title']) ?></span>
        </div>

        <!-- Header -->
        <div class="season-header">
            <div class="season-poster">
                <img src="<?= getImageUrl($season['image'], 'season-placeholder.jpg') ?>"
                     alt="<?= e($season['title']) ?>"
                     onerror="this.src='assets/images/season-placeholder.jpg'">
            </div>
            <div class="season-info">
                <p style="color:var(--maroon-3);font-family:var(--font-heading);letter-spacing:3px;font-size:0.78rem;margin-bottom:10px">SEASON <?= $season['season_number'] ?></p>
                <h1><?= e($season['title']) ?></h1>
                <div class="season-badges">
                    <span class="badge badge-red">★ <?= $season['rating'] ?>/10</span>
                    <span class="badge"><?= $season['release_year'] ?></span>
                    <span class="badge"><?= e($season['studio']) ?></span>
                    <span class="badge"><?= $season['episode_count'] ?> Episode</span>
                </div>
                <div class="info-block">
                    <h3>Deskripsi</h3>
                    <p><?= nl2br(e($season['description'])) ?></p>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="card-grid card-grid-2" style="gap:24px">
            <div class="info-block">
                <h3>Sinopsis</h3>
                <p><?= nl2br(e($season['synopsis'])) ?></p>
            </div>
            <div class="info-block">
                <h3>Karakter Utama</h3>
                <p><?= nl2br(e($season['characters_featured'])) ?></p>
            </div>
            <div class="info-block" style="grid-column:1/-1">
                <h3>Peristiwa Penting</h3>
                <p><?= nl2br(e($season['key_events'])) ?></p>
            </div>
        </div>

        <!-- Prev / Next -->
        <div style="display:flex;justify-content:space-between;margin-top:48px;gap:16px;flex-wrap:wrap">
            <?php if ($prev): ?>
            <a href="season_detail.php?id=<?= $prev['id'] ?>" class="btn btn-gold">
                <i class="fas fa-arrow-left"></i> <?= e($prev['title']) ?>
            </a>
            <?php else: ?><span></span><?php endif; ?>
            <?php if ($next): ?>
            <a href="season_detail.php?id=<?= $next['id'] ?>" class="btn btn-primary">
                <?= e($next['title']) ?> <i class="fas fa-arrow-right"></i>
            </a>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
