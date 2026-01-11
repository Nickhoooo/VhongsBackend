<?php
header("Access-Control-Allow-Origin: https://vhong-drip.vercel.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
include "../config/db.php";


// Query all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
while($row = $result->fetch_assoc()){
    // Prepend full URL to the image field
    $row['image'] = "https://vhongdrip.free.nf/images/" . $row['image'];
    $products[] = $row;
}

// Output JSON
echo json_encode($products);
?>
