<?php
/**
 * HouseAidPro — Auth API Endpoint
 * Handles: login, register, logout, guest creation
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'login':
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if (!$email || !$password) {
            jsonResponse(['success' => false, 'message' => 'Email and password are required.'], 400);
        }
        $result = loginUser($email, $password);
        jsonResponse($result, $result['success'] ? 200 : 401);
        break;

    case 'register':
        $firstName = trim($_POST['first_name'] ?? '');
        $surname = trim($_POST['surname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $phone = trim($_POST['phone'] ?? '');
        $title = trim($_POST['title'] ?? '');

        if (!$firstName || !$surname || !$email || !$password) {
            jsonResponse(['success' => false, 'message' => 'All required fields must be filled.'], 400);
        }
        if (strlen($password) < 8) {
            jsonResponse(['success' => false, 'message' => 'Password must be at least 8 characters.'], 400);
        }

        $result = registerUser($firstName, $surname, $email, $password, 'tenant', $title, $phone);
        jsonResponse($result, $result['success'] ? 201 : 409);
        break;

    case 'guest':
        $firstName = trim($_POST['first_name'] ?? '');
        $surname = trim($_POST['surname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if (!$firstName || !$surname || !$email) {
            jsonResponse(['success' => false, 'message' => 'Name and email are required.'], 400);
        }

        $result = createGuest($firstName, $surname, $email, $phone);
        jsonResponse($result);
        break;

    case 'logout':
        logoutUser();
        jsonResponse(['success' => true, 'message' => 'Logged out.']);
        break;

    case 'me':
        $user = getCurrentUser();
        if ($user) {
            unset($user['password_hash']);
            jsonResponse(['success' => true, 'user' => $user]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Not logged in.'], 401);
        }
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Invalid action.'], 400);
}
