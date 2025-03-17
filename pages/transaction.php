<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #add8e6;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            width: 80px;
            margin-left: 20px;
        }
        .container {
            width: 50%;
            margin: auto;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px gray;
            text-align: left;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        button:hover {
            background-color: darkblue;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
        <h2>Library Management System</h2>
    </div>

    <div class="container">
        <h2>Transaction Details</h2>
        <form id="transactionForm" method="POST" action="print.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="name">Borrower Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" required>

            <label for="student_id">Borrower ID:</label>
            <input type="text" id="student_id" name="student_id" required>

            <label for="book_id">Book Title:</label>
            <input type="text" id="book_id" name="book_id" required>

            <label for="date_borrowed">Date Borrowed:</label>
            <input type="date" id="date_borrowed" name="date_borrowed" required>

            <label for="return_date">Return Date:</label>
            <input type="date" id="return_date" name="return_date" required>

            <button type="submit">Proceed to Overview</button>
        </form>
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
        });
    </script>

</body>
</html>
