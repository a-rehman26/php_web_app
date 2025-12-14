<?php
require_once "../../config/database.php";
require_once "../../config/session.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$category_id = $_POST['category_id'] ?? '';
$name        = $_POST['name'] ?? '';
$sku         = $_POST['sku'] ?? '';
$description = $_POST['description'] ?? '';
$price       = $_POST['price'] ?? '';

if (!$category_id || !$name) {
    echo json_encode(["status" => "error", "message" => "Missing fields"]);
    exit;
}

/* IMAGE UPLOAD */
$imageName = null;

if (!empty($_FILES['image']['name'])) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = time() . "_" . rand(1000, 9999) . "." . $ext;

    $uploadDir = "../../uploads/products/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $path = $uploadDir . $imageName;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
        echo json_encode(["status" => "error", "message" => "Image upload failed"]);
        exit;
    }
}

/* INSERT INTO DB */
$stmt = $pdo->prepare("
  INSERT INTO products
  (category_id, name, sku, description, price, image)
  VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $category_id,
    $name,
    $sku,
    $description,
    $price,
    $imageName
]);

echo json_encode([
    "status" => "success",
    "message" => "Product added successfully"
]);
