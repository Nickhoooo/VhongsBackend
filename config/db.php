<?php
$servername = "sql103.infinityfree.com";
$username = "if0_40869155";
$password = "VhongDrip1122";
$dbname = "if0_40869155_ecommerce_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "CONNECTED SUCCESSFULLY";
?>
