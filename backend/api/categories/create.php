<?php
require "../../config/database.php";
require "../../config/session.php";
requireLogin();

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare(
    "INSERT INTO categories (name, description) VALUES (?,?)"
);
$stmt->execute([$data['name'], $data['description']]);

echo json_encode(["status" => "success"]);
