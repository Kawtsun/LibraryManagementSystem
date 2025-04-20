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

// Start the session
session_start();

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = "";
}

function getBookTitles($conn) {
    $titles = [];

    // Fetch titles from 'books' table
    $sql_books = "SELECT title FROM books";
    $result_books = $conn->query($sql_books);
    if ($result_books->num_rows > 0) {
        while ($row = $result_books->fetch_assoc()) {
            $titles[] = $row['title'];
        }
    }

    // Fetch authors from 'author_books' table
    $sql_authors = "SELECT DISTINCT author FROM author_books";
    $result_authors = $conn->query($sql_authors);
    if ($result_authors->num_rows > 0) {
        while ($row = $result_authors->fetch_assoc()) {
            $titles[] = $row['author'];
        }
    }

    // Fetch categories from 'categories' table
    $sql_categories = "SELECT name FROM categories"; // Updated to 'name'
    $result_categories = $conn->query($sql_categories);
    if ($result_categories->num_rows > 0) {
        while ($row = $result_categories->fetch_assoc()) {
            $titles[] = $row['name']; // Updated to 'name'
        }
    }

    // Fetch titles from library_books table
    $sql_library_books = "SELECT title FROM library_books";
    $result_library_books = $conn->query($sql_library_books);
    if ($result_library_books->num_rows > 0) {
        while ($row = $result_library_books->fetch_assoc()) {
            $titles[] = $row['title'];
        }
    }

    return $titles;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            width: 72%;
            margin: 100px auto;
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: visible; /* Ensure hover effects are not clipped */
            margin-top: 30px;
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
            position: relative;
        }

        .search-bar {
            width: 55%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 25px;
            box-sizing: border-box;
            font-size: 16px;
            margin-right: 15px;
            background-color: white;
            color: black;
            outline: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .search-bar::placeholder {
            color: #999;
        }

        .suggestions-box {
            position: absolute;
            width: 56%;
            background-color: rgba(52, 152, 219, 0.9) !important;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 5;
            display: none;
            top: 100%;
            right: 0;
            margin-top: 5px;
            padding: 2px;
            margin-left: 40px;
        }
        .suggestions-box a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: white !important;
            transition: background-color 0.3s ease;
        }

        .suggestions-box a:hover {
            background-color: rgba(0, 69, 116, 0.7) !important;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links ul {
            display: flex;
            align-items: center;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .nav-links ul li {
            display: flex;
            align-items: center;
            margin-left: 30px;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }

        .nav-links ul li a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 20px;
            transition: color 0.3s ease;
            position: relative;
            z-index: 3;
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
            font-size: 30px;
            font-weight: 600;
            text-align: center;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Adjust columns to fit parent */
            gap: 20px; /* Add spacing between grid items */
            justify-items: center;
            position: relative; /* Ensure proper layering of child elements */
            z-index: 1; /* Set a base z-index for the grid */
        }

        .book-item {
            background-color: #3498db;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 218px;
            height: 210px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1; /* Ensure the book item is layered properly */
        }

        .book-item:hover {transform: translateY(-3px);
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
            display: none;
            position: absolute;
            background-color: rgb(85, 161, 212);
            color: white;
            padding: 10px;
            border-radius: 6px;
            width: 250px;
            box-sizing: border-box;
            text-align: left;
            z-index: 1000 !important; /* Ensure it appears above other elements */
            top: -50%; /* Adjust position to align properly */
            left: 0;
            margin-top: 10px;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.4);
        }

        .book-item:hover .book-details {
            display: block; /* Show details on hover */
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
            top: 100%;
            left: 0;
            background-color: #3498db;
            min-width: 150px;
            box-shadow: 0 6px 12px 0 rgba(255, 255, 255, 0.2);
            z-index: 4;
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
            border-top: 5px solid white;
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
    </style>
</head>
<body>

<header>
    <div class="header-left">
        <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
        <span class="system-title">AklatURSM Management System</span>
    </div>
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Search..." id="search-input" onkeyup="showSuggestions(this.value)">
        <div class="suggestions-box" id="suggestions-box"></div>
    </div>
    <div class="nav-links">
        <ul>
            <li>
                <img src="dashboard-icon.png" alt="Dashboard Icon" class="nav-icon">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="dropdown">
                <img src="categories-icon.png" alt="Categories Icon" class="nav-icon">
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
            <li>
                <img src="authors-icon.png" alt="Authors Icon" class="nav-icon">
                <a href="Authors.php">Authors</a>
            </li>
            <li>
                <a href="profile_account.php" class="account-icon-link">
                    <img src="account-icon.png" alt="Account Icon" class="nav-icon">
                </a>
            </li>
        </ul>
    </div>
</header>
<script>
    function showSuggestions(str) {
        console.log("showSuggestions called with:", str);

        var titles = <?php echo json_encode(getBookTitles($conn)); ?>;
        console.log("titles:", titles);

        var suggestionsBox = document.getElementById("suggestions-box");
        suggestionsBox.innerHTML = "";

        if (str.length === 0) {
            suggestionsBox.style.display = "none";
            return;
        }

        if (titles && titles.length > 0) {
            titles.forEach(function(title) {
                if (title.toLowerCase().startsWith(str.toLowerCase())) {
                    suggestionsBox.innerHTML += "<a href='#' onclick='fillSearch(\"" + title + "\")'>" + title + "</a>";
                }
            });

            suggestionsBox.style.display = "block";
        } else {
            suggestionsBox.style.display = "none";
        }
    }

    function fillSearch(value) {
        // Determine the source and book_id based on the book title
        var source = '';
        var bookId = '';

        // Check if the title exists in books table
        <?php
        $booksTitles = array();
        $sqlBooks = "SELECT id, title FROM books";
        $resultBooks = $conn->query($sqlBooks);
        if ($resultBooks->num_rows > 0) {
            while ($row = $resultBooks->fetch_assoc()) {
                $booksTitles[$row['title']] = $row['id'];
            }
        }
        echo "var bookTitlesBooks = " . json_encode($booksTitles) . ";";
        ?>
        if (bookTitlesBooks[value]) {
            source = 'books';
            bookId = bookTitlesBooks[value];
        } else {
            // Check if the title exists in library_books table
            <?php
            $libraryBooksTitles = array();
            $sqlLibraryBooks = "SELECT id, title FROM library_books";
            $resultLibraryBooks = $conn->query($sqlLibraryBooks);
            if ($resultLibraryBooks->num_rows > 0) {
                while ($row = $resultLibraryBooks->fetch_assoc()) {
                    $libraryBooksTitles[$row['title']] = $row['id'];
                }
            }
            echo "var bookTitlesLibraryBooks = " . json_encode($libraryBooksTitles) . ";";
            ?>
        if (bookTitlesLibraryBooks[value]) {
            source = 'library_books';
            bookId = bookTitlesLibraryBooks[value];
        } else {
            // Check if the title exists in author_books table
            <?php
            $authorBooksTitles = array();
            $sqlAuthorBooks = "SELECT id, title FROM author_books";
            $resultAuthorBooks = $conn->query($sqlAuthorBooks);
            if ($resultAuthorBooks->num_rows > 0) {
                while ($row = $resultAuthorBooks->fetch_assoc()) {
                    $authorBooksTitles[$row['title']] = $row['id'];
                }
            }
            echo "var bookTitlesAuthorBooks = " . json_encode($authorBooksTitles) . ";";
            ?>
            if (bookTitlesAuthorBooks[value]) {
                source = 'author_books';
                bookId = bookTitlesAuthorBooks[value];
            }
        }
    }

        // Redirect to transaction.php with book_title, source, and book_id parameters
        if (source && bookId) {
            window.location.href = 'transaction.php?book_title=' + encodeURIComponent(value) + '&source=' + source + '&book_id=' + bookId;
        } else {
            alert("Book not found!");
        }
    }
</script>

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
