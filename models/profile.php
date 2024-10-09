<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$name = $_SESSION['name'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$profilePicture = '1.jpeg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .profile-container {
            width: 400px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .profile-container h2 {
            margin-bottom: 10px;
            font-size: 28px;
            color: #333;
        }

        .profile-container p {
            font-size: 18px;
            color: #555;
            margin: 5px 0;
        }

        .profile-picture {
            width: 100px; /* Adjust size as needed */
            height: 100px; /* Adjust size as needed */
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover; /* Ensures the image covers the area */
            border: 4px solid #6a11cb; /* Border around the picture */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Optional shadow for depth */
        }

        .profile-container a {
            display: inline-block;
            width: calc(100% - 20px);
            margin: 10px 0;
            padding: 12px 0;
            background-color: #6a11cb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }

        .profile-container a:hover {
            background-color: #5b0bb5;
            transform: translateY(-2px);
        }

        .profile-container a:active {
            transform: translateY(0);
        }

        .divider {
            height: 1px;
            background-color: #ddd;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" class="profile-picture">
        <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        <p>Username: <?php echo htmlspecialchars($username); ?></p>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <div class="divider"></div>
        <a href="logout.html">Logout</a>
        <a href="index.html">Home</a>
        <a href="Book_Borrow_List.php">Your Book Borrow Info</a>
    </div>
</body>
</html>
