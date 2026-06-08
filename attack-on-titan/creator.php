<?php
$pageTitle = 'Kreator — Hajime Isayama';
$activePage = 'creator';
require_once __DIR__ . '/includes/functions.php';
$creator = getDB()->query("SELECT * FROM creator LIMIT 1")->fetch();
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-hero" style="background-image: url('assets/images/bg-creator.jpg')">
    <div>
        <h1 class="page-hero-title">Kreator</h1>
        <p class="page-hero-sub">Hajime Isayama — Sang Pencipta Dunia Titan</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="creator-layout">

            <!-- Foto -->
            <div class="creator-photo">
                <img src="<?= getImageUrl($creator['image'] ?? '', 'creator-placeholder.jpg') ?>"
                     alt="Hajime Isayama"
                     onerror="this.src='assets/images/creator-placeholder.jpg'">
            </div>

            <!-- Info -->
            <div>
                <h1 class="creator-name"><?= e($creator['name'] ?? 'Hajime Isayama') ?></h1>
                <p style="color:var(--maroon-3);font-family:var(--font-heading);letter-spacing:2px;font-size:0.8rem;margin-bottom:24px">諫山 創 &bull; MANGA ARTIST</p>

                <div class="info-block reveal">
                    <h3>Biografi</h3>
                    <p><?= nl2br(e($creator['biography'] ?? '')) ?></p>
                </div>

                <div class="info-block reveal">
                    <h3>Perjalanan Karier</h3>
                    <p><?= nl2br(e($creator['career_journey'] ?? '')) ?></p>
                </div>

                <div class="info-block reveal">
                    <h3>Pengaruh Terhadap Industri Anime</h3>
                    <p><?= nl2br(e($creator['influence'] ?? '')) ?></p>
                </div>

                <div class="info-block reveal">
                    <h3>Data Singkat</h3>
                    <table class="data-table">
                        <tr><td style="color:var(--text-muted);width:160px">Nama Lengkap</td><td>Hajime Isayama (諫山 創)</td></tr>
                        <tr><td style="color:var(--text-muted)">Lahir</td><td>29 Agustus 1986</td></tr>
                        <tr><td style="color:var(--text-muted)">Asal</td><td>Oyama, Hita, Ōita, Jepang</td></tr>
                        <tr><td style="color:var(--text-muted)">Pendidikan</td><td>Kyushu Designer Gakuin, Fukuoka</td></tr>
                        <tr><td style="color:var(--text-muted)">Karya Utama</td><td>Attack on Titan (2009–2021)</td></tr>
                        <tr><td style="color:var(--text-muted)">Penerbit</td><td>Kodansha (Monthly Shōnen Magazine)</td></tr>
                        <tr><td style="color:var(--text-muted)">Total Volume</td><td>34 Volume</td></tr>
                        <tr><td style="color:var(--text-muted)">Penjualan</td><td>&gt;139 Juta Kopi</td></tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
.reveal { opacity:0; transform:translateY(30px); transition:opacity 0.6s ease, transform 0.6s ease; }
.revealed { opacity:1; transform:translateY(0); }
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
