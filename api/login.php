<?php
// Start session BEFORE any headers or output
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_secure', '0');
session_start();

include __DIR__ . "/../config/db.php";

header("Access-Control-Allow-Origin: https://vhong-drip-17or.vercel.app");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");


if (isset($_POST['login'])) {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode([
            "status" => "error",
            "message" => "All fields are required"
        ]);
        exit();
    }

    $stmt = $conn->prepare("SELECT id, password, name, email, verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Email not found"
        ]);
        exit();
    }

    $stmt->bind_result($id, $hashedPassword, $name, $user_email, $verified);
    $stmt->fetch();

    // Check if email is verified
    if ($verified === 0 || $verified === "0") {
        echo json_encode([
            "status" => "error",
            "message" => "Please verify your email before logging in. Check your inbox for the verification link."
        ]);
        exit();
    }

    if (password_verify($password, $hashedPassword)) {
        // Set session variables for checkout
        $_SESSION['user_id'] = $id;
        $_SESSION['email'] = $user_email;
        $_SESSION['username'] = $name;

        echo json_encode([
            "status" => "success",
            "user" => [
                "id" => $id,
                "username" => $name,
                "email" => $user_email
            ]
        ]);
        exit();

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid password"
        ]);
        exit();
    }
}

session_write_close(); // Force write session to disk
?>
