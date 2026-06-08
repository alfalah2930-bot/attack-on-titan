<?php
require_once __DIR__ . '/includes/functions.php';
if (isLoggedIn()) redirect(SITE_URL . '/index.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Username dan password wajib diisi.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            setFlash('success', 'Selamat datang, ' . $user['username'] . '!');
            redirect($user['role'] === 'admin' ? SITE_URL . '/admin/index.php' : SITE_URL . '/index.php');
        } else {
            $error = 'Username atau password salah.';
        }
    }
}
$pageTitle = 'Login';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Attack On Titan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
<div class="auth-page">
    <div class="auth-box">
        <div class="auth-logo">
            <?php
            // Cari file logo dengan berbagai ekstensi
            $logoFile = '';
            foreach (['png','jpg','webp','jpeg'] as $ext) {
                if (file_exists(__DIR__ . '/assets/images/logo-aot.' . $ext)) {
                    $logoFile = SITE_URL . '/assets/images/logo-aot.' . $ext;
                    break;
                }
            }
            ?>
            <?php if ($logoFile): ?>
                <img src="<?= $logoFile ?>" alt="AOT Logo"
                     style="height:60px;width:auto;object-fit:contain;display:block;margin:0 auto 8px">
            <?php else: ?>
                <span>⚔ AOT</span>
            <?php endif; ?>
            <small>Attack On Titan Portal</small>
        </div>

        <?php if ($error): ?>
            <div class="flash-msg flash-error" style="margin-bottom:20px"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label class="form-label">Username / Email</label>
                <input type="text" name="username" class="form-control"
                       value="<?= e($_POST['username'] ?? '') ?>" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <p style="text-align:center;margin-top:24px;font-size:0.85rem;color:var(--text-muted)">
            Belum punya akun? <a href="<?= SITE_URL ?>/register.php">Daftar di sini</a>
        </p>
        <p style="text-align:center;margin-top:10px;font-size:0.85rem">
            <a href="<?= SITE_URL ?>/index.php" style="color:var(--text-muted)"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
        </p>
    </div>
</div>
</body>
</html>
