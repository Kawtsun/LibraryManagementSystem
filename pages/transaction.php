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

// Get book details using numeric id and source from GET parameters
if (isset($_GET['book_id']) && isset($_GET['source'])) {
    $bookId = $_GET['book_id']; // numeric id
    $source = $_GET['source'];

    if ($source === 'books') {
         $sql = "SELECT title, cover_image, author FROM books WHERE id = ?";
    } elseif ($source === 'library_books') {
         $sql = "SELECT title, cover_image FROM library_books WHERE id = ?";
    } elseif ($source === 'author_books') {
         $sql = "SELECT title, NULL as cover_image, author FROM author_books WHERE id = ?";
    } else {
         die("Invalid source.");
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
         $row = $result->fetch_assoc();
         // Use the book title from the database for display and for insertion into transactions
         $bookTitle = $row['title'];
         $bookCoverImage = $row['cover_image'];
         if (isset($row['author'])) {
              $authorName = $row['author'];
         }
    } else {
         die("Book not found.");
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
          margin: auto;
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
                    <input type="text" id="course" name="course" value="<?php echo $course; ?>" readonly>
                </div>
                <div>
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" value="<?php echo $authorName; ?>" readonly>
                </div>
            </div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" readonly>
  
            <label for="book_title">Book Title:</label>
            <input type="text" id="book_title" name="book_title" value="<?php echo $bookTitle; ?>" readonly>
            <!-- Pass the numeric id and the source via hidden fields -->
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
            <button type="submit">Proceed to Print Transaction</button>
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
