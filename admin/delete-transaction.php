<?php
// Start session and include necessary files
session_start();
require '../validate/db.php'; // Ensure this file establishes your database connection

// Validate the transaction ID parameter
if (isset($_GET['id']) && isset($_GET['page'])) {
    $transactionId = intval($_GET['id']);
    $currentPage = intval($_GET['page']);
    
    // Fetch transaction details
    $fetchTransactionSql = "SELECT book_title, source, completed FROM transactions WHERE transaction_id = ?";
    $fetchTransactionStmt = $conn->prepare($fetchTransactionSql);
    $fetchTransactionStmt->bind_param("i", $transactionId);
    $fetchTransactionStmt->execute();
    $result = $fetchTransactionStmt->get_result();

    if ($result->num_rows > 0) {
        $transaction = $result->fetch_assoc();
        
        $sourceTable = $transaction['source'];
        $bookTitle = $transaction['book_title'];
        $completed = $transaction['completed'];

        if (!$completed) {
            // Handle if the transaction is not completed
            $allowedTables = ['books', 'library_books', 'author_books'];
            if (in_array($sourceTable, $allowedTables)) {
                // Directly decrement the availability by 1 in the source table using book title
                $updateSql = "UPDATE $sourceTable SET Available = Available + 1 WHERE title = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("s", $bookTitle);
                $updateStmt->execute();
            } else {
                $_SESSION['error_msg'] = "Invalid source table.";
                header("Location: admin-transactions.php?page=" . $currentPage);
                exit();
            }
        }

        // Proceed to delete the transaction (for both completed and not completed)
        $deleteSql = "DELETE FROM transactions WHERE transaction_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $transactionId);

        if ($deleteStmt->execute()) {
            // Redirect with a success status parameter
            header("Location: admin-transactions.php?page=" . $currentPage . "&status=success");
            exit();
        } else {
            $_SESSION['error_msg'] = "Error occurred while deleting the transaction.";
            header("Location: admin-transactions.php?page=" . $currentPage);
            exit();
        }
    } else {
        $_SESSION['error_msg'] = "Transaction not found.";
        header("Location: admin-transactions.php?page=" . $currentPage);
        exit();
    }
} else {
    // Redirect if parameters are missing
    $_SESSION['error_msg'] = "Invalid request. Missing transaction ID.";
    header("Location: admin-transactions.php");
    exit();
}
?>
