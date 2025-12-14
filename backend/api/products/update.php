<?php
require_once "../../config/database.php";
require_once "../../config/session.php";

header("Content-Type: application/json");

$id          = $_POST['id'] ?? '';
$category_id = $_POST['category_id'] ?? '';
$name        = $_POST['name'] ?? '';
$sku         = $_POST['sku'] ?? '';
$description = $_POST['description'] ?? '';
$price       = $_POST['price'] ?? '';

if (!$id || !$name) {
    echo json_encode(["status" => "error", "message" => "Missing fields"]);
    exit;
}

/* IMAGE (OPTIONAL REPLACE) */
$imageSql = "";
$params   = [$category_id, $name, $sku, $description, $price];

if (!empty($_FILES['image']['name'])) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = time() . "_" . rand(1000, 9999) . "." . $ext;

    $path = "../../uploads/products/" . $imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $path);

    $imageSql = ", image=?";
    $params[] = $imageName;
}

$params[] = $id;

$sql = "UPDATE products SET 
        category_id=?, name=?, sku=?, description=?, price=? 
        $imageSql
        WHERE id=?";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["status" => "success", "message" => "Product updated"]);
