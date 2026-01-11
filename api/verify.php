<?php
include __DIR__ . "/../config/db.php";

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $query = "SELECT id FROM users WHERE verification_code = ? AND verified = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $update = "UPDATE users SET verified = 1, verification_code = NULL WHERE verification_code = ?";
        $update_stmt = $conn->prepare($update);
        $update_stmt->bind_param("s", $code);
        $update_stmt->execute();
        echo "Your email has been verified! You can now <a href='https://vhong-drip-17or.vercel.app/login'>login</a>.";
    } else {
        echo "Invalid or expired verification link.";
    }
} else {
    echo "No verification code provided.";
}
?>
