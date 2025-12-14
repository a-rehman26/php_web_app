<?php
require_once "../../config/database.php";
require_once "../../config/session.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? '';

if (!$id) {
    echo json_encode(["status" => "error", "message" => "ID required"]);
    exit;
}

$pdo->prepare("DELETE FROM categories WHERE id=?")->execute([$id]);

echo json_encode(["status" => "success", "message" => "Category deleted"]);
