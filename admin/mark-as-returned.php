<?php
include '../validate/db.php';
session_start();

// Ensure the request method is POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Retrieve and validate the transaction ID.
$transaction_id = isset($_POST['transaction_id']) ? intval($_POST['transaction_id']) : 0;
if ($transaction_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid transaction ID.']);
    exit;
}

$conn->begin_transaction();

try {
    // Fetch the transaction details (including source).
    $query = "SELECT book_title, author, source FROM transactions WHERE transaction_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Failed to prepare transaction query: " . $conn->error);
    }
    $stmt->bind_param('i', $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (!$row) {
        throw new Exception("Transaction not found for ID: $transaction_id");
    }

    // Retrieve transaction details.
    $book_title = trim($row['book_title']);
    $author = isset($row['author']) ? trim($row['author']) : null;
    $source = isset($row['source']) ? strtolower(trim($row['source'])) : null;

    if (empty($book_title) || empty($source)) {
        throw new Exception("Transaction record is missing necessary data (book title or source).");
    }

    // Validate the source against allowed tables.
    $allowed_sources = ['books', 'author_books', 'library_books'];
    if (!in_array($source, $allowed_sources)) {
        throw new Exception("Invalid source provided in transaction: $source");
    }

    // Normalize the title and author for matching.
    $norm_title = strtolower($book_title);
    $norm_author = !empty($author) ? strtolower($author) : '';

    // Update book availability.
    if ($source === 'library_books') {
        // Match by title only for library_books.
        $updateQuery = "UPDATE $source SET Available = Available + 1 WHERE LOWER(TRIM(title)) = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        if (!$stmtUpdate) {
            throw new Exception("Failed to prepare update query for $source: " . $conn->error);
        }
        $stmtUpdate->bind_param('s', $norm_title);
    } else {
        // Match by title and author for books and author_books.
        $updateQuery = "UPDATE $source SET Available = Available + 1 WHERE LOWER(TRIM(title)) = ? AND LOWER(TRIM(author)) = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        if (!$stmtUpdate) {
            throw new Exception("Failed to prepare update query for $source: " . $conn->error);
        }
        $stmtUpdate->bind_param('ss', $norm_title, $norm_author);
    }

    if (!$stmtUpdate->execute()) {
        throw new Exception("Execution failed for updating availability in $source: " . $stmtUpdate->error);
    }
    if ($stmtUpdate->affected_rows === 0) {
        throw new Exception("No matching book record updated in $source. Verify the title and author.");
    }
    $stmtUpdate->close();

    // Mark the transaction as returned.
    date_default_timezone_set('Asia/Manila'); // Set timezone to Philippine Standard Time
    $current_date_time = date('Y-m-d H:i:s'); // Get the current date and time

    $updateQuery = "UPDATE transactions SET completed = 1, date_returned = ? WHERE transaction_id = ?";
    $stmt = $conn->prepare($updateQuery);
    if (!$stmt) {
        throw new Exception("Failed to prepare query: " . $conn->error);
    }
    $stmt->bind_param('si', $current_date_time, $transaction_id);
    if (!$stmt->execute()) {
        throw new Exception("Query execution failed: " . $stmt->error);
    }

    // Commit the transaction.
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Transaction successfully marked as returned.']);
} catch (Exception $e) {
    $conn->rollback();
    error_log("Error marking transaction as returned: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

$conn->close();
