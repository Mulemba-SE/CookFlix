<?php
require_once 'api/db_connect.php';

// Start the session to access session data.
session_start();

header('Content-Type: application/json');

// Check if the user_id is set in the session.
if (isset($_SESSION['user_id'])) {
    // User is logged in. Fetch the latest user data from the database.
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT user_id, username, email, profile_picture_url FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        echo json_encode([
            'loggedIn' => true,
            'user' => [
                'id' => $user['user_id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'avatar' => $user['profile_picture_url']
            ]
        ]);
    } else {
        // User in session not found in DB, treat as logged out.
        echo json_encode(['loggedIn' => false]);
    }
} else {
    // User is not logged in.
    echo json_encode(['loggedIn' => false]);
}

$conn->close();
?>