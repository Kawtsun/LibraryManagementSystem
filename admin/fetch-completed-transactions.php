<?php
include '../validate/db.php';

// Query to fetch completed transactions
$sql = "SELECT transaction_id, email, name, book_title, date_borrowed, return_date, date_returned
        FROM transactions
        WHERE completed = 1"; // Fetch only completed transactions

$result = $conn->query($sql);

$completedTransactions = [];

// Fetch data and add it to the array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $completedTransactions[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($completedTransactions);
?>
