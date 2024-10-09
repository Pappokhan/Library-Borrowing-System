<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
$gender = isset($_GET['gender']) ? trim($_GET['gender']) : '';
$genres = isset($_GET['genres']) ? trim($_GET['genres']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Search Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #6a11cb;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
            margin-top: 20px;
            border-bottom: 2px solid #6a11cb;
            padding-bottom: 5px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            display: flex;
            justify-content: space-between;
        }

        .book-info {
            flex-grow: 1;
        }

        .back-button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #6a11cb;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #5b0bb5;
        }

        .search-form {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .search-form input,
        .search-form select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1 1 200px; /* Responsive */
        }

        .search-form button {
            padding: 10px 15px;
            background-color: #6a11cb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            flex-shrink: 0; /* Prevents shrinking */
        }

        .search-form button:hover {
            background-color: #5b0bb5;
        }

        .no-results {
            color: #e74c3c;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book Search</h1>

        <form class="search-form" method="get" action="">
            <input type="text" name="query" placeholder="Search by title or author" value="<?php echo htmlspecialchars($query); ?>">
            <input type="text" name="id" placeholder="Enter Book ID" value="<?php echo htmlspecialchars($id); ?>">
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="Male" <?php if ($gender === 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($gender === 'Female') echo 'selected'; ?>>Female</option>
            </select>
            <input type="text" name="genres" placeholder="Enter Book Genres" value="<?php echo htmlspecialchars($genres); ?>">
            <button type="submit"><i class="fas fa-search"></i> Search</button>
        </form>

        <?php
        if ($query || $id || $gender || $genres) {
            $safe_query = $conn->real_escape_string($query);
            $safe_id = $conn->real_escape_string($id);
            $safe_gender = $conn->real_escape_string($gender);
            $safe_genres = $conn->real_escape_string($genres);

            $sql = "SELECT Book_Title, Book_Author, Name FROM borrow WHERE 
                    (Book_Title LIKE '%$safe_query%' OR Book_Author LIKE '%$safe_query%') AND 
                    (ID LIKE '%$safe_id%' OR '$safe_id' = '') AND 
                    (Gender LIKE '%$safe_gender%' OR '$safe_gender' = '') AND 
                    (Book_Genres LIKE '%$safe_genres%' OR '$safe_genres' = '')";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Search Results for: " . htmlspecialchars($query) . "</h2>";
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li><div class='book-info'><strong>" . htmlspecialchars($row['Book_Title']) . "</strong> by " . htmlspecialchars($row['Book_Author']) . "</div> <span>(Borrowed by: " . htmlspecialchars($row['Name']) . ")</span></li>";
                }
                echo "</ul>";
            } else {
                echo "<p class='no-results'>No books found matching your search query.</p>";
            }
        } else {
            echo "<p class='no-results'>Please enter a search query.</p>";
        }
        ?>

        <a href="index.html" class="back-button">Back to Home</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
