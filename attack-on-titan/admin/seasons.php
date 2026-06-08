<?php
$pageTitle  = 'Kelola Season';
$activePage = 'seasons';
require_once __DIR__ . '/includes/header.php';
$db = getDB();

// ── Delete ───────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $stmt = $db->prepare("SELECT image FROM seasons WHERE id=?");
    $stmt->execute([(int)$_GET['delete']]);
    $row = $stmt->fetch();
    if ($row && $row['image']) {
        $imgFile = UPLOAD_PATH . str_replace('/', DIRECTORY_SEPARATOR, $row['image']);
        if (file_exists($imgFile)) unlink($imgFile);
    }
    $db->prepare("DELETE FROM seasons WHERE id=?")->execute([(int)$_GET['delete']]);
    setFlash('success', 'Season berhasil dihapus.');
    redirect(SITE_URL . '/admin/seasons.php');
}

// ── Save ─────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = (int)($_POST['id'] ?? 0);
    $title      = sanitize($_POST['title'] ?? '');
    $season_num = (int)($_POST['season_number'] ?? 0);
    $desc       = sanitize($_POST['description'] ?? '');
    $synopsis   = sanitize($_POST['synopsis'] ?? '');
    $chars      = sanitize($_POST['characters_featured'] ?? '');
    $events     = sanitize($_POST['key_events'] ?? '');
    $year       = (int)($_POST['release_year'] ?? 0);
    $rating     = (float)($_POST['rating'] ?? 0);
    $studio     = sanitize($_POST['studio'] ?? '');
    $eps        = (int)($_POST['episode_count'] ?? 0);

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = uploadImage($_FILES['image'], 'seasons');
        if ($image === false) {
            setFlash('error', 'Gagal upload gambar. Pastikan format JPG/PNG dan ukuran max 5MB.');
            redirect(SITE_URL . '/admin/seasons.php');
        }
    }

    if ($id) {
        // Edit
        $old = $db->prepare("SELECT image FROM seasons WHERE id=?");
        $old->execute([$id]);
        $old = $old->fetch();
        if ($image && $old && $old['image']) {
            $oldFile = UPLOAD_PATH . str_replace('/', DIRECTORY_SEPARATOR, $old['image']);
            if (file_exists($oldFile)) unlink($oldFile);
        }
        if ($image) {
            $db->prepare("UPDATE seasons SET title=?,season_number=?,description=?,synopsis=?,characters_featured=?,key_events=?,release_year=?,rating=?,studio=?,episode_count=?,image=? WHERE id=?")
               ->execute([$title,$season_num,$desc,$synopsis,$chars,$events,$year,$rating,$studio,$eps,$image,$id]);
        } else {
            $db->prepare("UPDATE seasons SET title=?,season_number=?,description=?,synopsis=?,characters_featured=?,key_events=?,release_year=?,rating=?,studio=?,episode_count=? WHERE id=?")
               ->execute([$title,$season_num,$desc,$synopsis,$chars,$events,$year,$rating,$studio,$eps,$id]);
        }
        setFlash('success', 'Season berhasil diperbarui.');
    } else {
        // Insert
        $db->prepare("INSERT INTO seasons (title,season_number,description,synopsis,characters_featured,key_events,release_year,rating,studio,episode_count,image) VALUES (?,?,?,?,?,?,?,?,?,?,?)")
           ->execute([$title,$season_num,$desc,$synopsis,$chars,$events,$year,$rating,$studio,$eps,$image]);
        setFlash('success', 'Season berhasil ditambahkan.');
    }
    redirect(SITE_URL . '/admin/seasons.php');
}

// ── Load edit data ────────────────────────────────────────────
$action   = $_GET['action'] ?? 'list';
$editData = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM seasons WHERE id=?");
    $stmt->execute([(int)$_GET['id']]);
    $editData = $stmt->fetch();
    if (!$editData) { setFlash('error','Season tidak ditemukan.'); redirect(SITE_URL.'/admin/seasons.php'); }
}
$seasons = $db->query("SELECT * FROM seasons ORDER BY season_number")->fetchAll();
?>

<?php if ($action === 'list'): ?>

<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title">Daftar Season</span>
        <a href="?action=add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Season</a>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>No</th><th>Poster</th><th>Judul</th><th>Studio</th><th>Tahun</th><th>Rating</th><th>Ep</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($seasons as $s): ?>
            <tr>
                <td><?= $s['season_number'] ?></td>
                <td>
                    <img src="<?= getImageUrl($s['image'],'season-placeholder.jpg') ?>"
                         style="width:64px;height:40px;object-fit:cover;border-radius:3px;border:1px solid var(--border)"
                         onerror="this.style.display='none'">
                </td>
                <td><?= e($s['title']) ?></td>
                <td><?= e($s['studio']) ?></td>
                <td><?= $s['release_year'] ?></td>
                <td style="color:var(--gold)">★ <?= $s['rating'] ?></td>
                <td><?= $s['episode_count'] ?></td>
                <td style="display:flex;gap:6px">
                    <a href="?action=edit&id=<?= $s['id'] ?>" class="btn btn-gold btn-sm"><i class="fas fa-edit"></i> Edit</a>
                    <a href="?delete=<?= $s['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus season <?= e($s['title']) ?>?')">
                       <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php else: ?>

<div class="breadcrumb">
    <a href="seasons.php">Season</a><span>/</span>
    <span class="current"><?= $editData ? 'Edit: '.e($editData['title']) : 'Tambah Season Baru' ?></span>
</div>

<div class="admin-form-card">
    <div class="admin-form-header">
        <i class="fas fa-film"></i>
        <?= $editData ? 'Edit Season: <span style="color:var(--gold)">'.e($editData['title']).'</span>' : 'Tambah Season Baru' ?>
    </div>
    <div class="admin-form-body">
        <form method="POST" enctype="multipart/form-data">
            <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php endif; ?>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Judul Season *</label>
                    <input type="text" name="title" class="form-control" required
                           value="<?= e($editData['title'] ?? '') ?>" placeholder="Contoh: Season 1">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Season *</label>
                    <input type="number" name="season_number" class="form-control" required min="1"
                           value="<?= e($editData['season_number'] ?? '') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Studio Animasi</label>
                    <input type="text" name="studio" class="form-control"
                           value="<?= e($editData['studio'] ?? '') ?>" placeholder="Contoh: Wit Studio">
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Rilis</label>
                    <input type="number" name="release_year" class="form-control" min="2000" max="2030"
                           value="<?= e($editData['release_year'] ?? '') ?>" placeholder="2013">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Rating (0.0 – 10.0)</label>
                    <input type="number" name="rating" step="0.1" min="0" max="10" class="form-control"
                           value="<?= e($editData['rating'] ?? '') ?>" placeholder="9.0">
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Episode</label>
                    <input type="number" name="episode_count" class="form-control" min="1"
                           value="<?= e($editData['episode_count'] ?? '') ?>" placeholder="25">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="Deskripsi singkat season ini..."><?= e($editData['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Sinopsis Lengkap</label>
                <textarea name="synopsis" class="form-control" rows="5"
                          placeholder="Ceritakan alur season ini secara detail..."><?= e($editData['synopsis'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Karakter Utama (pisahkan dengan koma)</label>
                <textarea name="characters_featured" class="form-control" rows="2"
                          placeholder="Eren Yeager, Mikasa Ackerman, Armin Arlert"><?= e($editData['characters_featured'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Peristiwa Penting</label>
                <textarea name="key_events" class="form-control" rows="3"
                          placeholder="Daftar momen penting di season ini..."><?= e($editData['key_events'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Poster Season</label>
                <input type="file" name="image" class="form-control form-control-file" accept="image/jpeg,image/png,image/webp">
                <small style="color:var(--text-muted);display:block;margin-top:6px">
                    Format: JPG, PNG, atau WebP. Ukuran max 5MB. Rekomendasi: 400×600px (rasio 2:3)
                </small>
                <?php if (!empty($editData['image'])): ?>
                <div class="current-img" style="margin-top:10px">
                    <img src="<?= getImageUrl($editData['image']) ?>"
                         alt="Poster saat ini"
                         onerror="this.src='<?= SITE_URL ?>/assets/images/season-placeholder.jpg'">
                    <span style="color:var(--text-muted);font-size:0.82rem">
                        Poster saat ini. Upload baru untuk mengganti.
                    </span>
                </div>
                <?php endif; ?>
            </div>

            <div style="display:flex;gap:12px;margin-top:8px">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?= $editData ? 'Simpan Perubahan' : 'Tambah Season' ?>
                </button>
                <a href="seasons.php" class="btn btn-gold">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
