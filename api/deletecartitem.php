<?php
require_once __DIR__ . "/cors.php";
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
