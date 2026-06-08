<?php
// ============================================================
// Database Configuration — Attack On Titan Website
// ============================================================

// ── Deteksi nama folder otomatis (case-sensitive safe) ───────
// Ini membaca nama folder asli dari server, sehingga tidak
// masalah apakah folder bernama "attack-on-titan" atau
// "Attack-on-titan" atau "AOT" sekalipun.
$_rootDir  = dirname(dirname(__FILE__)); // folder root project
$_docRoot  = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$_rootPath = str_replace('\\', '/', $_rootDir);
$_folder   = ltrim(str_replace($_docRoot, '', $_rootPath), '/');
$_protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$_host     = $_SERVER['HTTP_HOST'] ?? 'localhost';

define('DB_HOST',    'localhost');
define('DB_NAME',    'aot_website');
define('DB_USER',    'root');   // Ganti jika perlu
define('DB_PASS',    '');       // Ganti jika perlu
define('DB_CHARSET', 'utf8mb4');

define('SITE_URL',    $_protocol . '://' . $_host . '/' . $_folder);
define('UPLOAD_PATH', $_rootDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR);

// ── Koneksi PDO ───────────────────────────────────────────────
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('
            <div style="background:#1a0000;color:#ff6b6b;padding:40px;font-family:monospace;text-align:center;margin:0">
                <h2 style="color:#ff4444">⚠ Database Connection Error</h2>
                <p>' . htmlspecialchars($e->getMessage()) . '</p>
                <hr style="border-color:#500">
                <p>Pastikan MySQL sudah <strong>Start</strong> di XAMPP Control Panel</p>
                <p>Periksa <code>config/database.php</code> — DB_USER dan DB_PASS</p>
            </div>');
        }
    }
    return $pdo;
}
