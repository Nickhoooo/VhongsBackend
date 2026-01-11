<?php
header("Access-Control-Allow-Origin: https://vhong-drip.vercel.app");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include "../config/db.php";
include "../config/config.php"; 

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM promo WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $promo = $result->fetch_assoc();

    if ($promo) {
        $promo['image'] = BASE_IMAGE_URL . $promo['image']; 
    }

    echo json_encode($promo);

} else {
    $result = $conn->query("SELECT * FROM promo");
    $promo = [];
    while($row = $result->fetch_assoc()){
        $row['image'] = BASE_IMAGE_URL . $row['image']; 
        $promo[] = $row;
    }
    echo json_encode($promo);
}
?>
