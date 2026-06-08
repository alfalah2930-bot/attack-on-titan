<?php
$pageTitle = 'Karakter';
$activePage = 'characters';
require_once __DIR__ . '/includes/functions.php';
$characters = getDB()->query("SELECT * FROM characters ORDER BY id")->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-hero" style="background-image: url('assets/images/bg-characters.jpg')">
    <div>
        <h1 class="page-hero-title">Karakter</h1>
        <p class="page-hero-sub">Para Pahlawan dan Antagonis Dunia Titan</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <h2 class="section-title">Karakter Utama</h2>
        <div class="section-line"></div>

        <div class="card-grid card-grid-4">
            <?php foreach ($characters as $c): ?>
            <div class="char-card reveal" style="cursor:pointer" onclick="openModal(<?= htmlspecialchars(json_encode($c), ENT_QUOTES) ?>)">
                <img class="char-img"
                     src="<?= getImageUrl($c['image'], 'char-placeholder.jpg') ?>"
                     alt="<?= e($c['name']) ?>"
                     onerror="this.src='assets/images/char-placeholder.jpg'">
                <div class="char-body">
                    <div class="char-name"><?= e($c['name']) ?></div>
                    <div class="char-meta"><?= e(mb_substr($c['biodata'] ?? '', 0, 60)) ?>...</div>
                    <p class="char-desc"><?= e(mb_substr($c['description'], 0, 100)) ?>...</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div id="charModal" style="display:none;position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,0.85);overflow-y:auto;padding:60px 20px">
    <div style="max-width:720px;margin:0 auto;background:var(--dark-card);border:1px solid var(--border);border-radius:4px;overflow:hidden;position:relative">
        <button onclick="closeModal()" style="position:absolute;top:16px;right:16px;background:none;border:none;color:var(--text-muted);font-size:1.4rem;cursor:pointer;z-index:10">&times;</button>
        <div style="display:grid;grid-template-columns:240px 1fr">
            <img id="mImg" style="width:100%;aspect-ratio:3/4;object-fit:cover;object-position:top" src="" alt="">
            <div style="padding:32px">
                <p id="mMeta" style="color:var(--maroon-3);font-family:var(--font-heading);font-size:0.72rem;letter-spacing:2px;margin-bottom:8px"></p>
                <h2 id="mName" style="font-family:var(--font-display);color:var(--gold);margin-bottom:16px"></h2>
                <div class="info-block" style="margin-bottom:16px">
                    <h3>Biodata</h3>
                    <p id="mBio" style="font-size:0.88rem"></p>
                </div>
                <div class="info-block">
                    <h3>Deskripsi</h3>
                    <p id="mDesc" style="font-size:0.88rem"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(c) {
    document.getElementById('mImg').src  = c.image ? '<?= SITE_URL ?>/uploads/' + c.image : 'assets/images/char-placeholder.jpg';
    document.getElementById('mName').textContent = c.name;
    document.getElementById('mMeta').textContent = 'KARAKTER';
    document.getElementById('mBio').textContent  = c.biodata  || '-';
    document.getElementById('mDesc').textContent = c.description || '-';
    document.getElementById('charModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    document.getElementById('charModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('charModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<style>
.reveal { opacity:0; transform:translateY(30px); transition:opacity 0.6s ease, transform 0.6s ease; }
.revealed { opacity:1; transform:translateY(0); }
@media(max-width:600px){ #charModal > div > div { grid-template-columns:1fr!important } #mImg{aspect-ratio:16/9!important;object-position:center top} }
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
