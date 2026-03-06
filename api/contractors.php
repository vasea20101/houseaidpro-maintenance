<?php
/**
 * HouseAidPro — Contractors API (stub)
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

header('Content-Type: application/json; charset=utf-8');
$db = getDB();
$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $action = $body['action'] ?? $action;

    if ($action === 'assign') {
        $issueId = (int) ($body['issue_id'] ?? 0);
        $contractorId = (int) ($body['contractor_id'] ?? 0);
        if (!$issueId || !$contractorId)
            jsonResponse(['success' => false, 'message' => 'Missing fields.'], 400);
        $stmt = $db->prepare('INSERT INTO contractor_assignments (issue_id, contractor_id) VALUES (?, ?)');
        $stmt->execute([$issueId, $contractorId]);
        $stmt = $db->prepare('UPDATE issues SET status = "scheduled" WHERE id = ?');
        $stmt->execute([$issueId]);
        jsonResponse(['success' => true, 'message' => 'Contractor assigned.']);
    }

    if ($action === 'accept') {
        $assignmentId = (int) ($body['assignment_id'] ?? 0);
        $stmt = $db->prepare('UPDATE contractor_assignments SET status = "accepted", accepted_at = NOW() WHERE id = ?');
        $stmt->execute([$assignmentId]);
        jsonResponse(['success' => true]);
    }

    if ($action === 'complete') {
        $assignmentId = (int) ($body['assignment_id'] ?? 0);
        $stmt = $db->prepare('UPDATE contractor_assignments SET status = "completed", completed_at = NOW() WHERE id = ?');
        $stmt->execute([$assignmentId]);
        jsonResponse(['success' => true]);
    }
}

// GET: list contractors
$stmt = $db->query('SELECT c.*, u.first_name, u.surname, u.email FROM contractors c JOIN users u ON c.user_id = u.id ORDER BY c.rating_avg DESC');
jsonResponse(['success' => true, 'contractors' => $stmt->fetchAll()]);
