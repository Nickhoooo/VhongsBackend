<?php
include "../config/db.php"; 

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: https://vhong-drip-17or.vercel.app");


$id = intval($_GET['id']); 

$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

$product = $result->fetch_assoc();

echo json_encode($product);
?>
