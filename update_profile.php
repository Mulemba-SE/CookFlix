<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// 1. Check for login status
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'You must be logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. Sanitize and Validate Input
// Use $_POST since the data is coming from a FormData object
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$bio = trim($_POST['bio'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$location = trim($_POST['location'] ?? '');

if (empty($username) || empty($email)) {
    http_response_code(400);
    echo json_encode(['error' => 'Username cannot be empty.']);
    exit;
}

if (strlen($username) > 50) {
    http_response_code(400);
    echo json_encode(['error' => 'Username is too long.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email format.']);
    exit;
}

// 3. Check if username or email are already taken by another user
$stmt = $conn->prepare("SELECT user_id FROM Users WHERE (username = ? OR email = ?) AND user_id != ?");
$stmt->bind_param("ssi", $username, $email, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    http_response_code(409); // Conflict
    // More specific error checking could be done here if needed
    echo json_encode(['error' => 'This username or email is already taken.']);
    $stmt->close();
    exit;
}
$stmt->close();

// 4. Update the user's information in the database
$stmt = $conn->prepare("UPDATE Users SET username = ?, email = ?, bio = ?, phone = ?, location = ? WHERE user_id = ?");
$stmt->bind_param("sssssi", $username, $email, $bio, $phone, $location, $user_id);

if ($stmt->execute()) {
    // 5. Update session variables to reflect the change immediately
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;

    // 6. Send back the updated data for dynamic page update
    echo json_encode([
        'success' => true,
        'message' => 'Profile updated successfully.',
        'data' => [
            'username' => $username,
            'email' => $email,
            'bio' => $bio,
            'phone' => $phone,
            'location' => $location
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update profile.']);
}

$stmt->close();
$conn->close();
?>