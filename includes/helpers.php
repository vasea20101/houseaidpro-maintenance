<?php
/**
 * HouseAidPro — Shared helper functions
 */

/**
 * Generate a unique issue reference code like HAP-20260305-A3X9
 */
function generateReferenceCode(): string
{
    $date = date('Ymd');
    $rand = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
    return "HAP-{$date}-{$rand}";
}

/**
 * Sanitise and trim input
 */
function clean(string $value): string
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

/**
 * Return JSON response and exit
 */
function jsonResponse(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

/**
 * Redirect helper
 */
function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

/**
 * Format date for display
 */
function formatDate(string $datetime): string
{
    return date('d M Y, H:i', strtotime($datetime));
}

/**
 * Get status badge HTML
 */
function statusBadge(string $status): string
{
    $labels = [
        'new' => 'New',
        'acknowledged' => 'Acknowledged',
        'scheduled' => 'Scheduled',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'closed' => 'Closed',
    ];
    $label = $labels[$status] ?? ucfirst($status);
    return "<span class=\"badge badge--{$status}\">{$label}</span>";
}

/**
 * Log a notification (stub — replace with real email/SMS later)
 */
function sendNotification(int $userId, string $type, string $subject, string $message, ?int $issueId = null): void
{
    $db = getDB();
    $stmt = $db->prepare(
        'INSERT INTO notifications (user_id, issue_id, type, subject, message) VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->execute([$userId, $issueId, $type, $subject, $message]);

    // Stub: log to file instead of actually emailing/texting
    $logLine = sprintf(
        "[%s] %s to user %d: %s — %s\n",
        date('Y-m-d H:i:s'),
        strtoupper($type),
        $userId,
        $subject,
        $message
    );
    file_put_contents(BASE_PATH . '/logs/notifications.log', $logLine, FILE_APPEND | LOCK_EX);
}
