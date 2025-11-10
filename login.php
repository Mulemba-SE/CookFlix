<?php
require_once 'db_connect.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';

// --- Server-Side Validation ---
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid email or password.']);
    exit;
}

// Fetch user from the database
$stmt = $conn->prepare("SELECT user_id, username, email, password_hash, avatar_url FROM Users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password_hash'])) {
    // Password is correct. Regenerate session ID to prevent session fixation.
    session_regenerate_id(true);

    // Store user data in the new session.
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['avatar_url'] = $user['avatar_url'];

    http_response_code(200); // OK
    echo json_encode([
        'message' => 'Login successful!',
        'user' => [
            'username' => $user['username'],
            'email' => $user['email'],
            'avatar_url' => $user['avatar_url']
        ]
    ]);
} else {
    // Invalid credentials
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Invalid email or password.']);
}

$stmt->close();
$conn->close();
?>
