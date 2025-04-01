<?php
// searchBooks.php

// Set the header to return JSON content.
header("Content-Type: application/json");

// Include your database connection file.
include '../validate/db.php';

// Check if the query parameter is set and not empty.
if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
    echo json_encode([]);
    exit;
}

$q = $conn->real_escape_string(trim($_GET['q']));

// Build a UNION ALL query to search for book titles in all three tables.
// You can adjust the LIMIT as necessary.
$sql = "
    (SELECT id, title, 'books' AS source
     FROM books
     WHERE title LIKE '%$q%')
    UNION ALL
    (SELECT id, title, 'author_books' AS source
     FROM author_books
     WHERE title LIKE '%$q%')
    UNION ALL
    (SELECT id, title, 'library_books' AS source
     FROM library_books
     WHERE title LIKE '%$q%')
    LIMIT 10
";

$result = $conn->query($sql);

$suggestions = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // You can include additional columns if required.
        $suggestions[] = $row;
    }
}

echo json_encode($suggestions);

$conn->close();
?>
