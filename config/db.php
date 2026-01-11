<?php
$servername = "sql103.infinityfree.com";
$username = "if0_40869155";
$password = "VhongDrip1122";
$dbname = "if0_40869155_ecommerce_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500); // Para makita sa frontend na error
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}


?>
