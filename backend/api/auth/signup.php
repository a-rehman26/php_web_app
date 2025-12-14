<?php
header("Content-Type: application/json");

require "../../config/database.php";
require "../../config/session.php";

// READ JSON SAFELY
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// VALIDATION
if (
    empty($data['name']) ||
    empty($data['username']) ||
    empty($data['email']) ||
    empty($data['password'])
) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields required"
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO users (name, username, email, password, role)
     VALUES (?, ?, ?, ?, 'admin')"
    );

    $stmt->execute([
        $data['name'],
        $data['username'],
        $data['email'],
        md5($data['password'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Signup successful"
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Username or email already exists"
    ]);
}
