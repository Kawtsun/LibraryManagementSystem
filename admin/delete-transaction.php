<?php
// Start session and include necessary files
session_start();
require '../validate/db.php'; // Ensure this file establishes your database connection

// Validate the transaction ID parameter
if (isset($_GET['id']) && isset($_GET['page'])) {
    $transactionId = intval($_GET['id']);
    $currentPage = intval($_GET['page']);
    
    // Prepare the SQL query for deletion
    $sql = "DELETE FROM transactions WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transactionId);
    
    if ($stmt->execute()) {
        // On successful deletion, redirect back to the transaction page with pagination context
        $_SESSION['success_msg'] = "Transaction deleted successfully.";
        header("Location: admin-transactions.php?page=" . $currentPage);
        exit();
    } else {
        // Handle errors during deletion
        $_SESSION['error_msg'] = "Error occurred while deleting the transaction.";
        header("Location: admin-transactions.php?page=" . $currentPage);
        exit();
    }
} else {
    // Redirect back if required parameters are missing
    $_SESSION['error_msg'] = "Invalid request. Missing transaction ID.";
    header("Location: admin-transactions.php");
    exit();
}
?>
