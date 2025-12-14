<?php
require "../../config/database.php";
require "../../config/session.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare(
    "SELECT * FROM users WHERE username=? AND password=?"
);
$stmt->execute([
    $data['username'],
    md5($data['password'])
]);

$user = $stmt->fetch();

if ($user) {
    $_SESSION['user'] = $user;
    echo json_encode(["status" => "success", "role" => $user['role']]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
}
