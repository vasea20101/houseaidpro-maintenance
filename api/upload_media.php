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

// Only the issue's owner or an admin may attach media
apiRequireRole(['tenant', 'homeowner', 'admin']);
$stmt = $db->prepare('SELECT user_id FROM issues WHERE id = ?');
$stmt->execute([$issueId]);
$ownerId = $stmt->fetchColumn();
if ($ownerId === false) {
    jsonResponse(['success' => false, 'message' => 'Issue not found.'], 404);
}
if (!isAdmin() && (int) $ownerId !== (int) $_SESSION['user_id']) {
    jsonResponse(['success' => false, 'message' => 'Access denied.'], 403);
}

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
    $checked = validateUpload($file['tmp_name'], (int) $file['size']);
    if ($checked === null) {
        jsonResponse(['success' => false, 'message' => 'File type not allowed.'], 400);
    }

    $safeName = $checked['name'];
    $dest = $uploadDir . $safeName;

    if (move_uploaded_file($file['tmp_name'], $dest)) {
        $stmt = $db->prepare(
            'INSERT INTO issue_media (issue_id, file_name, original_name, file_path, file_type, file_size)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$issueId, $safeName, $file['name'], 'uploads/' . $issueId . '/' . $safeName, $checked['mime'], $file['size']]);
        $uploaded[] = ['id' => (int) $db->lastInsertId(), 'name' => $file['name']];
    }
}

jsonResponse(['success' => true, 'uploaded' => $uploaded]);
