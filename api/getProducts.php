<?php
require_once __DIR__ . "/cors.php";
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
