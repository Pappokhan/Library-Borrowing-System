<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in username from the session
$logged_in_username = $_SESSION['username'];

// Modify the SQL query to fetch books borrowed by the logged-in user
$sql = "SELECT * FROM borrow WHERE Name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrow List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }
        nav {
            margin-bottom: 20px;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h1 {
            color: #007BFF;
            text-align: center;
        }
        .notice {
            background-color: #e9f7fa;
            border: 1px solid #b2ebf2;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Book Borrow List</h1>
            <nav>
                <a href="profile.php">See Profile</a>
            </nav>
        </header>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Book Title</th>
                        <th>Book Author</th>
                        <th>Gender</th>
                        <th>Book Genres</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Selected Books</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Book_Title']); ?></td>
                            <td><?php echo htmlspecialchars($row['Book_Author']); ?></td>
                            <td><?php echo htmlspecialchars($row['Gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['Book_Genres']); ?></td>
                            <td><?php echo htmlspecialchars($row['Borrow_Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['Return_Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['Selected_Books']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="notice">
                <h3>Important Notice:</h3>
                <p>Upon borrowing a book, you will be unable to borrow any additional books from the Borrow Date until the Return Date. You may borrow this book again only after it has been returned.</p>
            </div>
        <?php else: ?>
            <p>No records found for your account.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
