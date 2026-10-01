<?php
/**
 * HouseAidPro — Application Configuration
 * Copy this file to includes/config.php and set your own database credentials.
 * config.php is git-ignored so real credentials are never committed.
 */

// ── Database ────────────────────────────────────────────────
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'houseaidpro');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');
define('DB_CHARSET', 'utf8mb4');

// ── Paths ───────────────────────────────────────────────────
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_DIR', BASE_PATH . '/uploads/');
define('PAGES_DIR', BASE_PATH . '/pages/');

// ── Upload constraints ──────────────────────────────────────
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10 MB
define('MAX_FILES', 10);
// Map of allowed MIME type => extension used when saving the file.
// The MIME type is detected server-side (finfo), never taken from the client.
define('ALLOWED_MIME_TYPES', [
    'image/jpeg'      => 'jpg',
    'image/png'       => 'png',
    'image/gif'       => 'gif',
    'image/webp'      => 'webp',
    'video/mp4'       => 'mp4',
    'video/quicktime' => 'mov',
    'video/webm'      => 'webm',
    'audio/mpeg'      => 'mp3',
    'audio/wav'       => 'wav',
    'audio/x-wav'     => 'wav',
    'audio/ogg'       => 'ogg'
]);

// ── App ─────────────────────────────────────────────────────
define('APP_NAME', 'HouseAidPro');

// Auto-detect app URL to avoid hardcoded localhost/subfolder mismatches.
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', (string) realpath($_SERVER['DOCUMENT_ROOT'])) : '';
$basePathReal = str_replace('\\', '/', (string) realpath(BASE_PATH));
$baseUri = '';

if ($documentRoot !== '' && $basePathReal !== '' && stripos($basePathReal, $documentRoot) === 0) {
    $baseUri = str_replace('\\', '/', substr($basePathReal, strlen($documentRoot)));
}

$baseUri = rtrim($baseUri, '/');
define('APP_URL', $scheme . '://' . $host . $baseUri);
define('APP_VERSION', '1.0.0');

// ── Session ─────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Error reporting ─────────────────────────────────────────
// Set APP_DEBUG to false in production so errors are logged, not shown to users.
define('APP_DEBUG', true);
error_reporting(E_ALL);
ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', BASE_PATH . '/logs/php-errors.log');

// ── Timezone ────────────────────────────────────────────────
date_default_timezone_set('Europe/London');
