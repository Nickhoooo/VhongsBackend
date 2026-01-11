<?php
include __DIR__ . "/../config/db.php";

header("Access-Control-Allow-Origin: https://vhong-drip-17or.vercel.app");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");


session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/../PHPMailer/Exception.php";
require __DIR__ . "/../PHPMailer/PHPMailer.php";
require __DIR__ . "/../PHPMailer/SMTP.php";




if(isset($_POST['register'])){
    
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = $_POST['email'];
    $password_plain = $_POST ['password'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Invalid email";
        exit();
    } if (strlen($password_plain) < 6) {
        echo "weak password";
        exit();
    }

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check -> bind_param("s", $email);
    $check -> execute();
    $check -> store_result();

    if($check->num_rows > 0){
        echo "email exists";
        exit();

    } if(empty($name) || empty($email) || empty($password_plain)){
        echo "All fields are required";
        exit();
}

    $password = password_hash($password_plain, PASSWORD_DEFAULT);
    $verification_code = bin2hex(random_bytes(16)); // 32-character code
    $verified = 0;

    // Insert user as inactive with verification code
    $sql = "INSERT INTO users (name, email, password, verified, verification_code) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $password, $verified, $verification_code);

    if(!$stmt->execute()){
        echo "error";
        exit();
    }

    // Send verification email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'xenonchan29@gmail.com';
        $mail->Password = 'wegd vevh vein wwzl';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('xenonchan29@gmail.com', 'Vhong Website');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification - Vhong Website';
        
        $verification_link = "https://vhongdrip.free.nf/api/verify.php?code=$verification_code";
        
        $mail->Body = "<h2>Welcome to Vhong Website!</h2>
            <p>Hi $name,</p>
            <p>Thank you for signing up! Please verify your email to activate your account:</p>
            <p><a href='$verification_link' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; display: inline-block;'>Verify Email</a></p>
            <p>Or copy this link: $verification_link</p>
            <p>This link will expire in 24 hours.</p>
            <p>If you didn't sign up, please ignore this email.</p>";

        $mail->send();
        echo json_encode([
            "status" => "success",
            "message" => "Successful! Please check your Gmail to verify your email before logging in.",
            "redirect" => "/login"
        ]); 
        exit();
    } catch (Exception $e) {
        echo "Verification email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


    }


?>