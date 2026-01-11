<?php
include "../config/db.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: https://vhong-drip-17or.vercel.app");
 // allow requests from React

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
while($row = $result->fetch_assoc()){
    $products[] = $row;
}

echo json_encode($products);



?>

