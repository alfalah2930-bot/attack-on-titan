<?php
$pageTitle  = 'Kelola User';
$activePage = 'users';
require_once __DIR__ . '/includes/header.php';
$db = getDB();

// ── Delete ────────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    if ($delId === (int)$_SESSION['user_id']) {
        setFlash('error', 'Tidak bisa menghapus akun sendiri.');
    } else {
        $db->prepare("DELETE FROM users WHERE id=?")->execute([$delId]);
        setFlash('success', 'User berhasil dihapus.');
    }
    redirect(SITE_URL . '/admin/users.php');
}

// ── Toggle Role ───────────────────────────────────────────────
if (isset($_GET['toggle_role'])) {
    $tid = (int)$_GET['toggle_role'];
    if ($tid === (int)$_SESSION['user_id']) {
        setFlash('error', 'Tidak bisa mengubah role diri sendiri.');
    } else {
        $u = $db->prepare("SELECT role FROM users WHERE id=?");
        $u->execute([$tid]); $u = $u->fetch();
        $newRole = ($u && $u['role'] === 'admin') ? 'user' : 'admin';
        $db->prepare("UPDATE users SET role=? WHERE id=?")->execute([$newRole, $tid]);
        setFlash('success', 'Role diubah menjadi ' . $newRole . '.');
    }
    redirect(SITE_URL . '/admin/users.php');
}

// ── Add User ──────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = sanitize($_POST['username'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $role  = in_array($_POST['role'] ?? '', ['admin','user']) ? $_POST['role'] : 'user';

    if (empty($uname) || empty($email) || empty($pass)) {
        setFlash('error', 'Semua field wajib diisi.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash('error', 'Format email tidak valid.');
    } elseif (strlen($pass) < 6) {
        setFlash('error', 'Password minimal 6 karakter.');
    } else {
        $check = $db->prepare("SELECT id FROM users WHERE username=? OR email=?");
        $check->execute([$uname, $email]);
        if ($check->fetch()) {
            setFlash('error', 'Username atau email sudah digunakan.');
        } else {
            $db->prepare("INSERT INTO users (username,email,password,role) VALUES (?,?,?,?)")
               ->execute([$uname, $email, password_hash($pass, PASSWORD_DEFAULT), $role]);
            setFlash('success', 'User berhasil ditambahkan.');
        }
    }
    redirect(SITE_URL . '/admin/users.php');
}

$users = $db->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>

<div style="display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start">

    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-title">Daftar User (<?= count($users) ?>)</span>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Username</th><th>Email</th><th>Role</th><th>Tgl Daftar</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($users as $u): $self = ($u['id'] == $_SESSION['user_id']); ?>
                <tr>
                    <td>
                        <?= e($u['username']) ?>
                        <?php if ($self): ?><span style="color:var(--gold);font-size:0.72rem;margin-left:4px">(Anda)</span><?php endif; ?>
                    </td>
                    <td><?= e($u['email']) ?></td>
                    <td>
                        <?php if (!$self): ?>
                        <a href="?toggle_role=<?= $u['id'] ?>"
                           onclick="return confirm('Ubah role <?= e($u['username']) ?> menjadi <?= $u['role']==='admin'?'user':'admin' ?>?')"
                           style="text-decoration:none">
                        <?php endif; ?>
                            <span style="background:<?= $u['role']==='admin'?'var(--maroon)':'var(--dark-3)' ?>;color:<?= $u['role']==='admin'?'#fff':'var(--text-muted)' ?>;padding:3px 12px;border-radius:2px;font-family:var(--font-heading);font-size:0.7rem;letter-spacing:1px;cursor:<?= $self?'default':'pointer' ?>">
                                <?= e($u['role']) ?>
                            </span>
                        <?php if (!$self): ?></a><?php endif; ?>
                    </td>
                    <td style="color:var(--text-muted);font-size:0.82rem"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                    <td>
                        <?php if (!$self): ?>
                        <a href="?delete=<?= $u['id'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus user <?= e($u['username']) ?>? Tindakan ini tidak bisa dibatalkan.')">
                           <i class="fas fa-trash"></i>
                        </a>
                        <?php else: ?>
                        <span style="color:var(--text-muted);font-size:0.8rem">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-form-card">
        <div class="admin-form-header"><i class="fas fa-user-plus"></i> Tambah User Baru</div>
        <div class="admin-form-body">
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" class="form-control" placeholder="Username unik" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="user">User (hanya bisa lihat)</option>
                        <option value="admin">Admin (akses penuh)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                    <i class="fas fa-user-plus"></i> Tambah User
                </button>
            </form>
        </div>
    </div>

</div>

<style>
@media(max-width:900px){
    div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
