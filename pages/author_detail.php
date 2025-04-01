<?php
// author_detail.php
include '../validate/db.php'; // Include your database connection

if (isset($_GET['author'])) {
    $author = urldecode($_GET['author']);

    // Corrected SQL query to fetch from 'author_books'
    $sql = "SELECT * FROM author_books WHERE author = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $author);
    $stmt->execute();
    $result = $stmt->get_result();

    $books = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }
} else {
    echo "Author not specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial--scale=1.0">
    <title><?php echo htmlspecialchars($author); ?> - Books</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 72%; /* Reduce width from 90% to 80% */
            margin: 100px auto; /* Increase top margin to move it down */
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        header {
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            border-radius: 0;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 60px;
            margin-right: 10px;
        }

        .system-title {
            font-size: 2.1em;
            font-weight: 600;
            white-space: nowrap;
        }

        .search-container {
            display: flex;
            align-items: center;
            flex-grow: 1;
            justify-content: flex-end;
        }

        .search-bar {
            width: 55%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
            margin-right: 15px;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-links ul li {
            margin-left: 15px;
        }

        .nav-links ul li a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .nav-links ul li a:hover {
            color: #ecf0f1;
        }

        .book-section {
            margin-top: 20px;
        }

        .book-section h2 {
            margin-bottom: 15px;
            color: #333;
            font-size: 20px;
            font-weight: 600;
            text-align: center; /* Center the heading */
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 5 columns */
            gap: 20px;
            justify-items: center; /* Center items horizontally */
        }

        .book-item {
            background-color: #3498db;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 218px; /* Set a fixed width */
            height: 210px; /* Set a fixed height */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Space title and button */
            align-items: center;
        }

        .book-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        }

        .book-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }

        .book-item a {
            text-decoration: none;
            color: white;
        }

        .book-title {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .book-details {
            font-size: 14px;
        }

        .borrow-btn {
            background-color: #2ecc71;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .borrow-btn:hover {
            background-color: #27ae60;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #3498db;
            min-width: 150px;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 6px;
            padding: 8px 0;
        }

        .dropdown-content a {
            color: black;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
            font-size: 15px;
        }

        .dropdown-content a:hover {
            background-color: rgb(30, 90, 131);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .down-arrow {
            display: inline-block;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #333;
            margin-left: 5px;
        }

        @media (max-width: 768px) {
            .book-grid {
                grid-template-columns: 1fr;
            }

            .book-item {
                padding: 10px;
            }
        }
<<<<<<< HEAD
=======
        .account-icon-link {
            padding: 0; 
            justify-content: center; 
            display: flex; 
            align-items: center;
            width: 30px; 
            height: 30px; 
        }


        .account-icon-link::before {
            content: ""; 
        }
        .account-icon-link img {
            width: 30px;
            height: 30px;
        }
        .suggestions-box {
            position: absolute;
            width: 55%;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 5;
            display: none;
        }

        .suggestions-box a {
            display: block;
            padding: 8px 12px;
            text-decoration: none;
            color: black;
        }

        .suggestions-box a:hover {
            background-color: #f0f0f0;
        }
    .book-details {
    display: none;
    position: absolute;
    background-color: rgb(85, 161, 212);
    color: white;
    padding: 15px; /* Dagdagan ang padding para sa mas maluwag na loob */
    border-radius: 8px; /* Bahagyang dagdagan ang border-radius */
    width: 250px; /* Dagdagan ang lapad ng container */
    height: 200px; /* Dagdagan ang taas ng container */
    box-sizing: border-box;
    text-align: left;
    z-index: 1000 !important;
    top: -80%;
    left: 0%;
    margin-top: 15px; /* Dagdagan ang margin-top */
    box-shadow: 6px 6px 10px rgba(0, 0, 0, 0.5); /* Dagdagan ang box-shadow */
    font-size: 16px; /* Dagdagan ang laki ng font */
    line-height: 1.5; /* Dagdagan ang line-height para sa mas maluwag na spacing */
}

.book-item:hover .book-details {
    display: block;
}
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
    </style>
</head>
<body>

<header>
    <div class="header-left">
        <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
        <span class="system-title">AklatURSM Management System</span>
    </div>
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Search...">
        <div class="nav-links">
            <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
                <li class="dropdown">
                    <a href="categories.php">Categories <span class="down-arrow"></span></a>
                    <div class="dropdown-content">
                        <a href="genre/math.php">Math</a>
                        <a href="genre/english.php">English</a>
                        <a href="genre/science.php">Science</a>
                        <a href="genre/ap.php">Araling Panlipunan</a>
                        <a href="genre/esp.php">Edukasyon Sa Pagpapakatao</a>
                        <a href="genre/physical-education.php">Physical Education</a>
                        <a href="genre/filipino.php">Filipino</a>
                        <a href="genre/tle.php">Technology and livelihood Education</a>
                    </div>
                </li>
                <li><a href="Authors.php">Authors</a></li>
            </ul>
        </div>
    </div>
</header>

<div class="container">
    <section class="book-section">
        <h2 style="font-size: 30px;">Books by <?php echo htmlspecialchars($author); ?></h2>
        <div class="book-grid">
        <?php
if (!empty($books)) {
    foreach ($books as $book) {
        echo '<div class="book-item">';
        echo '<img src="authorbook-icon.png" alt="Book Icon" class="book-icon">';
        echo '<p class="book-title">' . htmlspecialchars($book['title']) . '</p>';

        // Book Details Div
        echo '<div class="book-details">';
        echo '<p>Author: ' . htmlspecialchars($book['author']) . '</p>';
        echo '<p>Publication Year: ' . htmlspecialchars($book['publication_year']) . '</p>';
        echo '<p>Subject: ' . htmlspecialchars($book['subject']) . '</p>';
        echo '</div>';

        echo '<form action="transaction.php" method="get">';
        echo '<input type="hidden" name="book_id" value="' . htmlspecialchars($book['id']) . '">'; 
        echo '<input type="hidden" name="book_title" value="' . htmlspecialchars($book['title']) . '">';
        echo '<input type="hidden" name="source" value="author_books">'; 
        echo '<button type="submit" class="borrow-btn">Borrow Book</button>';
        echo '</form>';
        echo '</div>';
    }
} else {
    echo "<p>No books found by this author.</p>";
}
?>
        </div>
    </section>
</div>

</body>
</html>
