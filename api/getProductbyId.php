<?php
header("Access-Control-Allow-Origin: https://vhong-drip.vercel.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include "../config/db.php"; 



$id = intval($_GET['id']); 

$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

$product = $result->fetch_assoc();

echo json_encode($product);
?>
