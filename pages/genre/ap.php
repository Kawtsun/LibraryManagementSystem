<?php
// ap.php
include '../../validate/db.php';

// Check if $conn is set properly
if (!isset($conn)) {
    die("Database connection failed.");
}

// Fetch books from library_books table that belong to 'Araling Panlipunan' category
$sql = "
    SELECT id, title, topic, 'library_books' AS source 
    FROM library_books 
    WHERE category_id = (SELECT id FROM categories WHERE name = 'Araling Panlipunan')
    UNION ALL
    SELECT id, title, NULL AS topic, 'books' AS source 
    FROM books 
    WHERE subject = 'Araling Panlipunan'
";

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
    <title>Araling Panlipunan Books</title>
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
                            <a href="tle.php">Technology and Livelihood Education</a>
                        </div>
                    </li>
                    <li><a href="../Authors.php">Authors</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <section class="book-section">
            <h2>Araling Panlipunan Books</h2>
            <div class="book-grid">
                <?php
                if (!empty($books)) {
                    foreach ($books as $book) {
                        echo '<div class="book-item">';
                        echo '<img src="./ap-icon.png" alt="Book Icon" class="book-icon">';
                        echo '<p class="book-title">' . htmlspecialchars($book['title']) . '</p>';
                        echo '<p class="book-topic">Topic: ' . htmlspecialchars($book['topic']) . '</p>';
                        echo '<form action="../transaction.php" method="get">';
                        echo '<input type="hidden" name="book_id" value="' . urlencode($book['id']) . '">';
                        echo '<input type="hidden" name="source" value="' . htmlspecialchars($book['source']) . '">';
                        echo '<button type="submit" class="borrow-btn">Borrow Book</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No books found in this category.</p>";
                }
                ?>
            </div>
        </section>
    </div>

</body>
</html>