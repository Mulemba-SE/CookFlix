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

// 2. Delete the user from the database
// Note: Depending on your database schema (foreign key constraints), 
// you might need to delete related data first (e.g., recipes, comments)
// For simplicity, we assume ON DELETE CASCADE is set up in the database.
$stmt = $conn->prepare("DELETE FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to delete account from the database.']);
}

$stmt->close();
$conn->close();
?>