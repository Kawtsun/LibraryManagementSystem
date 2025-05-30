<?php
session_start();
include '../validate/db.php';
require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;

    // Generate Barcode
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    $barcode = uniqid(); // Generate a unique barcode

    // Define date_borrowed variable
    date_default_timezone_set('Asia/Manila');
    $currentTime = date('H:i:s'); // Current time in HH:MM:SS format for Philippine Time
    $date_borrowed = $data['date_borrowed'] . ' ' . $currentTime;

    // Process the transaction: insert the record and update available count.
    $success = insertTransaction($conn, $data, $barcode); // Pass barcode

    if ($success) {
        // Store transaction data in the session if needed.
        $data['book_id'] = $data['book_title'];
        $data['barcode'] = $barcode; // Store barcode in session
        $data['date_borrowed'] = $date_borrowed; // Ensure full date_borrowed is stored
        $_SESSION["transaction_data"] = $data;
    } else {
        echo "Error saving transaction.";
    }
} else {
    echo "Invalid request.";
}

/**
 * Inserts the transaction record (saving the book title and barcode) into the transactions table,
 * and then updates the available count for the book in the proper table using the numeric book ID.
 */
function insertTransaction($conn, $data, $barcode) {
    $email         = $data['email'];
    $student_id     = $data['student_id'];
    $name         = $data['name'];
    $contact_number = $data['contact'];
    $address         = $data['address'];
    $book_title     = $data['book_title'];
    date_default_timezone_set('Asia/Manila');
    $currentTime = date('H:i:s'); // Current time in HH:MM:SS format for Philippine Time
    $date_borrowed = $data['date_borrowed'] . ' ' . $currentTime;
    $return_date     = $data['return_date'];
    $course         = $data['course'];
    $author         = $data['author'];
    $source         = $data['source'];
    $book_id         = $data['book_id'];

    $conn->begin_transaction();

    try {
        $sql = "INSERT INTO transactions (email, student_id, name, address, contact_number, book_title, date_borrowed, return_date, course, author, source, barcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssssssssssss", $email, $student_id, $name, $address, $contact_number, $book_title, $date_borrowed, $return_date, $course, $author, $source, $barcode);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();

        switch ($source) {
            case 'books':
                $updateSql = "UPDATE books SET Available = IF(Available > 0, Available - 1, 0) WHERE id = ?";
                break;
            case 'library_books':
                $updateSql = "UPDATE library_books SET Available = IF(Available > 0, Available - 1, 0) WHERE id = ?";
                break;
            case 'author_books':
                $updateSql = "UPDATE author_books SET Available = IF(Available > 0, Available - 1, 0) WHERE id = ?";
                break;
            default:
                throw new Exception("Invalid source provided.");
        }
        $stmt2 = $conn->prepare($updateSql);
        if (!$stmt2) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt2->bind_param("i", $book_id);
        if (!$stmt2->execute()) {
            throw new Exception("Execute failed: " . $stmt2->error);
        }
        $stmt2->close();

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Transaction Error: " . $e->getMessage());
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Overview</title>
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
            margin-top: 120px;

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
            background-color: #e0f2fe;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            border: 1px solid #cce0f5;
            width: 48%;
            box-sizing: border-box;
        }

        .full-width-box {
            background-color: #e0f2fe;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            border: 1px solid #cce0f5;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        .info-box strong,
        .full-width-box strong {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
        }

        .info-box p,
        .full-width-box p {
            color: #555;
            line-height: 1.5;
            margin: 0;
        }

        .button-row {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }

        .back-button,
        .print-button {
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

        .back-button:hover,
        .print-button:hover {
            background-color: #2980b9;
            transform: scale(1.03);
        }

        .print-button {
            background-color: red;
        }

        .print-button:hover {
            background-color: darkred;
        }

        .message-container {
            text-align: center;
            margin-top: 20px;
            display: none;
        }

        .success-message,
        .error-message {
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

      /* Modal Styles */
      .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 300px; /* Increased top value */
        width: 100%;
        height: 100%;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        display: flex;
        align-items: center;
        justify-content: center;
    }

.modal-content {
    margin-top: 50px;
    background-color: #ffffff;
    margin: 0 auto; /* Center the modal */
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
    width: clamp(300px, 80%, 600px); /* Responsive width */
    text-align: center;
    position: relative; /* For close button positioning */
    animation: fadeIn 0.3s ease-out; /* Fade-in animation */
}

.modal-content .success-text {
    color: green;
    font-weight: bold;
    margin-top: -20px;
}

/* Close Button */
.close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    color: #aaa;
    font-size: 1.5rem;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.2s ease-in-out;
}

.close:hover,
.close:focus {
    color: #333;
    text-decoration: none;
}

/* Success Icon (Image) */
.modal-icon {
    width: clamp(50px, 20%, 100px); /* Responsive image size */
    height: auto;
    margin-bottom: -1.2rem;
}

/* Message Text */
.modal-content p {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.6;
    margin-bottom: 0;
}

/* Fade-in Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Media Query for smaller screens */
@media screen and (max-width: 480px) {
    .modal-content {
        padding: 1.5rem;
        border-radius: 0.75rem;
    }

    .modal-content p {
        font-size: 1rem;
    }

    .close {
        font-size: 1.25rem;
        top: 0.25rem;
        right: 0.25rem;
    }
}

.dashboard-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.dashboard-button:hover {
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
        <h2>Transaction Overview</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo '<div class="row">';
            echo '<div class="info-box"><strong>Email:</strong><p>' . htmlspecialchars($data['email']) . '</p></div>';
            echo '<div class="info-box"><strong>Student ID:</strong><p>' . htmlspecialchars($data['student_id']) . '</p></div>';
            echo '</div>';

            echo '<div class="row">';
            echo '<div class="info-box"><strong>Borrower Name:</strong><p>' . htmlspecialchars($data['name']) . '</p></div>';
            echo '<div class="info-box"><strong>Contact Number:</strong><p>' . htmlspecialchars($data['contact']) . '</p></div>';
            echo '</div>';

            echo '<div class="row">';
            echo '<div class="info-box"><strong>Course:</strong><p>' . htmlspecialchars($data['course']) . '</p></div>';
            echo '<div class="info-box"><strong>Author:</strong><p>' . htmlspecialchars($data['author']) . '</p></div>';
            echo '</div>';

            echo '<div class="full-width-box"><strong>Address:</strong><p>' . htmlspecialchars($data['address']) . '</p></div>';
            echo '<div class="full-width-box"><strong>Book Title:</strong><p>' . htmlspecialchars($data['book_title']) . '</p></div>';

            echo '<div class="row">';
            echo '<div class="info-box"><strong>Date Borrowed:</strong><p>' . htmlspecialchars($date_borrowed) . '</p></div>';
            echo '<div class="info-box"><strong>Return Date:</strong><p>' . htmlspecialchars($data['return_date']) . '</p></div>';
            echo '</div>';

            echo '<div class="message-container" id="messageContainer">';
            echo '<div class="message-content" id="messageContent">';
            if ($success) {
                echo '<div class="success-message">Transaction saved successfully.</div>';
            } else {
                echo '<div class="error-message">Error saving transaction.</div>';
            }
            echo '</div>';
            echo '</div>';

            echo '<div class="button-row">';
            echo '<a href="dashboard.php"><button class="back-button">Back to Dashboard</button></a>';
            echo '<form action="../validate/generate-pdf.php" method="post">';
            echo '<input type="hidden" name="source" value="' . htmlspecialchars($data['source']) . '">';
            echo '<input type="hidden" name="book_title" value="' . htmlspecialchars($data['book_title']) . '">';
            echo '<button type="submit" class="print-button">Print PDF</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
      <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <img src="Thankyou-icon.png" alt="Success Icon" class="modal-icon">
                <p><span class="success-text">Transaction completed successfully.</span><br>Thank you for using AklatURSM for your academic needs!</p>
                <a href="dashboard.php" class="dashboard-button">Back to Dashboard</a>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById("successModal");
        var printButton = document.querySelector(".print-button");
        var closeButton = document.querySelector(".close");

        modal.style.display = "none"; // Ensure modal is hidden on page load

        printButton.onclick = function() {
            modal.style.display = "block";
        };

        closeButton.onclick = function() {
            modal.style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    });
</script>
</body>

</html>