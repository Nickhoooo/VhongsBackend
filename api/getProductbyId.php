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


$baseImageUrl = "https://vhongdrip.free.nf/images/"; // path to your product images

$id = intval($_GET['id']); 

$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

$product = $result->fetch_assoc();

if ($product) {
    // prepend full URL to the image field
    $product['image'] = $baseImageUrl . $product['image'];
}

echo json_encode($product);
?>
