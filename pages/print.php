<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
<<<<<<< HEAD
    $_SESSION["transaction_data"] = $_POST; // Store transaction data in session
=======
    $data = $_POST;

    // Insert transaction into database
    $success = insertTransaction($conn, $data);

    // Store data in session
    $_SESSION["transaction_data"] = $data; // Store the data in the session here
}

// Function to insert transaction data into the database
function insertTransaction($conn, $data) {
    $email = $data['email'];
    $student_id = $data['student_id'];
    $name = $data['name'];
    $contact_number = $data['contact'];
    $address = $data['address'];
    $book_id = $data['book_id'];
    $date_borrowed = $data['date_borrowed'];
    $return_date = $data['return_date'];
    $course = $data['course']; // Retrieve course from POST data
    $author = $data['author']; // Retrieve author from POST data

    $sql = "INSERT INTO transactions (email, student_id, name, address, contact_number, book_id, date_borrowed, return_date, course, author) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $email, $student_id, $name, $address, $contact_number, $book_id, $date_borrowed, $return_date, $course, $author);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Overview</title>
    <style>
        body {
<<<<<<< HEAD
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
            background-image: url('../img/background-transaction.jpg'); /* Replace with your image path */
            background-size: cover;
            background-repeat: no-repeat;
=======
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            background-image: url('../img/background-transaction.jpg');
            background-size: cover;
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
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
<<<<<<< HEAD
            border-radius: 0;
=======
            position: relative;
            z-index: 10;
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
        }

        .logo {
            width: 60px;
            margin-right: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 2.1em;
            font-weight: 600;
<<<<<<< HEAD
            white-space: nowrap;
=======
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
            color: white;
        }

        .container {
            width: 85%;
            max-width: 800px;
            margin: auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: left;
            border: 1px solid #e0e0f0;
        }

        .container h2 {
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 600;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .info-box {
<<<<<<< HEAD
            background-color: #e0f2fe; /* Light blue background */
=======
            background-color: #e0f2fe;
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
<<<<<<< HEAD
            border: 1px solid #cce0f5; /* Light blue border */
=======
            border: 1px solid #cce0f5;
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
            width: 48%;
            box-sizing: border-box;
        }

        .full-width-box {
<<<<<<< HEAD
            background-color: #e0f2fe; /* Light blue background */
=======
            background-color: #e0f2fe;
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
<<<<<<< HEAD
            border: 1px solid #cce0f5; /* Light blue border */
=======
            border: 1px solid #cce0f5;
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

<<<<<<< HEAD
        .info-box strong, .full-width-box strong {
=======
        .info-box strong,
        .full-width-box strong {
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
        }

<<<<<<< HEAD
        .info-box p, .full-width-box p {
=======
        .info-box p,
        .full-width-box p {
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
            color: #555;
            line-height: 1.5;
            margin: 0;
        }

        .button-container {
            text-align: center;
            margin-top: 30px;
        }

        button {
            padding: 12px 25px;
            background-color: #2ecc71;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-weight: 600;
        }

        button:hover {
            background-color: #27ae60;
            transform: scale(1.03);
        }
<<<<<<< HEAD
=======
        .message-container {
            text-align: center;
            margin-top: 20px;
            display: none; /* Initially hidden */
        }

        .success-message, .error-message {
            /* Styles for success/error messages */
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .button-row {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .back-button, .print-button {
            /* Styles for buttons */
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-weight: 600;
            margin: 10px;
        }

        .back-button:hover, .print-button:hover {
            background-color: #2980b9;
            transform: scale(1.03);
        }

        .print-button {
            background-color: red; /* Change print button to red */
        }

        .print-button:hover {
            background-color: darkred; /* Darker red on hover */
        }

        .message-content {
            display: none; /* Initially hide the message content */
        }
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
    </style>
</head>

<body>
<div class="header">
        <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
        <h2>AklatURSM Management System</h2>
    </div>
    <div class="container">
        <h2>Transaction Overview</h2>
        <?php
<<<<<<< HEAD
        if (isset($_SESSION["transaction_data"])) {
            $data = $_SESSION["transaction_data"];
=======
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $_POST;

            // Display all transaction details
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
            echo '<div class="row">';
            echo '<div class="info-box"><strong>Email:</strong><p>' . htmlspecialchars($data['email']) . '</p></div>';
            echo '<div class="info-box"><strong>Student ID:</strong><p>' . htmlspecialchars($data['student_id']) . '</p></div>';
            echo '</div>';

            echo '<div class="row">';
            echo '<div class="info-box"><strong>Borrower Name:</strong><p>' . htmlspecialchars($data['name']) . '</p></div>';
            echo '<div class="info-box"><strong>Contact Number:</strong><p>' . htmlspecialchars($data['contact']) . '</p></div>';
            echo '</div>';

<<<<<<< HEAD
            echo '<div class="full-width-box"><strong>Address:</strong><p>' . htmlspecialchars($data['address']) . '</p></div>';

=======
            // Display course and author in new rows
            echo '<div class="row">';
           echo '<div class="info-box"><strong>Course:</strong><p>' . htmlspecialchars($data['course']) . '</p></div>';
            echo '<div class="info-box"><strong>Author:</strong><p>' . htmlspecialchars($data['author']) . '</p></div>';
            echo '</div>';

            echo '<div class="full-width-box"><strong>Address:</strong><p>' . htmlspecialchars($data['address']) . '</p></div>';
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
            echo '<div class="full-width-box"><strong>Book Title:</strong><p>' . htmlspecialchars($data['book_id']) . '</p></div>';

            echo '<div class="row">';
            echo '<div class="info-box"><strong>Date Borrowed:</strong><p>' . htmlspecialchars($data['date_borrowed']) . '</p></div>';
            echo '<div class="info-box"><strong>Return Date:</strong><p>' . htmlspecialchars($data['return_date']) . '</p></div>';
            echo '</div>';
<<<<<<< HEAD
=======

            // Message Container (Initially hidden)
            echo '<div class="message-container" id="messageContainer">';
            echo '<div class="message-content" id="messageContent">';
            if ($success) {
                echo '<div class="success-message">Transaction saved successfully.</div>';
            } else {
                echo '<div class="error-message">Error saving transaction.</div>';
            }
            echo '</div>';
            echo '</div>';

            // Buttons Container (Always visible)
            echo '<div class="button-row">';
            echo '<a href="dashboard.php"><button class="back-button">Back to Dashboard</button></a>';
            echo '<form action="../validate/generate-pdf.php" method="post">';
            echo '<button type="submit" class="print-button" onclick="showMessage()">Print PDF</button>';
            echo '</form>';
            echo '</div>';
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
        }
        ?>
        <div class="button-container">
            <form action="../validate/generate-pdf.php" method="post">
                <button type="submit">Print PDF</button>
            </form>
        </div>
    </div>
<<<<<<< HEAD
=======

    <script>
        function showMessage() {
            document.getElementById("messageContent").style.display = "block";
            document.getElementById("messageContainer").style.display = "block";
        }
    </script>
>>>>>>> parent of ac23151 (Merge pull request #3 from Kawtsun/admin)
</body>
</html>