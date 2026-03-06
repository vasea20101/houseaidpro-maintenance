<?php
/**
 * HouseAidPro — Authentication Helpers
 */

require_once __DIR__ . '/db.php';

/* ── Registration ─────────────────────────────────────────── */
function registerUser(
    string $firstName,
    string $surname,
    string $email,
    string $password,
    string $role = 'tenant',
    string $title = '',
    string $phone = '',
    string $altPhone = ''
): array {
    $db = getDB();

    // Check duplicate
    $stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Email already registered.'];
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $db->prepare(
        'INSERT INTO users (role, title, first_name, surname, email, phone, alt_phone, password_hash)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([$role, $title, $firstName, $surname, $email, $phone, $altPhone, $hash]);

    $userId = (int) $db->lastInsertId();
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_role'] = $role;

    return ['success' => true, 'user_id' => $userId];
}

/* ── Login ────────────────────────────────────────────────── */
function loginUser(string $email, string $password): array
{
    $db = getDB();
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return ['success' => false, 'message' => 'Invalid email or password.'];
    }

    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['surname'];

    return ['success' => true, 'user' => $user];
}

/* ── Guest creation ───────────────────────────────────────── */
function createGuest(
    string $firstName,
    string $surname,
    string $email,
    string $phone = ''
): array {
    $db = getDB();

    // Reuse existing guest row if same email
    $stmt = $db->prepare('SELECT id FROM users WHERE email = ? AND is_guest = 1');
    $stmt->execute([$email]);
    $existing = $stmt->fetch();

    if ($existing) {
        return ['success' => true, 'user_id' => (int) $existing['id']];
    }

    $stmt = $db->prepare(
        'INSERT INTO users (first_name, surname, email, phone, is_guest) VALUES (?, ?, ?, ?, 1)'
    );
    $stmt->execute([$firstName, $surname, $email, $phone]);

    return ['success' => true, 'user_id' => (int) $db->lastInsertId()];
}

/* ── Logout ───────────────────────────────────────────────── */
function logoutUser(): void
{
    session_unset();
    session_destroy();
}

/* ── Session helpers ──────────────────────────────────────── */
function getCurrentUser(): ?array
{
    if (empty($_SESSION['user_id']))
        return null;

    $db = getDB();
    $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch() ?: null;
}

function isLoggedIn(): bool
{
    return !empty($_SESSION['user_id']);
}

function isAdmin(): bool
{
    return ($_SESSION['user_role'] ?? '') === 'admin';
}

function isContractor(): bool
{
    return ($_SESSION['user_role'] ?? '') === 'contractor';
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: ' . APP_URL . '/pages/login.php');
        exit;
    }
}

function requireAdmin(): void
{
    requireLogin();
    if (!isAdmin()) {
        http_response_code(403);
        exit('Access denied.');
    }
}
