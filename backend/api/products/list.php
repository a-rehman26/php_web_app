<?php
require_once "../../config/database.php";
require_once "../../config/session.php";

header("Content-Type: application/json");

$userId = $_SESSION['user']['id'];
$role   = $_SESSION['user']['role'];

$catId = $_GET['category_id'] ?? null;

if ($role === "super") {
    // Super: all products
    if ($catId) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=?");
        $stmt->execute([$catId]);
    } else {
        $stmt = $pdo->query("SELECT * FROM products");
    }
} else {
    // Admin: only assigned products
    $sql = "
    SELECT p.*
    FROM products p
    JOIN admin_product_permissions ap
      ON ap.product_id = p.id
    WHERE ap.admin_id = ?
  ";

    $params = [$userId];

    if ($catId) {
        $sql .= " AND p.category_id = ?";
        $params[] = $catId;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}

echo json_encode([
    "status" => "success",
    "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
]);
