<?php
$pageTitle  = 'Kelola Homepage';
$activePage = 'homepage';
require_once __DIR__ . '/includes/header.php';
$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = sanitize($_POST['title'] ?? '');
    $subtitle = sanitize($_POST['subtitle'] ?? '');
    $desc     = sanitize($_POST['description'] ?? '');

    $image = null;
    if (!empty($_FILES['banner_image']['name'])) {
        $image = uploadImage($_FILES['banner_image'], 'homepage');
        if ($image === false) {
            setFlash('error', 'Gagal upload banner. Format JPG/PNG, max 5MB.');
            redirect(SITE_URL . '/admin/homepage.php');
        }
    }

    $existing = $db->query("SELECT * FROM homepage LIMIT 1")->fetch();
    if ($existing) {
        if ($image && $existing['banner_image']) {
            $f = UPLOAD_PATH . str_replace('/', DIRECTORY_SEPARATOR, $existing['banner_image']);
            if (file_exists($f)) unlink($f);
        }
        if ($image) {
            $db->prepare("UPDATE homepage SET title=?,subtitle=?,description=?,banner_image=? WHERE id=?")
               ->execute([$title,$subtitle,$desc,$image,$existing['id']]);
        } else {
            $db->prepare("UPDATE homepage SET title=?,subtitle=?,description=? WHERE id=?")
               ->execute([$title,$subtitle,$desc,$existing['id']]);
        }
    } else {
        $db->prepare("INSERT INTO homepage (title,subtitle,description,banner_image) VALUES (?,?,?,?)")
           ->execute([$title,$subtitle,$desc,$image]);
    }
    setFlash('success', 'Homepage berhasil diperbarui.');
    redirect(SITE_URL . '/admin/homepage.php');
}

$hp = $db->query("SELECT * FROM homepage LIMIT 1")->fetch();
?>

<div class="admin-form-card">
    <div class="admin-form-header">
        <i class="fas fa-home"></i> Edit Konten Homepage
    </div>
    <div class="admin-form-body">
        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="form-label">Judul Utama (Hero Title) *</label>
                <input type="text" name="title" class="form-control" required
                       value="<?= e($hp['title'] ?? 'Attack On Titan') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Subjudul</label>
                <input type="text" name="subtitle" class="form-control"
                       value="<?= e($hp['subtitle'] ?? '') ?>"
                       placeholder="Shingeki no Kyojin — The Story of Humanity's Last Stand">
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Homepage</label>
                <textarea name="description" class="form-control" rows="5"
                          placeholder="Deskripsi singkat yang muncul di hero section..."><?= e($hp['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Banner / Hero Image</label>
                <input type="file" name="banner_image" class="form-control form-control-file" accept="image/jpeg,image/png,image/webp">
                <small style="color:var(--text-muted);display:block;margin-top:6px">
                    Format: JPG, PNG, atau WebP. Max 5MB. Rekomendasi: 1920×1080px
                </small>
                <?php if (!empty($hp['banner_image'])): ?>
                <div class="current-img" style="margin-top:10px">
                    <img src="<?= getImageUrl($hp['banner_image']) ?>"
                         alt="Banner saat ini"
                         style="width:120px;height:60px;object-fit:cover"
                         onerror="this.style.display='none'">
                    <span style="color:var(--text-muted);font-size:0.82rem">
                        Banner saat ini. Upload baru untuk mengganti.
                    </span>
                </div>
                <?php endif; ?>
            </div>

            <div style="display:flex;gap:12px;margin-top:8px">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="<?= SITE_URL ?>/index.php" target="_blank" class="btn btn-gold">
                    <i class="fas fa-external-link-alt"></i> Preview Website
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
