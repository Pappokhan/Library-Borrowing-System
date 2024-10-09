<?php
session_start();
$_SESSION['username'] = $username; 
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
    $inputUsername = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $inputPassword = $_POST['password'];

    if (empty($inputUsername) || empty($inputPassword)) {
        header("Location: login.html?error=empty_fields");
        exit();
    }

    $stmt = $conn->prepare("SELECT name, email, password FROM account WHERE username = ?");
    if ($stmt === false) {
        error_log("Prepare failed: " . $conn->error);
        die("An error occurred. Please try again later.");
    }

    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($name, $email, $hashedPassword);
        $stmt->fetch();

        if (password_verify($inputPassword, $hashedPassword)) {
            session_regenerate_id(true);

            $_SESSION['username'] = $inputUsername;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;

            header("Location: index.html");
            exit();
        } else {
            header("Location: login.html?error=invalid_password");
            exit();
        }
    } else {
        header("Location: login.html?error=invalid_username");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
