<?php
include "../config/db.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: https://vhong-drip-17or.vercel.app");


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
