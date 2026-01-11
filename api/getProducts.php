<?php
header("Access-Control-Allow-Origin: https://vhong-drip.vercel.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include "../config/db.php";

 // allow requests from React

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
while($row = $result->fetch_assoc()){
    $products[] = $row;
}

echo json_encode($products);



?>

