<?php
header("Access-Control-Allow-Origin: *"); // Allow all domains
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
include "../config/db.php";



if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM promo WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $promo = $result->fetch_assoc();
    echo json_encode($promo);
} else {
    $result = $conn->query("SELECT * FROM promo");
    $promo = [];
    while($row = $result->fetch_assoc()){
        $promo[] = $row;
    }
    echo json_encode($promo);
}
?>
