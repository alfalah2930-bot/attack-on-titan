<?php
require_once __DIR__ . '/includes/functions.php';
session_destroy();
setcookie(session_name(), '', time() - 3600, '/');
header('Location: ' . SITE_URL . '/login.php');
exit;
