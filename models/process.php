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
$student_id = htmlspecialchars($_POST['id']);
$book_title = htmlspecialchars($_POST['book_title']);
$book_author = htmlspecialchars($_POST['book_author']);
$book_genres = htmlspecialchars($_POST['book_type']);
$selected_books = htmlspecialchars($_POST['book']);
$gender = htmlspecialchars($_POST['gender']);
$borrow_date = htmlspecialchars($_POST['borrow_date']);
$return_date = htmlspecialchars($_POST['return_date']);
$agreement = isset($_POST['agreement']) ? 1 : 0;

$sql = "INSERT INTO borrow (Name, ID, Book_Title, Book_Author, Gender, Book_Genres, Borrow_Date, Return_Date, Selected_Books)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $name, $student_id, $book_title, $book_author, $gender, $book_genres, $borrow_date, $return_date, $selected_books);

if ($stmt->execute()) {
    header("Location: index.html?message=" . urlencode("Book borrowed successfully!"));
    exit();
} else {
    header("Location: index.html?message=" . urlencode("Error: " . $stmt->error));
    exit();
}

$stmt->close();
$conn->close();
?>