<?php
$pageTitle  = 'Kelola Karakter';
$activePage = 'characters';
require_once __DIR__ . '/includes/header.php';
$db = getDB();

// ── Delete ────────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $stmt = $db->prepare("SELECT image FROM characters WHERE id=?");
    $stmt->execute([(int)$_GET['delete']]);
    $row = $stmt->fetch();
    if ($row && $row['image']) {
        $f = UPLOAD_PATH . str_replace('/', DIRECTORY_SEPARATOR, $row['image']);
        if (file_exists($f)) unlink($f);
    }
    $db->prepare("DELETE FROM characters WHERE id=?")->execute([(int)$_GET['delete']]);
    setFlash('success', 'Karakter berhasil dihapus.');
    redirect(SITE_URL . '/admin/characters.php');
}

// ── Save ──────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = (int)($_POST['id'] ?? 0);
    $name = sanitize($_POST['name'] ?? '');
    $desc = sanitize($_POST['description'] ?? '');
    $bio  = sanitize($_POST['biodata'] ?? '');

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = uploadImage($_FILES['image'], 'characters');
        if ($image === false) {
            setFlash('error', 'Gagal upload foto. Format JPG/PNG, max 5MB.');
            redirect(SITE_URL . '/admin/characters.php');
        }
    }

    if ($id) {
        $old = $db->prepare("SELECT image FROM characters WHERE id=?");
        $old->execute([$id]); $old = $old->fetch();
        if ($image && $old && $old['image']) {
            $f = UPLOAD_PATH . str_replace('/', DIRECTORY_SEPARATOR, $old['image']);
            if (file_exists($f)) unlink($f);
        }
        if ($image) {
            $db->prepare("UPDATE characters SET name=?,description=?,biodata=?,image=? WHERE id=?")
               ->execute([$name,$desc,$bio,$image,$id]);
        } else {
            $db->prepare("UPDATE characters SET name=?,description=?,biodata=? WHERE id=?")
               ->execute([$name,$desc,$bio,$id]);
        }
        setFlash('success', 'Karakter berhasil diperbarui.');
    } else {
        $db->prepare("INSERT INTO characters (name,description,biodata,image) VALUES (?,?,?,?)")
           ->execute([$name,$desc,$bio,$image]);
        setFlash('success', 'Karakter berhasil ditambahkan.');
    }
    redirect(SITE_URL . '/admin/characters.php');
}

$action   = $_GET['action'] ?? 'list';
$editData = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM characters WHERE id=?");
    $stmt->execute([(int)$_GET['id']]);
    $editData = $stmt->fetch();
    if (!$editData) { setFlash('error','Karakter tidak ditemukan.'); redirect(SITE_URL.'/admin/characters.php'); }
}
$characters = $db->query("SELECT * FROM characters ORDER BY id")->fetchAll();
?>

<?php if ($action === 'list'): ?>

<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title">Daftar Karakter</span>
        <a href="?action=add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Karakter</a>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>Foto</th><th>Nama</th><th>Biodata</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($characters as $c): ?>
            <tr>
                <td>
                    <img src="<?= getImageUrl($c['image'],'char-placeholder.jpg') ?>"
                         style="width:48px;height:48px;object-fit:cover;object-position:top;border-radius:50%;border:2px solid var(--border)"
                         onerror="this.style.opacity=0.3">
                </td>
                <td style="font-family:var(--font-heading);color:var(--gold)"><?= e($c['name']) ?></td>
                <td style="font-size:0.82rem;color:var(--text-muted)"><?= e(mb_substr($c['biodata']??'',0,70)) ?>...</td>
                <td style="display:flex;gap:6px">
                    <a href="?action=edit&id=<?= $c['id'] ?>" class="btn btn-gold btn-sm"><i class="fas fa-edit"></i> Edit</a>
                    <a href="?delete=<?= $c['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus karakter <?= e($c['name']) ?>?')">
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
    <a href="characters.php">Karakter</a><span>/</span>
    <span class="current"><?= $editData ? 'Edit: '.e($editData['name']) : 'Tambah Karakter' ?></span>
</div>

<div class="admin-form-card">
    <div class="admin-form-header">
        <i class="fas fa-user"></i>
        <?= $editData ? 'Edit Karakter: <span style="color:var(--gold)">'.e($editData['name']).'</span>' : 'Tambah Karakter Baru' ?>
    </div>
    <div class="admin-form-body">
        <form method="POST" enctype="multipart/form-data">
            <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label">Nama Karakter *</label>
                <input type="text" name="name" class="form-control" required
                       value="<?= e($editData['name'] ?? '') ?>" placeholder="Contoh: Eren Yeager">
            </div>

            <div class="form-group">
                <label class="form-label">Biodata Singkat</label>
                <input type="text" name="biodata" class="form-control"
                       value="<?= e($editData['biodata'] ?? '') ?>"
                       placeholder="Age: 19 | Affiliation: Survey Corps | Status: Deceased">
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Karakter</label>
                <textarea name="description" class="form-control" rows="6"
                          placeholder="Deskripsi lengkap tentang karakter ini..."><?= e($editData['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Foto Karakter</label>
                <input type="file" name="image" class="form-control form-control-file" accept="image/jpeg,image/png,image/webp">
                <small style="color:var(--text-muted);display:block;margin-top:6px">
                    Format: JPG, PNG, atau WebP. Max 5MB. Rekomendasi: 400×530px (rasio 3:4)
                </small>
                <?php if (!empty($editData['image'])): ?>
                <div class="current-img" style="margin-top:10px">
                    <img src="<?= getImageUrl($editData['image']) ?>"
                         alt="Foto saat ini"
                         onerror="this.style.display='none'">
                    <span style="color:var(--text-muted);font-size:0.82rem">
                        Foto saat ini. Upload baru untuk mengganti.
                    </span>
                </div>
                <?php endif; ?>
            </div>

            <div style="display:flex;gap:12px;margin-top:8px">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?= $editData ? 'Simpan Perubahan' : 'Tambah Karakter' ?>
                </button>
                <a href="characters.php" class="btn btn-gold">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
