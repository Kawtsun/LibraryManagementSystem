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

// --- CORRECTED getRecentTransactions FUNCTION ---
function getRecentTransactions($conn, $email, $limit = 10) {
    $sql = "SELECT * FROM transactions WHERE email = ? ORDER BY date_borrowed DESC LIMIT ?"; // Use 'email'
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
// --- CORRECTED displayRecentTransactions FUNCTION ---
function displayRecentTransactions($result) {
    if ($result->num_rows > 0) {
        ?>
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Date Borrowed</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_borrowed']); ?></td>
                        <td><?php echo htmlspecialchars($row['return_date']); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    } else {
        echo "<p>No recent transactions</p>";
    }
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

if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$userEmail = $_SESSION['email'];

try {
    // Retrieve user details
    $stmt = $conn->prepare("SELECT user_id, username, password, email, course, student_id, name, contact_number, address FROM users WHERE email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Account</title>
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
            right: 0; /* Align to the left of the parent */
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
            background-color:  rgba(0, 69, 116, 0.7) !important;
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

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .modern-table th, .modern-table td {
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
            height: 30px;
        }

    .user-details {
        background-color: white; /* White background for the entire container */
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 10px;
        margin-top: -40px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for the container */
    }

    .user-details p {
        background-color: #f0f0f0; /* Light gray for detail boxes */
        color: black; /* Darker text color */
        padding: 12px;
        margin: 8px 0;
        border-radius: 6px;
        font-size: 18px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1), /* Emboss-like effect */
                    -2px -2px 5px rgba(255, 255, 255, 0.7);
    }

    .user-details strong {
        font-weight: 700;
        color: black; /* Slightly lighter text for labels */
    }

    .user-details .row {
        display: flex;
        justify-content: space-between;
    }

    .user-details .row p {
        width: 48%;
    }
     
    .profile-header {
        display: flex;
        justify-content: space-between; /* Space between title and button */
        align-items: center; /* Vertical alignment */
        margin-bottom: -130px;
    }

    .logout-button {
        background-color: #e74c3c;
        color: white;
        padding: 12px 18px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        margin-left: 1325px;
        margin-bottom: 60px;
        font-weight: bold; /* Make the text bold */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);  
    }

        .logout-button:hover {
            background-color: #c0392b; /* Darker red on hover */
        }
        .detail-item {
            display: flex;
            align-items: center;
        }

        .detail-item img {
            margin-right: 10px;
            width: 24px; /* Adjust icon size as needed */
            height: 24px;
        }
        .logout-button img {
            width: 20px; /* Adjust icon size as needed */
            height: 20px;
            margin-right: 8px; /* Add spacing between icon and text */
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
            titles.forEach(function (title) {
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
        var source = '';
        var bookId = '';

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

        if (source && bookId) {
            window.location.href = 'transaction.php?book_title=' + encodeURIComponent(value) + '&source=' + source + '&book_id=' + bookId;
        } else {
            alert("Book not found!");
        }
    }
</script>

<div class="container">
    <div class="profile-header">
        <a href="login.php" class="logout-button">Log Out</a>
    </div>
    <h2 style="font-size: 30px;">Profile Account</h2>

    <div class="user-details">
        <?php if ($user): ?>
            <p class="detail-item"><img src="user-id-icon.png" alt="User ID"><strong>User ID:</strong> <?php echo htmlspecialchars($user['user_id']); ?></p>
            <div class="row">
                <p class="detail-item"><img src="username-icon.png" alt="Username"><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p class="detail-item"><img src="student-id-icon.png" alt="Student ID"><strong>Student ID:</strong> <?php echo htmlspecialchars($user['student_id']); ?></p>
            </div>
            <div class="row">
                <p class="detail-item"><img src="course-icon.png" alt="Course"><strong>Course:</strong> <?php echo htmlspecialchars($user['course']); ?></p>
                <p class="detail-item"><img src="email-icon.png" alt="Email"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div class="row">
                <p class="detail-item"><img src="name-icon.png" alt="Name"><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                <p class="detail-item"><img src="contact-icon.png" alt="Contact Number"><strong>Contact Number:</strong> <?php echo htmlspecialchars($user['contact_number']); ?></p>
            </div>
            <p class="detail-item"><img src="address-icon.png" alt="Address"><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        <?php else: ?>
            <p>User details not found.</p>
        <?php endif; ?>
    </div>
    <section class="transaction-section">
        <h2 style="font-size: 30px; margin-top: 30px;">Recent Transactions</h2>
        <div class="transaction-grid">
            <?php
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $recentTransactions = getRecentTransactions($conn, $email, 10);
                displayRecentTransactions($recentTransactions);
            } else {
                echo "<p>Please log in to see your transactions.</p>";
            }
            ?>
        </div>
    </section>
</div>

</body>
</html>
<?php $conn->close(); ?>