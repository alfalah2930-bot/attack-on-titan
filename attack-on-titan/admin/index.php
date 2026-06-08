<?php
$pageTitle  = 'Dashboard';
$activePage = 'dashboard';
require_once __DIR__ . '/includes/header.php';

$db              = getDB();
$totalSeasons    = $db->query("SELECT COUNT(*) FROM seasons")->fetchColumn();
$totalChars      = $db->query("SELECT COUNT(*) FROM characters")->fetchColumn();
$totalUsers      = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalAdmins     = $db->query("SELECT COUNT(*) FROM users WHERE role='admin'")->fetchColumn();
$recentUsers     = $db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5")->fetchAll();
$recentSeasons   = $db->query("SELECT * FROM seasons ORDER BY season_number DESC LIMIT 5")->fetchAll();
?>

<div class="admin-stats">
    <div class="admin-stat-card">
        <i class="fas fa-film stat-card-icon"></i>
        <div class="stat-card-num"><?= $totalSeasons ?></div>
        <div class="stat-card-label">Total Season</div>
    </div>
    <div class="admin-stat-card">
        <i class="fas fa-users stat-card-icon"></i>
        <div class="stat-card-num"><?= $totalChars ?></div>
        <div class="stat-card-label">Total Karakter</div>
    </div>
    <div class="admin-stat-card">
        <i class="fas fa-user stat-card-icon"></i>
        <div class="stat-card-num"><?= $totalUsers ?></div>
        <div class="stat-card-label">Total User</div>
    </div>
    <div class="admin-stat-card">
        <i class="fas fa-user-shield stat-card-icon"></i>
        <div class="stat-card-num"><?= $totalAdmins ?></div>
        <div class="stat-card-label">Total Admin</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">

    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-title"><i class="fas fa-film" style="margin-right:8px;color:var(--maroon-3)"></i>Season Terbaru</span>
            <a href="seasons.php" class="btn btn-sm btn-gold">Kelola</a>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>No</th><th>Judul</th><th>Studio</th><th>Rating</th></tr></thead>
                <tbody>
                <?php foreach ($recentSeasons as $s): ?>
                <tr>
                    <td><?= $s['season_number'] ?></td>
                    <td><?= e($s['title']) ?></td>
                    <td><?= e($s['studio']) ?></td>
                    <td style="color:var(--gold)">★ <?= $s['rating'] ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-title"><i class="fas fa-users" style="margin-right:8px;color:var(--maroon-3)"></i>User Terbaru</span>
            <a href="users.php" class="btn btn-sm btn-gold">Kelola</a>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Username</th><th>Email</th><th>Role</th></tr></thead>
                <tbody>
                <?php foreach ($recentUsers as $u): ?>
                <tr>
                    <td><?= e($u['username']) ?></td>
                    <td><?= e($u['email']) ?></td>
                    <td><span style="color:<?= $u['role']==='admin'?'var(--maroon-3)':'var(--text-muted)' ?>"><?= e($u['role']) ?></span></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="admin-card" style="margin-top:24px">
    <div class="admin-card-header">
        <span class="admin-card-title">Aksi Cepat</span>
    </div>
    <div class="admin-card-body" style="display:flex;gap:12px;flex-wrap:wrap">
        <a href="seasons.php?action=add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Season</a>
        <a href="characters.php?action=add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Karakter</a>
        <a href="homepage.php" class="btn btn-gold btn-sm"><i class="fas fa-edit"></i> Edit Homepage</a>
        <a href="creator.php" class="btn btn-gold btn-sm"><i class="fas fa-edit"></i> Edit Kreator</a>
        <a href="users.php" class="btn btn-gold btn-sm"><i class="fas fa-users"></i> Kelola User</a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
