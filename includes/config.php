<?php
/**
 * HouseAidPro — Application Configuration
 * Update these values to match your Laragon MySQL credentials.
 */

// ── Database ────────────────────────────────────────────────
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'houseaidpro');
define('DB_USER', 'root');
define('DB_PASS', '');          // Laragon default: empty password
define('DB_CHARSET', 'utf8mb4');

// ── Paths ───────────────────────────────────────────────────
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_DIR', BASE_PATH . '/uploads/');
define('PAGES_DIR', BASE_PATH . '/pages/');

// ── Upload constraints ──────────────────────────────────────
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10 MB
define('MAX_FILES', 10);
define('ALLOWED_MIME_TYPES', [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
    'video/mp4',
    'video/quicktime',
    'video/webm',
    'audio/mpeg',
    'audio/wav',
    'audio/ogg'
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

// ── Error reporting (disable in production) ─────────────────
error_reporting(E_ALL);
ini_set('display_errors', '1');

// ── Timezone ────────────────────────────────────────────────
date_default_timezone_set('Europe/London');
