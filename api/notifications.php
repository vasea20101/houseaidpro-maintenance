<?php
/**
 * HouseAidPro — Notifications API (stub)
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

header('Content-Type: application/json; charset=utf-8');
$db = getDB();

if (!isLoggedIn())
    jsonResponse(['success' => false, 'message' => 'Login required.'], 401);

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $stmt = $db->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY sent_at DESC LIMIT 50');
    $stmt->execute([$_SESSION['user_id']]);
    jsonResponse(['success' => true, 'notifications' => $stmt->fetchAll()]);
}

if ($action === 'read' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    $id = (int) ($body['id'] ?? 0);
    $stmt = $db->prepare('UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?');
    $stmt->execute([$id, $_SESSION['user_id']]);
    jsonResponse(['success' => true]);
}

jsonResponse(['success' => false, 'message' => 'Invalid action.'], 400);
