<?php
require 'cors.php';
include "../config/db.php";

session_start();
$user_id = $_POST['user_id'] ?? null;
$product_id = $_POST['product_id'] ?? null;

if (!$user_id || !$product_id) {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
    exit;
}

// Check if item already exists
$check = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id=? AND product_id=?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Already in cart → increment quantity
    $item = $result->fetch_assoc();
    $newQty = $item['quantity'] + 1;

    $update = $conn->prepare("UPDATE cart SET quantity=? WHERE id=?");
    $update->bind_param("ii", $newQty, $item['id']);
    $update->execute();
} else {
    // Insert new item
    $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
    $insert->bind_param("ii", $user_id, $product_id);
    $insert->execute();
}

echo json_encode(["status" => "success"]);
