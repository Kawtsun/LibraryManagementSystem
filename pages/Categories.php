<?php
// categories.php
include '../validate/db.php'; // Include your database connection

// Function to fetch book titles
function getBookTitles($conn) {
    $titles = array();
    $sql = "SELECT title FROM books UNION SELECT title FROM library_books UNION SELECT title FROM author_books";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $titles[] = $row['title'];
        }
    }
    return $titles;
}

// Fetch book titles for JavaScript
$allTitles = getBookTitles($conn);
$allTitlesJson = json_encode($allTitles);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Categories</title>
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
        width: 80%;
        max-width: 1000px;
        margin: 40px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        align-self: center;
    }

        header {
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
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
            margin-left: auto;
        }

        .nav-links ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
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
            margin-top: 15px;
        }

        .book-section h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 2.2em;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .book-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Force 4 columns */
        gap: 15px;
        justify-items: center;
    }

    .book-item {
        background-color: #3498db;
        color: white;
        padding: 15px; /* Slightly smaller padding */
        border-radius: 12px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 210px; /* Smaller width */
        height: 170px; /* Smaller height */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

        .book-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .book-icon {
        width: 80px; /* Smaller icon */
        height: 80px; /* Smaller icon */
        margin-bottom: 8px; /* Slightly smaller margin */
    }

    .book-title {
        font-size: 1.2em; /* Slightly smaller title */
        font-weight: 600;
        text-decoration: none;
        color: white;
        margin-top: -15px;
    }

    .see-books-btn {
        background-color: #2ecc71;
        color: white;
        padding: 8px 25px; /* Smaller button padding */
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1em; /* Smaller button font size */
        font-weight: 600;
        transition: background-color 0.3s ease;
        text-decoration: none;
        margin-top: -80px;
    }

        .see-books-btn:hover {
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
            padding: 15px;
            width: 80%; /* Make book items wider on smaller screens */
            height: auto; /* Adjust height automatically */
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

    <div class="container">
        <section class="book-section">
            <h2>Categories</h2>
            <div class="book-grid">
                <?php
                $genres = ["Mathematics", "Science", "English", "Filipino", "TLE", "Physical Education", "Araling Panlipunan", "ESP"];
                $icons = [
                    "math-icon.png",
                    "science-icon.png",
                    "english-icon.png",
                    "filipino-icon.png",
                    "tle-icon.png",
                    "pe-icon.png",
                    "ap-icon.png",
                    "esp-icon.png"
                ];

                foreach ($genres as $index => $genre) {
                    switch ($genre) {
                        case "Mathematics":
                            $targetPage = "genre/math.php";
                            break;
                        case "Science":
                            $targetPage = "genre/science.php";
                            break;
                        case "English":
                            $targetPage = "genre/english.php";
                            break;
                        case "Filipino":
                            $targetPage = "genre/filipino.php";
                            break;
                        case "TLE":
                            $targetPage = "genre/tle.php";
                            break;
                        case "Physical Education":
                            $targetPage = "genre/physical-education.php";
                            break;
                        case "Araling Panlipunan":
                            $targetPage = "genre/ap.php";
                            break;
                        case "ESP":
                            $targetPage = "genre/esp.php";
                            break;
                        default:
                            $targetPage = "genre.php?genre=" . urlencode($genre);
                            break;
                    }

                    echo '<div class="book-item">';
                    echo '<a href="' . $targetPage . '" style="text-decoration:none;">';
                    echo '<img src="' . $icons[$index] . '" alt="' . $genre . ' Icon" class="book-icon">';
                    echo '<p class="book-title" style="color:white;">' . $genre . '</p>';
                    echo '<a href="' . $targetPage . '" class="see-books-btn">Explore Books</a>';
                    echo '</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>
    </div>

    <script>
        var allTitles = <?php echo $allTitlesJson; ?>;

        function showSuggestions(str) {
            console.log("showSuggestions called with:", str);

            var suggestionsBox = document.getElementById("suggestions-box");
            suggestionsBox.innerHTML = "";

            if (str.length === 0) {
                suggestionsBox.style.display = "none";
                return;
            }

            if (allTitles && allTitles.length > 0) {
                allTitles.forEach(function(title) {
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
            if ($resultBooks && $resultBooks->num_rows > 0) {
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
                if ($resultLibraryBooks && $resultLibraryBooks->num_rows > 0) {
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
                    if ($resultAuthorBooks && $resultAuthorBooks->num_rows > 0) {
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
                window.location.href = 'transaction.php?book_title' + encodeURIComponent(value) + '&source=' + source + '&book_id=' + bookId;
            } else {
                alert("Book not found!");
            }
        }
    </script>

</body>

</html>