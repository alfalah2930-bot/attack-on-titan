<?php
$pageTitle = 'Season';
$activePage = 'seasons';
require_once __DIR__ . '/includes/functions.php';
$seasons = getDB()->query("SELECT * FROM seasons ORDER BY season_number")->fetchAll();
require_once __DIR__ . '/includes/header.php';

// Cari file bg-season dengan berbagai ekstensi
$bgSeason = '';
foreach (['jpg','jpeg','png','webp'] as $ext) {
    if (file_exists(__DIR__ . '/assets/images/bg-season.' . $ext)) {
        $bgSeason = SITE_URL . '/assets/images/bg-season.' . $ext;
        break;
    }
}
?>

<div class="page-hero" <?= $bgSeason ? "style=\"background-image: url('$bgSeason')\"" : '' ?>>
    <div>
        <h1 class="page-hero-title">Season</h1>
        <p class="page-hero-sub">Perjalanan Epik 8 Season Attack On Titan</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <h2 class="section-title">Semua Season</h2>
        <div class="section-line"></div>

        <div class="card-grid card-grid-3">
            <?php foreach ($seasons as $s): ?>
            <a href="season_detail.php?id=<?= $s['id'] ?>" class="card reveal" style="text-decoration:none">
                <div style="position:relative">
                    <img class="card-img"
                         src="<?= getImageUrl($s['image'], 'season-placeholder.jpg') ?>"
                         alt="<?= e($s['title']) ?>"
                         onerror="this.src='assets/images/season-placeholder.jpg'">
                    <div style="position:absolute;top:12px;left:12px;background:var(--maroon);color:#fff;padding:4px 10px;font-family:var(--font-heading);font-size:0.7rem;letter-spacing:1px;border-radius:2px">
                        Season <?= $s['season_number'] ?>
                    </div>
                    <div style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.75);color:var(--gold);padding:4px 10px;font-family:var(--font-heading);font-size:0.78rem;border-radius:2px">
                        ★ <?= $s['rating'] ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-label"><?= $s['release_year'] ?> &bull; <?= e($s['studio']) ?> &bull; <?= $s['episode_count'] ?> Ep</div>
                    <div class="card-title"><?= e($s['title']) ?></div>
                    <p class="card-text"><?= e(mb_substr($s['description'], 0, 110)) ?>...</p>
                </div>
                <div class="card-footer">
                    <span class="btn btn-primary btn-sm">Selengkapnya</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.reveal { opacity:0; transform:translateY(30px); transition:opacity 0.6s ease, transform 0.6s ease; }
.revealed { opacity:1; transform:translateY(0); }
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
