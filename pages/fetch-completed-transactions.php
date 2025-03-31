<?php
session_start();
include '../validate/db.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT transaction_id, book_title, date_borrowed, return_date, date_returned 
                            FROM transactions WHERE email = ? AND completed = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $transactions = [];
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
    echo json_encode($transactions);
} else {
    echo json_encode([]);
}
?>
