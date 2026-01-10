<?php
require 'cors.php';
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
