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
                    // Calculate Status (same logic as admin side)
                    $returnDateTimestamp = strtotime($row['return_date']);

                    if ($returnDateTimestamp === false) {
                        $status = 'Invalid Date';
                        error_log("Invalid return_date: " . $row['return_date'] . " for transaction ID: " . $row['transaction_id']);
                    } else {
                        $nowTimestamp = time();
                        $status = ($nowTimestamp > $returnDateTimestamp) ? 'Late Return' : 'Active';
                    }
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_borrowed']); ?></td>
                        <td><?php echo htmlspecialchars($row['return_date']); ?></td>
                        <td class="<?php echo ($status === 'Late Return') ? 'late' : 'active'; ?>">
                            <?php echo htmlspecialchars($status); ?>
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
$isEditing = false; // Add a variable to track if the user is editing
$updateSuccess = false; // Add a variable to track update success

if (isset($_GET['edit']) && $_GET['edit'] == 'true') {
    $isEditing = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission
    $newUsername = $_POST['username'];
    $newName = $_POST['name'];
    $newCourse = $_POST['course'];
    $newStudentID = $_POST['student_id'];
    $newContactNumber = $_POST['contact_number'];
    $newAddress = $_POST['address'];

    try {
        $updateStmt = $conn->prepare("UPDATE users SET username = ?, name = ?, course = ?, student_id = ?, contact_number = ?, address = ? WHERE email = ?");
        $updateStmt->bind_param("sssssss", $newUsername, $newName, $newCourse, $newStudentID, $newContactNumber, $newAddress, $userEmail);
        $updateStmt->execute();

        $updateSuccess = true; // Set success flag
        $isEditing = false; // Exit edit mode
    } catch (Exception $e) {
        echo "Error updating profile: " . $e->getMessage();
    }
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
            height: 30px;
        }

        .user-details {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 10px;
            margin-top: -30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .user-details p {
            background-color: #f0f0f0;
            color: black;
            padding: 12px;
            margin: 8px 0;
            border-radius: 6px;
            font-size: 18px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1),
                -2px -2px 5px rgba(255, 255, 255, 0.7);
        }

        .user-details strong {
            font-weight: 700;
            color: black;
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
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
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
            margin-bottom: -90px;
            /* Remove bottom margin */
            margin-right: 20px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logout-button:hover {
            background-color: #c0392b;
        }

        .detail-item {
            display: flex;
            align-items: center;
        }

        .detail-item img {
            margin-right: 10px;
            width: 24px;
            /* Adjust icon size as needed */
            height: 24px;
        }

        .logout-button img {
            width: 20px;
            /* Adjust icon size as needed */
            height: 20px;
            margin-right: 8px;
            /* Add spacing between icon and text */
        }

        .edit-button {
            background-color: #3498db;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            margin-right: 10px;
            /* Space from logout button */
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: -90px;
            margin-right: 10px;
        }

        .edit-button:hover {
            background-color: #2980b9;
        }

        .user-details form p.detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .user-details form p.detail-item img {
            margin-right: 10px;
            width: 24px;
            height: 24px;
        }

        .user-details form p.detail-item input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .user-details form p.detail-item input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .user-details .button-container {
            background-color: white !important;
            /* Remove background */
            display: flex;
            /* For alignment */
            align-items: center;
            /* Vertical alignment */
        }

        .user-details .button-container button[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            /* Increase padding */
            border: none;
            border-radius: 6px;
            /* Slightly larger border radius */
            cursor: pointer;
            font-size: 18px;
            /* Increase font size */
            transition: background-color 0.3s ease;
            min-width: 120px;
            /* Set minimum width */
        }

        .user-details .button-container button[type="submit"]:hover {
            background-color: #2980b9;
        }

        .user-details .button-container a {
            background-color: #e74c3c;
            color: white;
            padding: 12px 10px;
            /* Increase padding */
            border: none;
            border-radius: 6px;
            /* Slightly larger border radius */
            cursor: pointer;
            font-size: 18px;
            /* Increase font size */
            transition: background-color 0.3s ease;
            text-decoration: none;
            margin-left: 15px;
            /* Increase margin */
            min-width: 120px;
            /* Set minimum width */
            text-align: center;
        }

        .user-details .button-container a:hover {
            background-color: #c0392b;
        }

        .update-success-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 30px;
            /* Increased padding */
            border-radius: 10px;
            /* Slightly larger border radius */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            /* Stronger shadow */
            text-align: center;
            z-index: 10;
            width: 400px;
            /* Increased width */
        }

        .update-success-popup img {
            width: 80px;
            /* Increased image size */
            height: 80px;
            /* Increased image size */
            margin-bottom: 15px;
        }

        .update-success-popup h2 {
            color: green;
            /* Green color for the heading */
            margin-bottom: -10px;
            margin-top: -20px;
        }

        .update-success-popup button {
            background-color: #4CAF50;
            /* Green color */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .update-success-popup button:hover {
            background-color: #45a049;
        }

        /* Modal Background Overlay */
        .modal {
            display: none;
            /* Initially hidden */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            /* Semi-transparent background */
            z-index: 1002;
            justify-content: center;
            align-items: center;
        }

        /* Modal Content Box */
        .modal-content {
            background-color: white;
            border-radius: 8px;
            /* Matches the transactions table border radius */
            padding: 20px;
            width: 90%;
            max-width: 1200px;
            /* Increased width for larger display */
            max-height: 80%;
            /* Restrict height to fit viewport */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            /* Matches the transactions table shadow */
            overflow: auto;
            /* Makes content scrollable if it exceeds modal height */
            position: relative;
            text-align: left;
        }

        /* Modal Close Button Styling */
        .close {
            position: absolute;
            top: 16px;
            right: 16px;
            color: #888;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #444;
            /* Darker shade for hover state */
        }

        .view-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            right: 5%;
        }

        button {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .view-button:hover {
            background-color: rgb(46, 132, 190);
            transform: scale(1.05);
        }

        /* Modal Table Styling */
        .modal-content .transactions-table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            box-shadow: none;
            /* Shadow removed to keep it clean inside modal */
            border-radius: 0;
            margin: 0;
        }

        .modal-content .transactions-table th,
        .modal-content .transactions-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f4f4f4;
        }

        .modal-content .transactions-table th {
            background-color: #007BFF;
            /* Matches table header styling */
            color: white;
            text-transform: uppercase;
        }

        .modal-content .transactions-table tr:hover {
            background-color: #f9f9f9;
        }
        .late {
    color: red !important;
    font-weight: bold;
}

.active {
    color: green !important;
    font-weight: bold;
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
            <?php if (!$isEditing): ?>
                <a href="?edit=true" class="edit-button">Edit Profile</a>
            <?php endif; ?>
            <a href="login.php" class="logout-button">Log Out</a>
        </div>
        <h2 style="font-size: 30px;">Profile Account</h2>

        <div class="user-details">
            <?php if (!$isEditing): ?>
                <?php if ($user): ?>
                    <p class="detail-item"><img src="user-id-icon.png" alt="User ID"><strong>User ID:&nbsp</strong> <?php echo htmlspecialchars($user['user_id']); ?></p>
                    <div class="row">
                        <p class="detail-item"><img src="username-icon.png" alt="Username"><strong>Username:&nbsp</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                        <p class="detail-item"><img src="student-id-icon.png" alt="Student ID"><strong>Student ID:&nbsp</strong> <?php echo htmlspecialchars($user['student_id']); ?></p>
                    </div>
                    <div class="row">
                        <p class="detail-item"><img src="course-icon.png" alt="Course"><strong>Course:&nbsp</strong> <?php echo htmlspecialchars($user['course']); ?></p>
                        <p class="detail-item"><img src="email-icon.png" alt="Email"><strong>Email:&nbsp</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    <div class="row">
                        <p class="detail-item"><img src="name-icon.png" alt="Name"><strong>Name:&nbsp</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                        <p class="detail-item"><img src="contact-icon.png" alt="Contact Number"><strong>Contact Number:&nbsp</strong> <?php echo htmlspecialchars($user['contact_number']); ?></p>
                    </div>
                    <p class="detail-item"><img src="address-icon.png" alt="Address"><strong>Address:&nbsp</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                <?php else: ?>
                    <p>User details not found.</p>
                <?php endif; ?>
            <?php else: ?>
                <form method="post">
                    <p class="detail-item">
                        <img src="username-icon.png" alt="Username">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </p>
                    <div class="row">
                        <p class="detail-item">
                            <img src="student-id-icon.png" alt="Student ID">
                            <label for="student_id">Student ID:</label>
                            <input type="text" id="student_id" name="student_id" value="<?php echo htmlspecialchars($user['student_id']); ?>">
                        </p>
                        <p class="detail-item">
                            <img src="course-icon.png" alt="Course">
                            <label for="course">Course:</label>
                            <input type="text" id="course" name="course" value="<?php echo htmlspecialchars($user['course']); ?>">
                        </p>
                    </div>
                    <div class="row">
                        <p class="detail-item">
                            <img src="email-icon.png" alt="Email">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                        </p>
                        <p class="detail-item">
                            <img src="name-icon.png" alt="Name">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </p>
                    </div>
                    <div class="row">
                        <p class="detail-item">
                            <img src="contact-icon.png" alt="Contact Number">
                            <label for="contact_number">Contact Number:</label>
                            <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($user['contact_number']); ?>">
                        </p>
                        <p class="detail-item">
                            <img src="address-icon.png" alt="Address">
                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
                        </p>
                    </div>
                    <p class="button-container">
                        <button type="submit">Save Changes</button>
                        <a href="profile_account.php">Cancel</a>
                    </p>
                </form>
            <?php endif; ?>
        </div>

        <!-- Completed Transactions Modal -->
        <div id="completedTransactionsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('completedTransactionsModal').style.display='none'">&times;</span>
                <h2>Completed Transactions</h2>
                <div id="completedTransactionsErrorMessages" class="error-box"></div> <!-- Error messages -->
                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Book Title</th>
                            <th>Date Borrowed</th>
                            <th>Return Date</th>
                            <th>Date Returned</th>
                        </tr>
                    </thead>
                    <tbody id="completedTransactionsBody">
                        <!-- Dynamic rows will be injected here -->
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            // Open Completed Transactions Modal and Load Data
            document.addEventListener("DOMContentLoaded", function() {
                const completedTransactionsModal = document.getElementById('completedTransactionsModal');
                const completedTransactionsBody = document.getElementById('completedTransactionsBody');

                // Function to open the modal
                window.openCompletedTransactionsModal = function() {
                    if (!completedTransactionsModal) {
                        console.error("Completed Transactions modal element not found");
                        return;
                    }

                    // Show the modal
                    completedTransactionsModal.style.display = "flex";

                    // Dynamically load completed transactions
                    loadCompletedTransactions();
                };

                // Function to fetch and load completed transaction data
                function loadCompletedTransactions() {
                    fetch('fetch-completed-transactions.php') // Replace with your backend file path
                        .then(response => response.json())
                        .then(data => {
                            completedTransactionsBody.innerHTML = ''; // Clear previous content

                            if (data.length > 0) {
                                data.forEach(transaction => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                                <td>${transaction.transaction_id}</td>
                                <td>${transaction.book_title}</td>
                                <td>${transaction.date_borrowed}</td>
                                <td>${transaction.return_date}</td>
                                <td>${transaction.date_returned}</td>
                            `;
                                    completedTransactionsBody.appendChild(row);
                                });
                            } else {
                                completedTransactionsBody.innerHTML = '<tr><td colspan="5" style="text-align:center;">No completed transactions found.</td></tr>';
                            }
                        })
                        .catch(error => console.error('Error loading completed transactions:', error));
                }

                // Bind click event to the button for opening the modal
                const openButton = document.getElementById('openCompletedTransactions');
                if (openButton) {
                    openButton.addEventListener("click", function() {
                        openCompletedTransactionsModal();
                    });
                }

                // Close modal when clicking on any element with the `.close` class
                document.querySelectorAll('#completedTransactionsModal .close').forEach(function(closeBtn) {
                    closeBtn.addEventListener("click", function() {
                        completedTransactionsModal.style.display = "none";
                    });
                });

                // Close the modal if clicking outside its content
                window.addEventListener("click", function(event) {
                    if (event.target === completedTransactionsModal) {
                        completedTransactionsModal.style.display = "none";
                    }
                });
            });
        </script>

        <section class="transaction-section">
            <h2 style="font-size: 30px; margin-top: 30px;">Recent Incomplete Transactions</h2>
            <!-- Button styled to align on the right end side -->
            <div class="button-container" style="text-align: right; margin-top: 20px;">
                <button id="openCompletedTransactions" class="view-button">Completed Transactions</button>
            </div>
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

        <?php if ($updateSuccess): ?>
            <div class="update-success-popup">
                <img src="success-icon.png" alt="Success">
                <h2>Profile Updated</h2>
                <p>Your details have been successfully updated!</p>
                <button onclick="window.location.href='profile_account.php'">CONTINUE</button>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>
<?php $conn->close(); ?>