<?php
/**
 * HouseAidPro — Submit Issue API
 * Creates a new issue with optional file uploads.
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'POST required.'], 405);
}

$db = getDB();

// ── Determine user (logged in or guest) ─────────────────
$userId = null;
if (isLoggedIn()) {
    $userId = $_SESSION['user_id'];
} else {
    $firstName = trim($_POST['first_name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if ($firstName && $surname && $email) {
        $guest = createGuest($firstName, $surname, $email, $phone);
        $userId = $guest['user_id'] ?? null;
    }
}

// ── Lookup category ─────────────────────────────────────
$catSlug = trim($_POST['category'] ?? '');
$stmt = $db->prepare('SELECT id FROM issue_categories WHERE slug = ?');
$stmt->execute([$catSlug]);
$cat = $stmt->fetch();
$categoryId = $cat ? (int) $cat['id'] : 12; // "other"

// ── Create or find property ─────────────────────────────
$address1 = trim($_POST['address_line1'] ?? '');
$address2 = trim($_POST['address_line2'] ?? '');
$town = trim($_POST['town'] ?? '');
$county = trim($_POST['county'] ?? '');
$postcode = trim($_POST['postcode'] ?? '');

$propertyId = null;
if ($address1 && $town) {
    $stmt = $db->prepare(
        'INSERT INTO properties (user_id, address_line1, address_line2, town, county, postcode)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([$userId, $address1, $address2, $town, $county, $postcode]);
    $propertyId = (int) $db->lastInsertId();
}

// ── Create issue ────────────────────────────────────────
$refCode = generateReferenceCode();
$stmt = $db->prepare(
    'INSERT INTO issues (reference_code, user_id, property_id, category_id, area_type,
        title, description, priority, appliance_make, appliance_model, appliance_serial,
        flights_of_stairs, leak_container_size, leak_emptying_freq, leak_is_constant,
        notes, parking_restrictions, has_pets, has_alarm, vulnerable_occupier,
        access_without_presence, accepted_terms, preferred_date, preferred_time)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?)'
);
$stmt->execute([
    $refCode,
    $userId,
    $propertyId,
    $categoryId,
    $_POST['area_type'] ?? 'private',
    trim($_POST['title'] ?? 'Untitled Issue'),
    trim($_POST['description'] ?? ''),
    'medium',
    $_POST['appliance_make'] ?? null,
    $_POST['appliance_model'] ?? null,
    $_POST['appliance_serial'] ?? null,
    $_POST['flights_of_stairs'] ?? null,
    $_POST['leak_container_size'] ?? null,
    $_POST['leak_emptying_freq'] ?? null,
    isset($_POST['leak_is_constant']) ? (int) $_POST['leak_is_constant'] : null,
    $_POST['notes'] ?? null,
    (int) ($_POST['parking_restrictions'] ?? 0),
    (int) ($_POST['has_pets'] ?? 0),
    (int) ($_POST['has_alarm'] ?? 0),
    (int) ($_POST['vulnerable_occupier'] ?? 0),
    (int) ($_POST['access_without_presence'] ?? 0),
    $_POST['preferred_date'] ?: null,
    $_POST['preferred_time'] ?: null,
]);
$issueId = (int) $db->lastInsertId();

// ── Handle file uploads ─────────────────────────────────
$uploadDir = BASE_PATH . '/uploads/' . $issueId . '/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (!empty($_FILES['files'])) {
    foreach ($_FILES['files']['name'] as $i => $name) {
        if ($_FILES['files']['error'][$i] !== UPLOAD_ERR_OK)
            continue;
        if ($_FILES['files']['size'][$i] > MAX_UPLOAD_SIZE)
            continue;

        $mime = $_FILES['files']['type'][$i];
        if (!in_array($mime, ALLOWED_MIME_TYPES))
            continue;

        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $safeName = uniqid('media_') . '.' . $ext;
        $dest = $uploadDir . $safeName;

        if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $dest)) {
            $stmt = $db->prepare(
                'INSERT INTO issue_media (issue_id, file_name, original_name, file_path, file_type, file_size)
                 VALUES (?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([
                $issueId,
                $safeName,
                $name,
                'uploads/' . $issueId . '/' . $safeName,
                $mime,
                $_FILES['files']['size'][$i]
            ]);
        }
    }
}

// ── Send notification (stub) ────────────────────────────
if ($userId) {
    @sendNotification(
        $userId,
        'email',
        'Issue Submitted: ' . $refCode,
        'Your maintenance issue has been submitted. Reference: ' . $refCode,
        $issueId
    );
}

jsonResponse([
    'success' => true,
    'message' => 'Issue submitted successfully.',
    'reference_code' => $refCode,
    'issue_id' => $issueId
], 201);
