<?php
require "../../config/database.php";
require "../../config/session.php";
requireLogin();
if (!isSuper()) {
    echo json_encode(["error" => "Forbidden"]);
    exit;
}

$st = $pdo->query("SELECT id,username FROM users WHERE role='admin'");
echo json_encode(["data" => $st->fetchAll()]);
