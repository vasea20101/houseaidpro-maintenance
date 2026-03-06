<?php
/**
 * HouseAidPro — Media Upload API
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'POST required.'], 405);
}

$issueId = (int) ($_POST['issue_id'] ?? 0);
if (!$issueId) {
    jsonResponse(['success' => false, 'message' => 'issue_id is required.'], 400);
}

$db = getDB();
$uploadDir = BASE_PATH . '/uploads/' . $issueId . '/';
if (!is_dir($uploadDir))
    mkdir($uploadDir, 0755, true);

$uploaded = [];

if (!empty($_FILES['file'])) {
    $file = $_FILES['file'];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        jsonResponse(['success' => false, 'message' => 'Upload error.'], 400);
    }
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        jsonResponse(['success' => false, 'message' => 'File too large. Max ' . (MAX_UPLOAD_SIZE / 1024 / 1024) . 'MB.'], 400);
    }
    if (!in_array($file['type'], ALLOWED_MIME_TYPES)) {
        jsonResponse(['success' => false, 'message' => 'File type not allowed.'], 400);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeName = uniqid('media_') . '.' . $ext;
    $dest = $uploadDir . $safeName;

    if (move_uploaded_file($file['tmp_name'], $dest)) {
        $stmt = $db->prepare(
            'INSERT INTO issue_media (issue_id, file_name, original_name, file_path, file_type, file_size)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$issueId, $safeName, $file['name'], 'uploads/' . $issueId . '/' . $safeName, $file['type'], $file['size']]);
        $uploaded[] = ['id' => (int) $db->lastInsertId(), 'name' => $file['name']];
    }
}

jsonResponse(['success' => true, 'uploaded' => $uploaded]);
