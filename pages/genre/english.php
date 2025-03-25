<?php
// english.php
include '../../validate/db.php';

// Check if $conn is set properly
if (!isset($conn)) {
    die("Database connection failed.");
}

// Fetch books from library_books table that belong to 'English' category
$sql = "SELECT library_books.* FROM library_books
        JOIN categories ON library_books.category_id = categories.id
        WHERE categories.name = 'English'";

$result = $conn->query($sql);

$books = [];
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row; // Store each book's data in the $books array
        }
    }
} else {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English Books</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>

<header>
    <div class="header-left">
        <img src="../genre/LMS_logo.png" alt="Library Logo" class="logo">
        <span class="system-title">AklatURSM Management System</span>
    </div>
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Search...">
    </div>
    <div class="nav-links">
        <ul>
            <li><a href="../dashboard.php">Dashboard</a></li>
            <li class="dropdown">
                <a href="../categories.php">Categories <span class="down-arrow"></span></a>
                <div class="dropdown-content">
                    <a href="math.php">Math</a>
                    <a href="english.php">English</a>
                    <a href="science.php">Science</a>
                    <a href="ap.php">Araling Panlipunan</a>
                    <a href="esp.php">Edukasyon Sa Pagpapakatao</a>
                    <a href="physical-education.php">Physical Education</a>
                    <a href="filipino.php">Filipino</a>
                    <a href="tle.php">Technology and livelihood Education</a>
                </div>
            </li>
            <li><a href="../Authors.php">Authors</a></li>
        </ul>
    </div>
</header>

<div class="container">
    <section class="book-section">
        <h2>Genre: English</h2>
        <div class="book-grid">
            <div class="book-item">
                <img src="book-icon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">English Book 1</p>
                <form action="transaction.php" method
                "get">
                    <input type="hidden" name="book_id" value="1">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
            <div class="book-item">
                <img src="book-icon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">English Book 2</p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="2">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
            <div class="book-item">
                <img src="book-icon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">English Book 3</p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="3">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
            <div class="book-item">
                <img src="book-icon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">English Book 4</p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="4">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
            <div class="book-item">
                <img src="book-icon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">English Book 5</p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="5">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
        </div>
    </section>
</div>

</body>
</html>