<?php
$pageTitle = 'Beranda';
$activePage = 'home';
require_once __DIR__ . '/includes/functions.php';
$db = getDB();
$homepage = $db->query("SELECT * FROM homepage LIMIT 1")->fetch();
$seasons  = $db->query("SELECT * FROM seasons ORDER BY season_number LIMIT 4")->fetchAll();
$characters = $db->query("SELECT * FROM characters LIMIT 4")->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>

<!-- ── Hero ──────────────────────────────────────────────────── -->
<section class="hero">
    <div class="hero-bg" style="background-image: url('<?= !empty($homepage['banner_image']) ? getImageUrl($homepage['banner_image']) : SITE_URL . '/assets/images/hero-bg.jpg' ?>'); background-size: cover; background-position: center;"></div>
    <div class="hero-content">
        <div class="hero-title-img-wrap">
            <img src="<?= SITE_URL ?>/assets/images/title-aot.png"
                 alt="Attack On Titan"
                 class="hero-title-img"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
            <h1 class="hero-title" style="display:none"><?= e($homepage['title'] ?? 'Attack On Titan') ?></h1>
        </div>
        <p class="hero-subtitle"><?= e($homepage['subtitle'] ?? 'The Story of Humanity\'s Last Stand') ?></p>
        <p class="hero-desc"><?= e($homepage['description'] ?? '') ?></p>
        <div class="hero-actions">
            <a href="seasons.php" class="btn btn-primary"><i class="fas fa-play"></i> Jelajahi Season</a>
            <a href="characters.php" class="btn btn-gold">Lihat Karakter</a>
        </div>
    </div>
    <div class="hero-scroll">
        <span>Scroll</span>
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- ── Stats ─────────────────────────────────────────────────── -->
<div class="stats-bar">
    <div class="container">
        <div class="stats-grid">
            <div>
                <div class="stat-num count-up" data-target="139">0</div>
                <div class="stat-label">Juta Volume Terjual</div>
            </div>
            <div>
                <div class="stat-num count-up" data-target="8">0</div>
                <div class="stat-label">Season / Part</div>
            </div>
            <div>
                <div class="stat-num count-up" data-target="87">0</div>
                <div class="stat-label">Total Episode</div>
            </div>
            <div>
                <div class="stat-num count-up" data-target="11">0</div>
                <div class="stat-label">Tahun Serialisasi</div>
            </div>
        </div>
    </div>
</div>

<!-- ── Season Preview ─────────────────────────────────────────── -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Season</h2>
        <div class="section-line"></div>
        <div class="card-grid card-grid-3">
            <?php foreach ($seasons as $s): ?>
            <a href="season_detail.php?id=<?= $s['id'] ?>" class="card reveal" style="text-decoration:none">
                <img class="card-img"
                     src="<?= getImageUrl($s['image'], 'season-placeholder.jpg') ?>"
                     alt="<?= e($s['title']) ?>"
                     onerror="this.src='assets/images/season-placeholder.jpg'">
                <div class="card-body">
                    <div class="card-label">Season <?= $s['season_number'] ?> &bull; <?= $s['release_year'] ?></div>
                    <div class="card-title"><?= e($s['title']) ?></div>
                    <div class="card-rating star-rating" data-rating="<?= $s['rating'] ?>"></div>
                    <p class="card-text"><?= e(mb_substr($s['description'], 0, 100)) ?>...</p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-2">
            <a href="seasons.php" class="btn btn-gold">Lihat Semua Season</a>
        </div>
    </div>
</section>

<!-- ── Characters Preview ─────────────────────────────────────── -->
<section class="section" style="background:var(--dark-card);border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
    <div class="container">
        <h2 class="section-title">Karakter Utama</h2>
        <div class="section-line"></div>
        <div class="card-grid card-grid-4">
            <?php foreach ($characters as $c): ?>
            <div class="char-card reveal">
                <img class="char-img"
                     src="<?= getImageUrl($c['image'], 'char-placeholder.jpg') ?>"
                     alt="<?= e($c['name']) ?>"
                     onerror="this.src='assets/images/char-placeholder.jpg'">
                <div class="char-body">
                    <div class="char-name"><?= e($c['name']) ?></div>
                    <p class="char-desc"><?= e(mb_substr($c['description'], 0, 90)) ?>...</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-2">
            <a href="characters.php" class="btn btn-primary">Semua Karakter</a>
        </div>
    </div>
</section>

<!-- ── About Section ─────────────────────────────────────────── -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Tentang Attack on Titan</h2>
        <div class="section-line"></div>
        <div class="facts-grid">
            <div class="fact-card reveal">
                <div class="fact-icon">📖</div>
                <div class="fact-title">Manga Legendaris</div>
                <p class="fact-text">Diterbitkan sejak 2009 di Monthly Shōnen Magazine oleh Kodansha, manga karya Hajime Isayama ini berjalan selama 11 tahun dengan 34 volume.</p>
            </div>
            <div class="fact-card reveal">
                <div class="fact-icon">🎬</div>
                <div class="fact-title">Adaptasi Anime</div>
                <p class="fact-text">Diadaptasi oleh Wit Studio (Season 1–3) dan MAPPA (Season 4), anime ini ditayangkan sejak 2013 dan memenangkan banyak penghargaan internasional.</p>
            </div>
            <div class="fact-card reveal">
                <div class="fact-icon">🌍</div>
                <div class="fact-title">Fenomena Global</div>
                <p class="fact-text">Dengan lebih dari 139 juta kopi terjual, Attack on Titan adalah salah satu manga terlaris sepanjang masa dan populer di seluruh dunia.</p>
            </div>
            <div class="fact-card reveal">
                <div class="fact-icon">⚔️</div>
                <div class="fact-title">Tema Mendalam</div>
                <p class="fact-text">Mengeksplorasi tema perang, imperialisme, kebebasan, dan siklus kebencian yang membuat AOT menjadi karya sastra visual yang serius.</p>
            </div>
        </div>
    </div>
</section>

<style>
.reveal { opacity:0; transform:translateY(30px); transition:opacity 0.6s ease, transform 0.6s ease; }
.revealed { opacity:1; transform:translateY(0); }
.hero-title-img-wrap { margin-bottom: 16px; }
.hero-title-img {
    max-width: 580px;
    width: 90%;
    height: auto;
    filter: drop-shadow(0 4px 24px rgba(139,0,0,0.6));
    margin: 0 auto;
    display: block;
}
@media (max-width: 600px) {
    .hero-title-img { max-width: 300px; }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
