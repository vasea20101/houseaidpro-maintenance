<?php
/**
 * HouseAidPro — Issues API
 * Actions: my, all, track, update_status
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

header('Content-Type: application/json; charset=utf-8');

$db = getDB();
$action = $_GET['action'] ?? '';

// Handle POST (JSON body)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $action = $body['action'] ?? $action;

    if ($action === 'update_status') {
        apiRequireRole(['admin']);
        $issueId = (int) ($body['issue_id'] ?? 0);
        $status = $body['status'] ?? '';
        $valid = ['new', 'acknowledged', 'scheduled', 'in_progress', 'completed', 'closed'];
        if (!$issueId || !in_array($status, $valid)) {
            jsonResponse(['success' => false, 'message' => 'Invalid parameters.'], 400);
        }
        $stmt = $db->prepare('UPDATE issues SET status = ? WHERE id = ?');
        $stmt->execute([$status, $issueId]);
        jsonResponse(['success' => true, 'message' => 'Status updated.']);
    }
}

// GET actions
switch ($action) {
    case 'my':
        if (!isLoggedIn()) {
            jsonResponse(['success' => false, 'message' => 'Login required.'], 401);
        }
        $stmt = $db->prepare(
            'SELECT i.*, ic.name AS category_name
             FROM issues i
             LEFT JOIN issue_categories ic ON i.category_id = ic.id
             WHERE i.user_id = ?
             ORDER BY i.submitted_at DESC'
        );
        $stmt->execute([$_SESSION['user_id']]);
        jsonResponse(['success' => true, 'issues' => $stmt->fetchAll()]);
        break;

    case 'all':
        apiRequireRole(['admin']);
        $stmt = $db->query(
            'SELECT i.*, ic.name AS category_name,
                    u.first_name, u.surname,
                    ca.contractor_id,
                    (SELECT CONCAT(cu.first_name, " ", cu.surname) FROM contractors c2
                     JOIN users cu ON c2.user_id = cu.id
                     WHERE c2.id = ca.contractor_id LIMIT 1) AS contractor_name
             FROM issues i
             LEFT JOIN issue_categories ic ON i.category_id = ic.id
             LEFT JOIN users u ON i.user_id = u.id
             LEFT JOIN contractor_assignments ca ON ca.issue_id = i.id
             ORDER BY i.submitted_at DESC'
        );
        jsonResponse(['success' => true, 'issues' => $stmt->fetchAll()]);
        break;

    case 'track':
        $ref = trim($_GET['ref'] ?? '');
        if (!$ref) {
            jsonResponse(['success' => false, 'message' => 'Reference code required.'], 400);
        }
        $stmt = $db->prepare(
            'SELECT i.*, ic.name AS category_name
             FROM issues i
             LEFT JOIN issue_categories ic ON i.category_id = ic.id
             WHERE i.reference_code = ?'
        );
        $stmt->execute([$ref]);
        $issue = $stmt->fetch();
        if ($issue) {
            jsonResponse(['success' => true, 'issue' => $issue]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Issue not found.'], 404);
        }
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Invalid action.'], 400);
}
