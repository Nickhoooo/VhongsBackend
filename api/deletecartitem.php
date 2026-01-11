<?php
header("Access-Control-Allow-Origin: *"); // Allow all domains
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include "../config/db.php";

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Missing id"]);
    exit;
}

$delete = $conn->prepare("DELETE FROM cart WHERE id=?");
$delete->bind_param("i", $id);
$delete->execute();

echo json_encode(["status" => "deleted"]);
