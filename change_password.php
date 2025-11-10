<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// 1. Check for login status
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'error' => 'You must be logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. Get POST data
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// 3. Validate input
if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Please fill in all password fields.']);
    exit;
}

if ($new_password !== $confirm_password) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'New passwords do not match.']);
    exit;
}

// 4. Verify current password
$stmt = $conn->prepare("SELECT password_hash FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($current_password, $user['password_hash'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Incorrect current password.']);
    $stmt->close();
    exit;
}

// 5. Hash and update new password
$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE Users SET password_hash = ? WHERE user_id = ?");
$stmt->bind_param("si", $new_password_hash, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Password updated successfully!']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to update password. Please try again.']);
}

$stmt->close();
$conn->close();
?>