<?php
include '../validate/db.php';
session_start();

// Ensure that the request method is POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Retrieve the transaction ID from POST.
$transaction_id = isset($_POST['transaction_id']) ? intval($_POST['transaction_id']) : 0;
if ($transaction_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid transaction ID.']);
    exit;
}

$conn->begin_transaction();

try {
    // Retrieve the transaction details (book_title and author) from the transactions table.
    $query = "SELECT book_title, author FROM transactions WHERE transaction_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed for transaction query: " . $conn->error);
    }
    $stmt->bind_param('i', $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (!$row) {
        throw new Exception("Transaction not found for ID: $transaction_id");
    }
    $book_title = $row['book_title'] ?? null;
    $author     = $row['author'] ?? null;
    if (!$book_title) {
        throw new Exception("Incomplete transaction data; book title is missing.");
    }
    error_log("Transaction details retrieved: book_title='$book_title', author='$author'");

    // Normalize the book title and author (if provided).
    $normalized_title  = strtolower(trim($book_title));
    $normalized_author = ($author !== null) ? strtolower(trim($author)) : '';

    // Determine the source table dynamically.
    // Allowed source tables: books, author_books, library_books.
    $source_table = null;

    // If an author is provided, try to find the book in the 'books' table.
    if (!empty($normalized_author)) {
        $queryBooks = "SELECT 1 FROM books WHERE TRIM(LOWER(title)) = ? AND TRIM(LOWER(author)) = ? LIMIT 1";
        $stmtBooks = $conn->prepare($queryBooks);
        if ($stmtBooks) {
            $stmtBooks->bind_param('ss', $normalized_title, $normalized_author);
            $stmtBooks->execute();
            $resultBooks = $stmtBooks->get_result();
            if ($resultBooks && $resultBooks->num_rows > 0) {
                $source_table = 'books';
            }
            $stmtBooks->close();
        }
    }
    
    // If not found in books, and an author is provided, try author_books.
    if (!$source_table && !empty($normalized_author)) {
        $queryAuthorBooks = "SELECT 1 FROM author_books WHERE TRIM(LOWER(title)) = ? AND TRIM(LOWER(author)) = ? LIMIT 1";
        $stmtAuthBooks = $conn->prepare($queryAuthorBooks);
        if ($stmtAuthBooks) {
            $stmtAuthBooks->bind_param('ss', $normalized_title, $normalized_author);
            $stmtAuthBooks->execute();
            $resultAuthBooks = $stmtAuthBooks->get_result();
            if ($resultAuthBooks && $resultAuthBooks->num_rows > 0) {
                $source_table = 'author_books';
            }
            $stmtAuthBooks->close();
        }
    }
    
    // If still not found (or if no author was provided), try library_books using title only.
    if (!$source_table) {
        $queryLibrary = "SELECT 1 FROM library_books WHERE TRIM(LOWER(title)) = ? LIMIT 1";
        $stmtLibrary = $conn->prepare($queryLibrary);
        if ($stmtLibrary) {
            $stmtLibrary->bind_param('s', $normalized_title);
            $stmtLibrary->execute();
            $resultLibrary = $stmtLibrary->get_result();
            if ($resultLibrary && $resultLibrary->num_rows > 0) {
                $source_table = 'library_books';
            }
            $stmtLibrary->close();
        }
    }
    
    if (!$source_table) {
        throw new Exception("Book not found in any source table.");
    }
    
    error_log("Determined source table: $source_table");

    // Update book availability.
    // For library_books, match on title only.
    // For books or author_books, match on both title and author.
    if ($source_table === 'library_books') {
        $updateQuery = "UPDATE $source_table SET Available = Available + 1 WHERE TRIM(LOWER(title)) = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        if (!$stmtUpdate) {
            throw new Exception("Prepare failed for availability update in library_books: " . $conn->error);
        }
        $stmtUpdate->bind_param('s', $normalized_title);
    } else {
        $updateQuery = "UPDATE $source_table SET Available = Available + 1 WHERE TRIM(LOWER(title)) = ? AND TRIM(LOWER(author)) = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        if (!$stmtUpdate) {
            throw new Exception("Prepare failed for availability update in $source_table: " . $conn->error);
        }
        $stmtUpdate->bind_param('ss', $normalized_title, $normalized_author);
    }
    
    if (!$stmtUpdate->execute()) {
        throw new Exception("Execution failed for availability update: " . $stmtUpdate->error);
    }
    if ($stmtUpdate->affected_rows === 0) {
        throw new Exception("No matching book record updated in $source_table.");
    }
    $stmtUpdate->close();
    error_log("Book availability updated successfully in table: $source_table");

    // Mark the transaction as returned.
    $current_date = date('Y-m-d');
    $updateTransQuery = "UPDATE transactions SET completed = 1, date_returned = ? WHERE transaction_id = ?";
    $stmtTrans = $conn->prepare($updateTransQuery);
    if (!$stmtTrans) {
        throw new Exception("Prepare failed for transaction update: " . $conn->error);
    }
    $stmtTrans->bind_param('si', $current_date, $transaction_id);
    if (!$stmtTrans->execute()) {
        throw new Exception("Execution failed for transaction update: " . $stmtTrans->error);
    }
    if ($stmtTrans->affected_rows === 0) {
        throw new Exception("No transaction record updated for transaction id: $transaction_id.");
    }
    $stmtTrans->close();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Transaction successfully marked as returned.']);
    
} catch (Exception $e) {
    $conn->rollback();
    error_log("Error marking transaction as returned: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

$conn->close();
?>
