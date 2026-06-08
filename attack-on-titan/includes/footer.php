<!-- ── Footer ─────────────────────────────────────────────── -->
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <span class="brand-wings">⚔</span>
            <span class="footer-title">Attack On Titan</span>
            <p class="footer-tagline">Shingeki no Kyojin</p>
        </div>
        <div class="footer-links">
            <a href="<?= SITE_URL ?>/index.php">Beranda</a>
            <a href="<?= SITE_URL ?>/history.php">Sejarah</a>
            <a href="<?= SITE_URL ?>/creator.php">Kreator</a>
            <a href="<?= SITE_URL ?>/seasons.php">Season</a>
            <a href="<?= SITE_URL ?>/characters.php">Karakter</a>
        </div>
        <p class="footer-copy">
            &copy; <?= date('Y') ?> AOT Portal &mdash; Dibuat untuk keperluan portofolio.<br>
            Attack on Titan &amp; semua karakter adalah milik <em>Hajime Isayama / Kodansha</em>.
        </p>
    </div>
</footer>

<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
<?= $extraJS ?? '' ?>
</body>
</html>
