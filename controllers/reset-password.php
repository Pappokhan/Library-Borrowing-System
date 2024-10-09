<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        header("Location: reset-password.html?error=empty_fields");
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        header("Location: reset-password.html?error=password_mismatch");
        exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE account SET password = ? WHERE email = ?");
    if ($stmt === false) {
        error_log("Prepare failed: " . $conn->error);
        die("An error occurred. Please try again later.");
    }

    $stmt->bind_param("ss", $hashedPassword, $email);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        header("Location: login.html?success=password_reset");
        exit();
    } else {
        header("Location: reset-password.html?error=email_not_found");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
