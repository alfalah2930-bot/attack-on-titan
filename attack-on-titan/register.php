<?php
require_once __DIR__ . '/includes/functions.php';
if (isLoggedIn()) redirect(SITE_URL . '/index.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $email    = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Semua field wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } elseif ($password !== $confirm) {
        $error = 'Password dan konfirmasi tidak cocok.';
    } else {
        $db = getDB();
        $check = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->execute([$username, $email]);
        if ($check->fetch()) {
            $error = 'Username atau email sudah digunakan.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?,?,?,'user')");
            $stmt->execute([$username, $email, $hash]);
            setFlash('success', 'Registrasi berhasil! Silakan login.');
            redirect(SITE_URL . '/login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Attack On Titan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
<div class="auth-page">
    <div class="auth-box">
        <div class="auth-logo">
            ⚔ AOT
            <small>Buat Akun Baru</small>
        </div>

        <?php if ($error): ?>
            <div class="flash-msg flash-error" style="margin-bottom:20px"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                       value="<?= e($_POST['username'] ?? '') ?>" placeholder="Pilih username" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= e($_POST['email'] ?? '') ?>" placeholder="Masukkan email" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px">
                <i class="fas fa-user-plus"></i> Daftar
            </button>
        </form>

        <p style="text-align:center;margin-top:24px;font-size:0.85rem;color:var(--text-muted)">
            Sudah punya akun? <a href="<?= SITE_URL ?>/login.php">Login di sini</a>
        </p>
        <p style="text-align:center;margin-top:10px;font-size:0.85rem">
            <a href="<?= SITE_URL ?>/index.php" style="color:var(--text-muted)"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
        </p>
    </div>
</div>
</body>
</html>
