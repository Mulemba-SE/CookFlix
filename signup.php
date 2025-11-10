<?php
require_once 'db_connect.php';
session_start(); // Start the session to store user data upon successful registration.

// Set the content type to JSON for API-like responses.
header('Content-Type: application/json');

// We only want to process POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

// Get the raw POST data and decode it from JSON.
$input = json_decode(file_get_contents('php://input'), true);

$username = trim($input['username'] ?? '');
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';
$confirm_password = $input['confirm_password'] ?? '';

// --- Server-Side Validation ---
if (empty($username) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6 || $password !== $confirm_password) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid input. Please check all fields.']);
    exit;
}

// Check if the username or email already exists in the database.
$stmt = $conn->prepare("SELECT user_id FROM Users WHERE email = ? OR username = ?");
$stmt->bind_param("ss", $email, $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    http_response_code(409); // Conflict
    echo json_encode(['error' => 'A user with this username or email already exists.']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Hash the password for security before storing it.
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user into the database.
$stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password_hash);

if ($stmt->execute()) {
    // Get the ID of the new user.
    $user_id = $stmt->insert_id;

    // Automatically log the user in by creating a session.
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['avatar_url'] = null; // New users don't have an avatar yet.

    http_response_code(201); // Created
    echo json_encode([
        'message' => 'Registration successful! You are now logged in.',
        'user' => ['username' => $username, 'email' => $email]
    ]);

} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'An error occurred while creating your account. Please try again.']);
}

$stmt->close();
$conn->close();
?>