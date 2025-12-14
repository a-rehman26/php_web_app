<?php
require "../../config/session.php";

if (isLoggedIn()) {
    echo json_encode([
        "logged_in" => true,
        "role" => $_SESSION['user']['role']
    ]);
} else {
    echo json_encode(["logged_in" => false]);
}
