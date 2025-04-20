<?php
session_start();
include '../validate/db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$bookTitle = "";
$bookCoverImage = "";
$email = "";
$student_id = "";
$errorMessage = "";
$name = "";
$address = "";
$contact_number = "";
$course = "";
$authorName = "";
$bookId = null; // Initialize $bookId

// Get user session details
if (isset($_SESSION['email']) && isset($_SESSION['student_id'])) {
    $email = $_SESSION['email'];
    $student_id = $_SESSION['student_id'];

    // Fetch user details from the database
    $sql = "SELECT name, address, contact_number, course FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $address = $row['address'];
        $contact_number = $row['contact_number'];
        $course = $row['course'];
    } else {
        $errorMessage = "User details not found.";
    }
}

// Get book details using book_id and source from GET parameters
if (isset($_GET['book_id']) && isset($_GET['source'])) {
    $bookIdParam = $_GET['book_id'];
    $source = $_GET['source'];
    $actualBookId = null; // Initialize $actualBookId

    echo "\n"; // Debug output

    if ($source === 'library_books') {
        if (strpos($bookIdParam, 'B-L-') === 0) {
            $actualBookId = substr($bookIdParam, 4);
        } else {
            $actualBookId = $bookIdParam; // If no prefix, use the original
        }
    } elseif ($source === 'author_books') {
        if (strpos($bookIdParam, 'B-A-') === 0) {
            $actualBookId = substr($bookIdParam, 4);
        } else {
            $actualBookId = $bookIdParam; // If no prefix, use the original
        }
    } elseif ($source === 'books') {
        if (strpos($bookIdParam, 'B-B-') === 0) {
            $actualBookId = substr($bookIdParam, 4);
        } else {
            $actualBookId = $bookIdParam; // If no prefix, use the original
        }
    }

    echo "\n"; // Debug output

    if (is_numeric($actualBookId)) {
        $bookId = $actualBookId; // Assign the extracted numeric ID

        if ($source === 'books') {
            $sql = "SELECT title, cover_image, author FROM books WHERE id = ?";
        } elseif ($source === 'library_books') {
            $sql = "SELECT title, cover_image FROM library_books WHERE id = ?";
        } elseif ($source === 'author_books') {
            $sql = "SELECT title, NULL as cover_image, author FROM author_books WHERE id = ?";
        } else {
            die("Invalid source for database query.");
        }

        echo "\n"; // Debug output

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bookId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $bookTitle = $row['title'];
            $bookCoverImage = $row['cover_image'];
            if (isset($row['author'])) {
                $authorName = $row['author'];
            }
        } else {
            die("Book not found.");
        }
    } else {
        die("Invalid Book ID format.");
    }
} else {
    die("Book ID or source is missing.");
}

// Check if the user has any incomplete transactions
$sql = "SELECT COUNT(*) FROM transactions WHERE email = ? AND completed = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($incompleteTransactions);
$stmt->fetch();
$stmt->close();

if ($incompleteTransactions > 0) {
    $sql = "SELECT COUNT(*) FROM transactions WHERE email = ? AND completed = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($bookCount);
    $stmt->fetch();
    $stmt->close();

    if ($bookCount >= 2) {
        $errorMessage = "Under AklatURSM rules, you have already borrowed the maximum of 2 books with incomplete transactions.";
    }
}

// Check book availability
if (isset($_GET['book_id']) && isset($_GET['source'])) {
    $bookIdParamAvailability = $_GET['book_id'];
    $sourceAvailability = $_GET['source'];
    $actualBookIdAvailability = null;

    if ($sourceAvailability === 'library_books') {
        if (strpos($bookIdParamAvailability, 'B-L-') === 0) {
            $actualBookIdAvailability = substr($bookIdParamAvailability, 4);
        } else {
            $actualBookIdAvailability = $bookIdParamAvailability;
        }
    } elseif ($sourceAvailability === 'author_books') {
        if (strpos($bookIdParamAvailability, 'B-A-') === 0) {
            $actualBookIdAvailability = substr($bookIdParamAvailability, 4);
        } else {
            $actualBookIdAvailability = $bookIdParamAvailability;
        }
    } elseif ($sourceAvailability === 'books') {
        if (strpos($bookIdParamAvailability, 'B-B-') === 0) {
            $actualBookIdAvailability = substr($bookIdParamAvailability, 4);
        } else {
            $actualBookIdAvailability = $bookIdParamAvailability;
        }
    }

    if (is_numeric($actualBookIdAvailability)) {
        if ($sourceAvailability === 'books') {
            $availabilitySql = "SELECT Available FROM books WHERE id = ?";
        } elseif ($sourceAvailability === 'library_books') {
            $availabilitySql = "SELECT Available FROM library_books WHERE id = ?";
        } elseif ($sourceAvailability === 'author_books') {
            $availabilitySql = "SELECT Available FROM author_books WHERE id = ?";
        }

        if (!empty($availabilitySql)) {
            $stmtAvailability = $conn->prepare($availabilitySql);
            $stmtAvailability->bind_param("i", $actualBookIdAvailability);
            $stmtAvailability->execute();
            $stmtAvailability->bind_result($availability);
            $stmtAvailability->fetch();
            $stmtAvailability->close();

            if ($availability === 0) {
                header("Location: dashboard.php?status=unavailable");
                exit();
            }
        }
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
        /* Your provided styles */
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
            position: fixed;
            top: 0;
            width: 100%;
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
            width: 90%;
            max-width: 800px;
            margin: 80px auto 10px;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: left;
            margin-top: 100px;
        }

        .book-display {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 250px;
            margin: auto;
        }

        .book-display img {
            width: 60px;
            height: 60px;
            margin-bottom: -20px;
        }

        .book-title {
            font-size: 1.2em;
            margin-bottom: 0;
            padding: 4px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: -5px;
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

        .button-row {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .button-row button {
            margin: 0 10px;
        }

        /* Style for the "Proceed to Print Transaction" button */
        .button-row button[type="submit"] {
            padding: 12px 85px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-weight: 600;
        }

        .button-row button[type="submit"]:hover {
            background-color: #2980b9;
            transform: scale(1.03);
        }

        /* Style for the "Back to Dashboard" button */
        .back-button {
            padding: 12px 25px;
            background-color: rgb(224, 50, 50);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-weight: 600;
        }

        .back-button:hover {
            background-color: rgb(163, 0, 0);
            transform: scale(1.03);
        }

        /* General button hover style */
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

        .error-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .error-modal-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            text-align: center;
        }

        .error-modal-content img {
            max-width: 150px;
            margin-bottom: -35px;
        }

        .error-modal-content h2 {
            color: #d9534f;
            margin-bottom: 15px;
        }

        .error-modal-content p {
            color: #333;
            font-size: 1.1em;
            line-height: 1.6;
        }

        .error-modal-content button {
            margin-top: -10px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            width: 250px;
        }

        .error-modal-content button:hover {
            background-color: #2980b9;
        }

        .cancel-borrowing-button {
            display: none;
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
            <img src="<?php echo $bookCoverImage ? $bookCoverImage : 'booksicon.png'; ?>" alt="Book Cover">
            <p class="book-title"><?php echo $bookTitle; ?></p>
        </div>

        <h2 style="margin-top: -2px;">Transaction Details</h2>
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
                    <input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly>
                </div>
                <div>
                    <label for="contact">Contact Number:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo $contact_number; ?>" readonly>
                </div>
            </div>
            <div class="info-row">
                <div>
                    <label for="course">Course:</label>
                    <input type="text" id="course" name="course" value="<?php
                    echo $course; ?>" readonly>
                    </div>
                    <div>
                        <label for="author">Author:</label>
                        <input type="text" id="author" name="author" value="<?php echo $authorName; ?>" readonly>
                    </div>
                </div>
                <div class="info-row">
                <div>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo $address; ?>" readonly>
                </div>
                <div>
                    <label for="book_title">Book Title:</label>
                    <input type="text" id="book_title" name="book_title" value="<?php echo $bookTitle; ?>" readonly>
                </div>
            </div>
                <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
                <input type="hidden" name="source" value="<?php echo $source; ?>">
    
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
                <div class="button-row">
                    <button type="button" class="back-button" onclick="cancelBorrowing()">Cancel Borrowing</button>
                    <button type="submit">Proceed to Print Transaction</button>
                </div>
    
                <script>
                    function cancelBorrowing() {
                        window.location.href = "Dashboard.php";
                    }
                </script>
            </form>
            <?php if (!empty($errorMessage)) { ?>
                <div id="errorModal" class="error-modal">
                    <div class="error-modal-content">
                        <img src="books-rules.png" alt="Error Icon">
                        <h2>Error!</h2>
                        <p><?php echo $errorMessage; ?></p>
                        <button onclick="location.href='dashboard.php'">Go to Dashboard</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Get the current date and time in UTC
                let now = new Date();
    
                // Adjust for Philippine Standard Time (UTC+8)
                let utcOffset = 8; // UTC+8 offset
                now.setHours(now.getHours() + utcOffset);
    
                // Format the date for input field (YYYY-MM-DD)
                let todayDate = now.toISOString().split('T')[0];
    
                let dateBorrowed = document.getElementById("date_borrowed");
                let returnDate = document.getElementById("return_date");
    
                // Set the default value for 'date_borrowed'
                dateBorrowed.value = todayDate;
                dateBorrowed.min = todayDate;
    
                // Set the min value for 'return_date' (at least today)
                returnDate.min = todayDate;
    
                <?php if (!empty($errorMessage)) { ?>
                    document.querySelector(".container").classList.add("blurred");
                    setTimeout(function() {
                        document.getElementById("errorModal").style.display = "flex";
                    }, 100);
                <?php } ?>
            });
        </script>
    </body>
    </html>