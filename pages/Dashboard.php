<?php
include '../validate/db.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Start the session
session_start();

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = "";
}

function getFeaturedBooks($conn, $limit = 5)
{
    $sql = "SELECT * FROM books ORDER BY id ASC LIMIT $limit";
    $result = $conn->query($sql);
    return $result;
}

// Function to fetch recently added books
function getRecentBooks($conn, $limit = 5)
{
    $sql = "SELECT * FROM books ORDER BY id DESC LIMIT $limit";
    $result = $conn->query($sql);
    return $result;
}

// Function to display books
function displayBooks($result, $source)
{
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
?>
            <div class="book-item">
                <div class="book-image-container">
                    <?php if (!empty($row['cover_image'])) { ?>
                        <img src="<?php echo htmlspecialchars($row['cover_image']); ?>" alt="Book Cover" class="book-cover">
                    <?php } else { ?>
                        <img src="booksicon.png" alt="Book Icon" class="book-icon">
                    <?php } ?>
                    <div class="book-details">
                        <p><strong>Title:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
                        <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
                        <p><strong>Publication Year:</strong> <?php echo htmlspecialchars($row['publication_year']); ?></p>
                        <p><strong>Subject:</strong> <?php echo htmlspecialchars($row['subject']); ?></p>
                    </div>
                </div>
                <p class="book-title"><?php echo htmlspecialchars($row['title']); ?></p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <input type="hidden" name="source" value="<?php echo htmlspecialchars($source); ?>">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
        <?php
        }
    } else {
        echo "<p>No books found.</p>";
    }
}

// Function to fetch top authors (you might need to adjust this based on your data)
function getTopAuthors($conn, $limit = 5)
{
    $sql = "SELECT DISTINCT author FROM books LIMIT $limit"; // Simple example, adjust as needed
    $result = $conn->query($sql);
    return $result;
}

// Function to display authors
function displayAuthors($result)
{
    $authorImages = [
        'author1.png',
        'author2.png',
        'author3.png',
        'author4.png',
        'author5.png',
        'author6.png' // Add more if needed
    ];
    $imageIndex = 0;

    while ($row = $result->fetch_assoc()) {
        if (!isset($authorImages[$imageIndex])) {
            echo "<p>Error: Not enough author images.</p>";
            return; // Stop the loop to avoid further errors
        }
        ?>
        <div class="author-item">
            <a href="author_detail.php?author=<?php echo urlencode($row['author']); ?>">
                <img src="<?php echo $authorImages[$imageIndex]; ?>" alt="Author Icon" class="author-icon">
            </a>
            <p class="author-name"><?php echo htmlspecialchars($row['author']); ?></p>
        </div>
        <?php
        $imageIndex = ($imageIndex + 1) % count($authorImages);
    }
}

// Function to fetch trending books from library_books (adjust as needed)
function getTrendingBooks($conn, $limit = 4)
{ // Modified limit to 4
    $sql = "SELECT * FROM library_books ORDER BY title ASC LIMIT $limit";
    $result = $conn->query($sql);
    return $result;
}

// Function to display trending books
function displayTrendingBooks($result)
{
    if ($result->num_rows > 0) {
        $coverImages = [ // Array for different cover images
            'advance-calculus.png', // Replace with your actual image paths
            'agriculture-books.png',
            'mito-books.png',
            'algebra-book.png'
        ];
        $imageIndex = 0; // Initialize image index

        while ($row = $result->fetch_assoc()) {
        ?>
            <div class="trending-item">
                <?php
                if (!empty($row['cover_image'])) {
                    echo '<img src="' . htmlspecialchars($row['cover_image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                } else {
                    echo '<img src="' . $coverImages[$imageIndex] . '" alt="Default Cover Image">'; // Use cover image from array
                    $imageIndex = ($imageIndex + 1) % count($coverImages); // Cycle through images
                }
                ?>
                <p><?php echo htmlspecialchars($row['title']); ?></p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <input type="hidden" name="source" value="library_books">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
        <?php
        }
    } else {
        echo "<p>No trending books found.</p>";
    }
}
function getRecentTransactions($conn, $email, $limit = 10)
{
    $sql = "SELECT * FROM transactions 
            WHERE email = ? AND completed = 0 
            ORDER BY date_borrowed DESC LIMIT ?"; // Filter for incomplete transactions
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function displayRecentTransactions($result)
{
    if ($result->num_rows > 0) {
        ?>
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Date Borrowed</th>
                    <th>Return Date</th>
                    <th>Status</th> <!-- Added column -->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_borrowed']); ?></td>
                        <td><?php echo htmlspecialchars($row['return_date']); ?></td>
                        <td>
                            <?php
                            echo $row['completed'] ? "Inactive" : "Active";
                            ?> <!-- Status based on completed -->
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
<?php
    } else {
        echo "<p>No incomplete transactions</p>";
    }
}


function getBookTitles($conn)
{
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
    <title>Library Dashboard</title>
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
            width: 75%;
            margin-top: 30px;
            margin-bottom: 30px;
            margin-left: 200px;
            background-color: #fff;
            padding: 20px;
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
            /* Increased font size */
            font-weight: 600;
            white-space: nowrap;
            /* Prevent text wrapping */
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
            /* Add a light border */
            border-radius: 25px;
            box-sizing: border-box;
            font-size: 16px;
            margin-right: 15px;
            background-color: white;
            /* White background */
            color: black;
            /* Black font color */
            outline: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .search-bar::placeholder {
            color: #999;
            /* Grey placeholder text */
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
            /* Align to the left of the parent */
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
            /* Make the link a flex container */
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
            font-size: 20px;
            font-weight: 600;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .book-item {
            background-color: #3498db;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            /* Needed for absolute positioning of details */
        }

        .book-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        }

        .book-image-container {
            position: relative;
            display: inline-block;
        }

        .book-icon,
        .book-cover {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
            display: block;
        }

        .book-details {
            display: none;
            position: absolute;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 6px;
            top: 0;
            left: 0;
            width: 100%;
            box-sizing: border-box;
            text-align: left;
            z-index: 1;
        }

        .book-item:hover .book-details {
            display: block;
        }

        .book-title {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .borrow-btn {
            background-color: #2ecc71;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s ease;
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
            /* Hide by default */
            position: absolute;
            top: 100%;
            /* Position below the parent */
            left: 0;
            /* Align to the left of the parent */
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

            /* Styles for mobile devices */
            .book-grid {
                grid-template-columns: 1fr;
                /* Stack books vertically */
            }

            .book-item {
                padding: 10px;
                /* Adjust padding */
            }

            /* Add more adjustments as needed */
        }

        .trending-section {
            background-color: rgb(0, 0, 0);
            /* Light green background */
            color: rgb(255, 255, 255);
            /* Dark green text */
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .trending-section h2 {
            margin-bottom: 15px;
            margin-top: 5px;
            font-size: 24px;
            font-weight: 600;
        }

        .trending-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .trending-item {
            text-align: center;
            font-size: 20px;
        }

        .trending-item img {
            width: 100px;
            /* Adjust as needed */
            height: auto;
            margin-bottom: -5px;
        }

        /* Add styles for Top Authors section */
        .author-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .author-item {
            text-align: center;
        }

        .author-item img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .author-name {
            font-size: 16px;
            font-weight: 600;
        }

        .container-row {
            display: flex;
            /* Enable flexbox for the row */
            width: 95%;
            margin: 30px auto;
            /* Center the row */
        }

        .book-listings {
            flex: 3;
            /* Take up more space */
        }

        .container-author {
            flex: 1;
            margin-top: -80px;
            float: none;
            background-color: rgb(0, 56, 94);
            padding: 20px;
            border-radius: 8px;
            margin-left: 200px;
            color: white;
            min-height: 400px;
            /* Add a minimum height */
            position: relative;
            z-index: 1;
            width: 300px;
        }

        .container-author h2 {
            color: white;
            text-align: center;
            margin-top: -20px;
        }

        .container-author .author-grid {
            display: grid;
            /* Use grid layout */
            grid-template-columns: repeat(2, 1fr);
            /* 3 columns */
            gap: 15px;
            /* Adjust gap as needed */
        }

        .container-author .author-grid .author-item {
            text-align: center;
        }

        .container-author .author-grid .author-item img {
            width: 120px;
            height: 120px;
            margin-bottom: -20px;
        }

        .container-author .author-grid .author-item p {
            font-size: 16px;
        }

        .container {
            width: 110%;
            /* Allow containers to adjust within the row */
            margin: 0 10px 20px 0;
            /* Add spacing between sections */
        }

        .welcome-message {
            color: #333;
            /* Dark gray text for readability */
            padding: 30px;
            margin: -50px 25px;
            /* Top and bottom margin */
            text-align: left;
            /* Align text to the left */
            float: left;
            /* Float to the left */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .welcome-message h2 {
            font-size: 2.2em;
            /* Slightly smaller than before */
            margin-bottom: -20px;
            font-weight: 600;
        }

        .welcome-message p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-top: 20px;
        }

        .transaction-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            margin-top: 50px;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            /* Ensures rounded corners work with background */
        }

        .modern-table th,
        .modern-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: white;
        }

        .modern-table th {
            background-color: rgb(0, 0, 0);
            color: white;
            font-weight: 600;
        }

        .modern-table td {
            color: black;
        }

        .modern-table tr:hover {
            background-color: #3498db;
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
            /* Increase image size */
            height: 30px;
            /* Increase image size */
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
            /* Initially hidden */
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

        .nav-links ul li a:hover {
            color: #ecf0f1;
            transform: translateY(-2px);
            /* Slight lift on hover */
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .book-details {
            display: none;
            position: absolute;
            background-color: rgb(85, 161, 212);
            color: white;
            padding: 10px;
            border-radius: 6px;
            width: 250px;
            /* Adjust as needed */
            box-sizing: border-box;
            text-align: left;
            z-index: 1000 !important;
            top: -250%;
            /* Position it below the book-item */
            left: -100%;
            /* Align with the left edge */
            margin-top: 10px;
            /* Add some space between the item and details */
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.4)
        }

        .book-item {
            position: relative;
            z-index: 1;
            /* Remove overflow: hidden if present */
        }

        .book-grid {
            /* Assuming the container is .book-grid */
            z-index: 0;
            /* Or a low z-index */
        }

        .book-item:hover .book-details {
            display: block;
        }

        /* Book Items */
        .book-item:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Borrow Button */
        .borrow-btn:hover {
            background-color: #27ae60;
            transform: scale(1.05);
            /* Slight scale on hover */
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        /* Dropdown Links */
        .dropdown-content a:hover {
            background-color: rgb(30, 90, 131);
            transition: background-color 0.3s ease;
        }

        /* Table Rows */
        .modern-table tr:hover {
            background-color: #ecf0f1;
            transition: background-color 0.3s ease;
        }

        /* Suggestions Box Links */
        .suggestions-box a:hover {
            background-color: rgba(0, 69, 116, 0.8) !important;
            transition: background-color 0.3s ease;
        }

        /*Author items*/
        .author-item img:hover {
            transform: scale(1.1);
            /* Slight scale on hover */
            transition: transform 0.3s ease;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <?php if (!empty($username)) { ?>
        <div class="welcome-message">
            <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>Explore AklatURSM and borrow books, research materials, and academic resources with just a click.</p>
        </div>
    <?php } else { ?>
        <div class="welcome-message">
            <h2>Welcome!</h2>
            <p>Explore AklatURSM and borrow books, research materials, and academic resources with just a click. Please log in to access your account.</p>
        </div>
    <?php } ?>

    <div class="container-row">
        <div class="book-listings">
            <div class="container trending-section">
                <h2 style="font-size: 30px;">Trending Books This Month</h2>
                <div class="trending-grid">
                    <?php
                    $trendingBooks = getTrendingBooks($conn, 4);
                    displayTrendingBooks($trendingBooks);
                    ?>
                </div>
            </div>

            <div class="container featured-books-section">
                <h2 style="font-size: 30px;">Featured Books</h2>
                <div class="book-grid">
                    <?php
                    $featuredBooks = getFeaturedBooks($conn, 5);
                    displayBooks($featuredBooks, 'books');
                    ?>
                </div>
            </div>

            <div class="container recent-books-section">
                <h2 style="font-size: 30px;">Recently Added Books</h2>
                <div class="book-grid">
                    <?php
                    $recentBooks = getRecentBooks($conn, 5);
                    displayBooks($recentBooks, 'books');
                    ?>
                </div>
            </div>
        </div>

        <div class="container-author">
            <section class="book-section">
                <h2 style="font-size: 30px;">Top Authors</h2>
                <div class="author-grid">
                    <?php
                    $topAuthors = getTopAuthors($conn, 6);
                    if ($topAuthors && $topAuthors->num_rows > 0) {
                        displayAuthors($topAuthors);
                    } else {
                        echo "<p>No authors found.</p>";
                    }
                    ?>
                </div>
            </section>

            <section class="transaction-section">
                <h2 style="font-size: 26px; margin-top: 30px; text-align:center">Recent Incomplete Transactions</h2>
                <div class="transaction-grid">
                    <?php
                    if (isset($_SESSION['email'])) { // Check for email in session
                        $email = $_SESSION['email'];
                        $recentTransactions = getRecentTransactions($conn, $email, 10); // Use email
                        displayRecentTransactions($recentTransactions);
                    } else {
                        echo "<p>Please log in to see your transactions.</p>";
                    }
                    ?>
                </div>
            </section>
        </div>
    </div>
    <script>
        // Alert for zero availability of books 
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'unavailable') {
                Swal.fire({
                    icon: 'error',
                    title: 'Book Not Available',
                    text: 'The selected book is currently unavailable. Please choose another.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Optional: Remove the status parameter from the URL
                    urlParams.delete('status');
                    window.history.replaceState({}, document.title, `${location.pathname}?${urlParams}`);
                });
            }
        });
    </script>
</body>

</html>