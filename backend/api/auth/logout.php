<?php
require "../../config/session.php";
session_destroy();
echo json_encode(["status" => "success", "message" => "Logged out"]);
