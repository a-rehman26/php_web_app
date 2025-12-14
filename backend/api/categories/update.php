<?php
require_once "../../config/database.php";
require_once "../../config/session.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$id   = $data['id'] ?? '';
$name = $data['name'] ?? '';
$desc = $data['description'] ?? '';

if (!$id || !$name) {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
    exit;
}

$stmt = $pdo->prepare("UPDATE categories SET name=?, description=? WHERE id=?");
$stmt->execute([$name, $desc, $id]);

echo json_encode(["status" => "success", "message" => "Category updated"]);
