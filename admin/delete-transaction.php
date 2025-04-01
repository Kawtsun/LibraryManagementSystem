<?php
// Start session and include necessary files
session_start();
require '../validate/db.php'; // Ensure this file establishes your database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Validate and sanitize input parameters
    $transactionId = isset($_GET['id']) ? intval($_GET['id']) : null;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1; // Default to 1 if not provided
    // Default "completed" to false when it's missing so that incomplete transactions work properly
    $isCompleted = isset($_GET['completed']) ? filter_var($_GET['completed'], FILTER_VALIDATE_BOOLEAN) : false;

    // Validate required parameter
    if (!$transactionId) {
        throw new Exception("Missing or invalid transaction ID.");
    }

    // Fetch transaction details from DB
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

        // For incomplete transactions, update the availability in the source table
        if (!$completed && !$isCompleted) {
            $allowedTables = ['books', 'library_books', 'author_books'];
            if (in_array($sourceTable, $allowedTables)) {
                $updateSql = "UPDATE $sourceTable SET Available = Available + 1 WHERE title = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("s", $bookTitle);
                if (!$updateStmt->execute()) {
                    $_SESSION['error_msg'] = "Failed to update availability for book: $bookTitle. Error: " . $conn->error;
                    header("Location: admin-transactions.php?page=$currentPage");
                    exit();
                }
            } else {
                $_SESSION['error_msg'] = "Invalid source table.";
                header("Location: admin-transactions.php?page=$currentPage");
                exit();
            }
        }

        // Proceed to delete the transaction (applies to both completed and incomplete transactions)
        $deleteSql = "DELETE FROM transactions WHERE transaction_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $transactionId);

        if (!$deleteStmt->execute()) {
            throw new Exception("Failed to delete transaction with ID: $transactionId. Error: " . $conn->error);
        } else {
            header("Location: admin-transactions.php?page=$currentPage&status=success");
            exit();
        }
    } else {
        throw new Exception("Transaction not found with ID: $transactionId.");
    }
} catch (Exception $e) {
    // Log the error and redirect with an error message
    error_log($e->getMessage());
    $_SESSION['error_msg'] = $e->getMessage();
    header("Location: admin-transactions.php?page=" . $currentPage);
    exit();
}
?>
