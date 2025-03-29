<?php
include '../validate/db.php';
session_start();

// Ensure the request method is POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Get the transaction ID from the POST request.
$transaction_id = isset($_POST['transaction_id']) ? intval($_POST['transaction_id']) : 0;
if ($transaction_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid transaction ID.']);
    exit;
}
error_log("Transaction ID received: $transaction_id");

// Retrieve the book title from the transaction.
$query = "SELECT book_title FROM transactions WHERE transaction_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    error_log("Prepare failed for transaction query: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Failed to prepare transaction query.']);
    exit;
}
$stmt->bind_param('i', $transaction_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$book_title = $row['book_title'] ?? null;
if (!$book_title) {
    error_log("Book title not found for transaction ID: $transaction_id");
    echo json_encode(['success' => false, 'message' => 'Book title not found for this transaction.']);
    exit;
}
error_log("Book title fetched: '$book_title'");

// Allowed source tables.
$allowed_sources = ['books', 'library_books', 'author_books'];

// Debug: log what is coming via POST.
$provided_source = isset($_POST['source']) ? $_POST['source'] : '';
error_log("Provided source from POST: '$provided_source'");

$source_table = null;
if ($provided_source && in_array($provided_source, $allowed_sources)) {
    // Use the front-end provided source
    $source_table = $provided_source;
    error_log("Using provided source table: $source_table");
} else {
    // Fallback: try to determine source by a case-insensitive match
    foreach ($allowed_sources as $table) {
        $checkQuery = "SELECT 1 FROM $table WHERE LOWER(title) = LOWER(?) LIMIT 1";
        $stmt = $conn->prepare($checkQuery);
        if (!$stmt) {
            error_log("Prepare failed for table $table: " . $conn->error);
            continue;
        }
        $stmt->bind_param('s', $book_title);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $source_table = $table;
            error_log("Dynamically determined source table: $source_table");
            break;
        }
        $stmt->close();
    }
}

if (!$source_table) {
    error_log("Source table not found for book title: '$book_title'");
    echo json_encode(['success' => false, 'message' => 'Book not found in any source table.']);
    exit;
}

// Update: Make sure the column for availability is correctly named.
// Adjust "Available" if your database uses that exact casing.
$updateBookQuery = "UPDATE $source_table SET Available = Available + 1 WHERE LOWER(title) = LOWER(?)";
$stmt = $conn->prepare($updateBookQuery);
if (!$stmt) {
    error_log("Prepare failed for book availability update: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Failed to prepare book availability update query.']);
    exit;
}
$stmt->bind_param('s', $book_title);
if (!$stmt->execute()) {
    error_log("Execution failed for book availability update: " . $stmt->error);
    echo json_encode(['success' => false, 'message' => 'Failed to update book availability.']);
    exit;
}
error_log("Book availability updated successfully for table: $source_table");

// Mark the transaction as complete by updating the transaction record.
$current_date = date('Y-m-d');
$updateTransactionQuery = "UPDATE transactions SET completed = 1, date_returned = ? WHERE transaction_id = ?";
$stmt = $conn->prepare($updateTransactionQuery);
if (!$stmt) {
    error_log("Prepare failed for transaction update: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Failed to prepare transaction update query.']);
    exit;
}
$stmt->bind_param('si', $current_date, $transaction_id);
if ($stmt->execute()) {
    error_log("Transaction marked as returned successfully for transaction ID: $transaction_id");
    echo json_encode(['success' => true, 'message' => 'Transaction successfully marked as returned.']);
} else {
    error_log("Execution failed for transaction update: " . $stmt->error);
    echo json_encode(['success' => false, 'message' => 'Failed to update transaction status.']);
}
$stmt->close();
$conn->close();
?>
