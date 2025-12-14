<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['user']) && isset($_SESSION['user']['id']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header("Content-Type: application/json");
        echo json_encode([
            "status" => "error",
            "message" => "Unauthorized"
        ]);
        exit;
    }
}

function isSuper()
{
    return isLoggedIn() && ($_SESSION['user']['role'] === 'super');
}

function currentUserId()
{
    return $_SESSION['user']['id'] ?? null;
}
