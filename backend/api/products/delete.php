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

/* DELETE IMAGE */
$q = $pdo->prepare("SELECT image FROM products WHERE id=?");
$q->execute([$id]);
$img = $q->fetchColumn();

if ($img && file_exists("../../uploads/products/" . $img)) {
    unlink("../../uploads/products/" . $img);
}

/* DELETE ROW */
$pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);

echo json_encode(["status" => "success", "message" => "Product deleted"]);
