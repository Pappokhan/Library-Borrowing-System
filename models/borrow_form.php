<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = htmlspecialchars($_POST['name']);
$id = htmlspecialchars($_POST['id']);
$book_title = htmlspecialchars($_POST['book_title']);
$book_author = htmlspecialchars($_POST['book_author']);
$gender = htmlspecialchars($_POST['gender']);
$borrow_date = htmlspecialchars($_POST['borrow_date']);
$return_date = htmlspecialchars($_POST['return_date']);
$selected_books = htmlspecialchars($_POST['book']);

$stmt = $conn->prepare("INSERT INTO borrow (Name, ID, Book_Title, Book_Author, Gender, Borrow_Date, Return_Date, Selected_Books) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $name, $id, $book_title, $book_author, $gender, $borrow_date, $return_date, $selected_books);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
