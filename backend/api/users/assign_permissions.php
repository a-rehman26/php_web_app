<?php
require "../../config/database.php";
require "../../config/session.php";
requireLogin();

$data = json_decode(file_get_contents("php://input"), true);
$admin = $data['admin_id'];

$pdo->prepare("DELETE FROM admin_category_permissions WHERE admin_id=?")
    ->execute([$admin]);
$pdo->prepare("DELETE FROM admin_product_permissions WHERE admin_id=?")
    ->execute([$admin]);

foreach ($data['categories'] as $c) {
    $pdo->prepare(
        "INSERT INTO admin_category_permissions (admin_id,category_id)
    VALUES (?,?)"
    )->execute([$admin, $c]);
}

foreach ($data['products'] as $p) {
    $pdo->prepare(
        "INSERT INTO admin_product_permissions (admin_id,product_id)
    VALUES (?,?)"
    )->execute([$admin, $p]);
}

echo json_encode(["status" => "success"]);
