<?php
include '../validate/db.php';
session_start();

if (isset($_GET['id']) && isset($_GET['page'])) {
    $bookId = (int)$_GET['id']; // Safely parse the book ID
    $page = (int)$_GET['page']; // Get the current page

    // Try deleting from all three tables
    $tables = ['books', 'library_books', 'author_books']; // List of tables to check
    $success = false;

    foreach ($tables as $table) {
        $sql_delete = "DELETE FROM $table WHERE id = ?";
        $stmt = $conn->prepare($sql_delete);

        if (!$stmt) {
            header("Location: admin-books.php?status=error&page=$page");
            exit();
        }

        $stmt->bind_param("i", $bookId);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $success = true; // Set success flag if a record was deleted
                break; // Exit loop once a record is found and deleted
            }
        }
        $stmt->close();
    }

    // Redirect based on success or failure
    if ($success) {
        header("Location: admin-books.php?status=deleted&page=$page");
    } else {
        header("Location: admin-books.php?status=notfound&page=$page");
    }
    exit();
} else {
    header("Location: admin-books.php?status=invalid");
    exit();
}

// Close the database connection
$conn->close();
?>
