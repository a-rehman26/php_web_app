<?php
require_once "../../config/database.php";
require_once "../../config/session.php";

header("Content-Type: application/json");

$userId = $_SESSION['user']['id'];
$role   = $_SESSION['user']['role'];

if ($role === "super") {
    // Super sees all
    $stmt = $pdo->query("SELECT * FROM categories");
} else {
    // Admin sees only assigned categories
    $stmt = $pdo->prepare("
    SELECT c.*
    FROM categories c
    JOIN admin_category_permissions p
      ON p.category_id = c.id
    WHERE p.admin_id = ?
  ");
    $stmt->execute([$userId]);
}

echo json_encode([
    "status" => "success",
    "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
]);
