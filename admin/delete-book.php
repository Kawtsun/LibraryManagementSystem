<?php
include '../validate/db.php';
session_start();

if (isset($_GET['id']) && isset($_GET['page'])) {
    $bookId = (int)$_GET['id']; // Safely parse the book ID
    $page = (int)$_GET['page']; // Retrieve the current page

    // List of tables to check for deletion
    $tables = ['books', 'library_books', 'author_books'];
    $success = false;

    foreach ($tables as $table) {
        $sql_delete = "DELETE FROM $table WHERE id = ?";
        $stmt = $conn->prepare($sql_delete);

        if (!$stmt) {
            // Log error (optional) and redirect with an error status
            error_log("Error preparing delete statement for table $table: " . $conn->error);
            header("Location: admin-books.php?status=error&page=$page");
            exit();
        }

        $stmt->bind_param("i", $bookId);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $success = true; // A record was deleted
                break; // Exit the loop as deletion is successful
            }
        } else {
            // Log execution error (optional)
            error_log("Error executing delete statement for table $table: " . $stmt->error);
        }

        $stmt->close(); // Close the statement for the current table
    }

    // Redirect based on the outcome of the deletion
    if ($success) {
        header("Location: admin-books.php?status=deleted&page=$page");
    } else {
        header("Location: admin-books.php?status=notfound&page=$page");
    }

    exit();
} else {
    // Missing parameters in the request
    header("Location: admin-books.php?status=invalid");
    exit();
}

// Close the database connection
$conn->close();
?>
