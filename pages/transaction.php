<?php
session_start();
include '../validate/db.php';

$bookTitle = "";
$bookCoverImage = "";
$email = "";
$student_id = "";

// Get user session details
if (isset($_SESSION['email']) && isset($_SESSION['student_id'])) {
    $email = $_SESSION['email'];
    $student_id = $_SESSION['student_id'];
}

// Get book title from URL if borrowed from author_detail.php
if (isset($_GET['book_title'])) {
    $bookTitle = htmlspecialchars($_GET['book_title']);
}

// Get book details from the database if book_id is provided
if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];
    
    $sql = "SELECT title, cover_image FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bookTitle = $row['title'];
        $bookCoverImage = $row['cover_image'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Transaction</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            background-image: url('../img/background-transaction.jpg');
            background-size: cover;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 10px 20px;
            position: relative;
            z-index: 10;
        }

        .logo {
            width: 60px;
            margin-right: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 2.1em;
            font-weight: 600;
            color: white;
        }

        .container {
            width: 85%;
            max-width: 800px;
            margin: auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: left;
            border: 1px solid #e0e0f0;
            box-sizing: border-box;
            backdrop-filter: blur(5px);
        }

        .book-display {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 250px;
            margin-left: 250px;
        }

        .book-display img {
            width: 80px;
            height: 80px;
            margin-bottom: 8px;
        }

        .book-title {
            font-size: 1em;
            margin-bottom: 0;
            padding: 4px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            font-size: 1em;
        }

        input {
            width: calc(100% - 16px);
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            display: block;
            font-size: 1em;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 1.1em;
        }

        button:hover {
            background-color: #2980b9;
            transform: scale(1.02);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .info-row div {
            width: 48%;
        }
    </style>
</head>
<body>
<div class="header">
        <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
        <h2>AklatURSM Management System</h2>
    </div>
<div class="container">
        <div class="book-display">
            <img src="<?php echo $bookCoverImage ? $bookCoverImage : '/pages/booksicon.png'; ?>" alt="Book Cover">
            <p class="book-title"><?php echo $bookTitle; ?></p>
        </div>

        <h2>Transaction Details</h2>
        <form id="transactionForm" method="POST" action="print.php">
            <div class="info-row">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly>
                </div>
                <div>
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" value="<?php echo $student_id; ?>" readonly>
                </div>
            </div>
            <div class="info-row">
                <div>
                    <label for="name">Borrower Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="contact">Contact Number:</label>
                    <input type="text" id="contact" name="contact" required>
                </div>
            </div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <label for="book_id">Book Title:</label>
            <input type="text" id="book_id" name="book_id" value="<?php echo $bookTitle; ?>" readonly>
            <div class="info-row">
                <div>
                    <label for="date_borrowed">Date Borrowed:</label>
                    <input type="date" id="date_borrowed" name="date_borrowed" required>
                </div>
                <div>
                    <label for="return_date">Return Date:</label>
                    <input type="date" id="return_date" name="return_date" required>
                </div>
            </div>
            <button type="submit">Proceed to Print Transaction</button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let today = new Date().toISOString().split('T')[0];
            let dateBorrowed = document.getElementById("date_borrowed");
            let returnDate = document.getElementById("return_date");
            dateBorrowed.value = today;
            dateBorrowed.min = today;
            returnDate.min = today;
            dateBorrowed.addEventListener("change", function () {
                returnDate.min = dateBorrowed.value;
            });
            returnDate.addEventListener("change", function () {
                if (returnDate.value < dateBorrowed.value) {
                    alert("Return date cannot be earlier than the borrowed date!");
                    returnDate.value = dateBorrowed.value;
                }
            });
        });
    </script>
</body>
</html>