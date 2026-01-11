<?php
header("Access-Control-Allow-Origin: *"); // Allow all domains
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
include "../config/db.php"; 



$id = intval($_GET['id']); 

$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

$product = $result->fetch_assoc();

echo json_encode($product);
?>
