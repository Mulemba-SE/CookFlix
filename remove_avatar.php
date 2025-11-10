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

// 2. Fetch the current avatar URL to delete the file
$stmt = $conn->prepare("SELECT avatar_url FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($user && !empty($user['avatar_url'])) {
    // 3. Delete the old avatar file if it exists and is a file
    if (file_exists($user['avatar_url']) && is_file($user['avatar_url'])) {
        unlink($user['avatar_url']);
    }
}

// 4. Update the database to remove the avatar URL
$stmt = $conn->prepare("UPDATE Users SET avatar_url = NULL WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // 5. Update the session
    $_SESSION['avatar_url'] = null;
    echo json_encode(['success' => true]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'error' => 'Failed to update the database.']);
}

$stmt->close();
$conn->close();
?>