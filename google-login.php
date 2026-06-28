<?php
session_start();
require 'config.php';   // Your DB connection file

require_once __DIR__ . '/vendor/autoload.php';   // After running: composer require google/apiclient

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['credential']) || empty($data['credential'])) {
    echo json_encode(["status" => "error", "message" => "No credential received"]);
    exit;
}

$credential = $data['credential'];
$client_id  = '1068476382856-ee0nb1rgdtnun1u5fjef41n7bfoe2b69.apps.googleusercontent.com';  // Your real Client ID

$client = new Google_Client(['client_id' => $client_id]);

try {
    $payload = $client->verifyIdToken($credential);

    if (!$payload) {
        echo json_encode(["status" => "error", "message" => "Invalid Google token"]);
        exit;
    }

    $google_id = $payload['sub'];
    $name      = $payload['name'] ?? 'Google User';
    $email     = $payload['email'] ?? '';
    $picture   = $payload['picture'] ?? null;

} catch (Exception $e) {
    error_log("Google Verify Error: " . $e->getMessage());
    echo json_encode([
        "status" => "error", 
        "message" => "Token verification failed. Please try again."
    ]);
    exit;
}

// Check if user exists
$stmt = $conn->prepare("SELECT id, name, email FROM users WHERE google_id = ? OR email = ?");
$stmt->bind_param("ss", $google_id, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User exists → Login
    $user = $result->fetch_assoc();
} else {
    // New user → Register
    $stmt = $conn->prepare("INSERT INTO users (google_id, name, email, password, picture) 
                            VALUES (?, ?, ?, NULL, ?)");
    $stmt->bind_param("ssss", $google_id, $name, $email, $picture);

    if (!$stmt->execute()) {
        echo json_encode(["status" => "error", "message" => "Failed to create account"]);
        exit;
    }

    $user = [
        "id"    => $conn->insert_id,
        "name"  => $name,
        "email" => $email
    ];
}

// Set session
$_SESSION['user_id'] = $user['id'];
$_SESSION['name']    = $user['name'];
$_SESSION['email']   = $user['email'];

echo json_encode([
    "status" => "success",
    "user"   => $user
]);
?>