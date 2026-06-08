<?php
$pageTitle  = 'Kelola Kreator';
$activePage = 'creator';
require_once __DIR__ . '/includes/header.php';
$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = sanitize($_POST['name'] ?? '');
    $bio    = sanitize($_POST['biography'] ?? '');
    $career = sanitize($_POST['career_journey'] ?? '');
    $influ  = sanitize($_POST['influence'] ?? '');

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = uploadImage($_FILES['image'], 'creator');
        if ($image === false) {
            setFlash('error', 'Gagal upload foto. Format JPG/PNG, max 5MB.');
            redirect(SITE_URL . '/admin/creator.php');
        }
    }

    $existing = $db->query("SELECT * FROM creator LIMIT 1")->fetch();
    if ($existing) {
        if ($image && $existing['image']) {
            $f = UPLOAD_PATH . str_replace('/', DIRECTORY_SEPARATOR, $existing['image']);
            if (file_exists($f)) unlink($f);
        }
        if ($image) {
            $db->prepare("UPDATE creator SET name=?,biography=?,career_journey=?,influence=?,image=? WHERE id=?")
               ->execute([$name,$bio,$career,$influ,$image,$existing['id']]);
        } else {
            $db->prepare("UPDATE creator SET name=?,biography=?,career_journey=?,influence=? WHERE id=?")
               ->execute([$name,$bio,$career,$influ,$existing['id']]);
        }
    } else {
        $db->prepare("INSERT INTO creator (name,biography,career_journey,influence,image) VALUES (?,?,?,?,?)")
           ->execute([$name,$bio,$career,$influ,$image]);
    }
    setFlash('success', 'Data kreator berhasil disimpan.');
    redirect(SITE_URL . '/admin/creator.php');
}

$creator = $db->query("SELECT * FROM creator LIMIT 1")->fetch();
?>

<div class="admin-form-card">
    <div class="admin-form-header">
        <i class="fas fa-pen-nib"></i> Edit Informasi Kreator
    </div>
    <div class="admin-form-body">
        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="form-label">Nama Kreator *</label>
                <input type="text" name="name" class="form-control" required
                       value="<?= e($creator['name'] ?? 'Hajime Isayama') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Biografi</label>
                <textarea name="biography" class="form-control" rows="7"
                          placeholder="Tulis biografi lengkap kreator..."><?= e($creator['biography'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Perjalanan Karier</label>
                <textarea name="career_journey" class="form-control" rows="5"
                          placeholder="Ceritakan perjalanan karier kreator..."><?= e($creator['career_journey'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Pengaruh Terhadap Industri Anime</label>
                <textarea name="influence" class="form-control" rows="5"
                          placeholder="Jelaskan dampak dan pengaruhnya..."><?= e($creator['influence'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Foto Kreator</label>
                <input type="file" name="image" class="form-control form-control-file" accept="image/jpeg,image/png,image/webp">
                <small style="color:var(--text-muted);display:block;margin-top:6px">
                    Format: JPG, PNG, atau WebP. Max 5MB. Rekomendasi: 400×530px
                </small>
                <?php if (!empty($creator['image'])): ?>
                <div class="current-img" style="margin-top:10px">
                    <img src="<?= getImageUrl($creator['image']) ?>"
                         alt="Foto kreator saat ini"
                         onerror="this.style.display='none'">
                    <span style="color:var(--text-muted);font-size:0.82rem">
                        Foto saat ini. Upload baru untuk mengganti.
                    </span>
                </div>
                <?php endif; ?>
            </div>

            <div style="display:flex;gap:12px;margin-top:8px">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
