<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// 1. Check for login status
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'You must be logged in to upload an avatar.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. Check if a file was uploaded
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'No file uploaded or an error occurred.']);
    exit;
}

$file = $_FILES['avatar'];

// 3. Validate the file
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_size = 5 * 1024 * 1024; // 5 MB

if (!in_array($file['type'], $allowed_types)) {
    http_response_code(415); // Unsupported Media Type
    echo json_encode(['error' => 'Invalid file type. Please upload a JPG, PNG, or GIF.']);
    exit;
}

if ($file['size'] > $max_size) {
    http_response_code(413); // Payload Too Large
    echo json_encode(['error' => 'File is too large. Maximum size is 5 MB.']);
    exit;
}

// 4. Create a unique filename and path
$upload_dir = 'uploads/avatars/';
$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$new_filename = 'user_' . $user_id . '_' . time() . '.' . $file_extension;

// Ensure the upload directory exists and is writable
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true); // Create directory with full permissions if it doesn't exist
}
$upload_path = $upload_dir . $new_filename;

// 5. Move the file to the uploads directory
if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to save the uploaded file.']);
    exit;
}

// 6. Update the database with the new avatar URL
$stmt = $conn->prepare("UPDATE Users SET avatar_url = ? WHERE user_id = ?");
$stmt->bind_param("si", $upload_path, $user_id);

if ($stmt->execute()) {
    // 7. Update the session variable
    $_SESSION['avatar_url'] = $upload_path;
    http_response_code(200);
    echo json_encode(['success' => true, 'avatar_url' => $upload_path]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update your profile.']);
}

$stmt->close();
$conn->close();
?>