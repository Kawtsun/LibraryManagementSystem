<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["transaction_data"] = $_POST; // Store transaction data in session
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
            background-image: url('../img/background-transaction.jpg'); /* Replace with your image path */
            background-size: cover;
            background-repeat: no-repeat;
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
            border-radius: 0;
        }

        .logo {
            width: 60px;
            margin-right: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 2.1em;
            font-weight: 600;
            white-space: nowrap;
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
            background-color: #e0f2fe; /* Light blue background */
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            border: 1px solid #cce0f5; /* Light blue border */
            width: 48%;
            box-sizing: border-box;
        }

        .full-width-box {
            background-color: #e0f2fe; /* Light blue background */
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            border: 1px solid #cce0f5; /* Light blue border */
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        .info-box strong, .full-width-box strong {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
        }

        .info-box p, .full-width-box p {
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
        if (isset($_SESSION["transaction_data"])) {
            $data = $_SESSION["transaction_data"];
            echo '<div class="row">';
            echo '<div class="info-box"><strong>Email:</strong><p>' . htmlspecialchars($data['email']) . '</p></div>';
            echo '<div class="info-box"><strong>Student ID:</strong><p>' . htmlspecialchars($data['student_id']) . '</p></div>';
            echo '</div>';

            echo '<div class="row">';
            echo '<div class="info-box"><strong>Borrower Name:</strong><p>' . htmlspecialchars($data['name']) . '</p></div>';
            echo '<div class="info-box"><strong>Contact Number:</strong><p>' . htmlspecialchars($data['contact']) . '</p></div>';
            echo '</div>';

            echo '<div class="full-width-box"><strong>Address:</strong><p>' . htmlspecialchars($data['address']) . '</p></div>';

            echo '<div class="full-width-box"><strong>Book Title:</strong><p>' . htmlspecialchars($data['book_id']) . '</p></div>';

            echo '<div class="row">';
            echo '<div class="info-box"><strong>Date Borrowed:</strong><p>' . htmlspecialchars($data['date_borrowed']) . '</p></div>';
            echo '<div class="info-box"><strong>Return Date:</strong><p>' . htmlspecialchars($data['return_date']) . '</p></div>';
            echo '</div>';
        }
        ?>
        <div class="button-container">
            <form action="../validate/generate-pdf.php" method="post">
                <button type="submit">Print PDF</button>
            </form>
        </div>
    </div>
</body>
</html>