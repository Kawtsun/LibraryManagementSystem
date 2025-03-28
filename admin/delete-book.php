<?php
include '../validate/db.php';
session_start();

if (isset($_GET['id']) && isset($_GET['page'])) {
    $bookId = (int) $_GET['id']; // Safely parse the book ID

    // Delete query
    $sql_delete = "DELETE FROM books WHERE id = $bookId";

    if ($conn->query($sql_delete) === TRUE) {
        // Redirect back to the admin-books page, retaining pagination context
        $page = (int) $_GET['page'];
        header("Location: admin-books.php?status=deleted&page=$page");
        exit();
    } else {
        header("Location: admin-books.php?status=error&page=$page");
        exit();
    }
} else {
    header("Location: admin-books.php?status=invalid");
    exit();
}

$conn->close();
?>
