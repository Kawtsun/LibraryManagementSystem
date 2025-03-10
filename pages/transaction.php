<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $book_title = $_POST['book_title'] ?? '';
    
    echo "<h3>Transaction Details</h3>";
    echo "<p><strong>Book Title:</strong> $book_title</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Address:</strong> $address</p>";
    echo "<p><strong>Contact Number:</strong> $contact</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #add8e6;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            width: 80px;
            margin-left: 20px;
        }
        .search-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }
        .search-box {
            width: 60%;
            padding: 8px;
            border-radius: 20px;
            border: 1px solid #ccc;
        }
        .search-icon {
            margin-left: -30px;
            cursor: pointer;
        }
        .refresh-icon {
            width: 30px;
            margin-right: 20px;
            cursor: pointer;
        }
        .container {
            width: 50%;
            margin: auto;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px gray;
        }

        .container .book-img {
            width: 150px;
        }
        input {
            width: 80%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        button {
            width: 40%;
            padding: 8px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto 0;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        button:hover {
            background-color: darkblue;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="../img/LMS_logo.png" alt="Logo" class="logo">
        <div class="search-container">
            <input type="text" class="search-box" placeholder="Search...">
            <img src="search-icon.png" alt="Search" class="search-icon">
        </div>
        <img src="refresh-icon.png" alt="Refresh" class="refresh-icon">
    </div>
    
    <div class="container">
        <h2>Transaction</h2>
        <p>Selected Book:</p>
        <img src="../img/books.png" alt="Book" width="50" class="book-img">
        <p><strong>Book Title</strong></p>
        <form method="POST">
            <input type="text" name="email" placeholder="Email" required>
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="contact" placeholder="Contact Number" required>
            <input type="hidden" name="book_title" value="Book Title">
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
