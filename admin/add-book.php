<?php
include '../validate/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $title = htmlspecialchars($_POST['title']);
    $author = isset($_POST['author']) ? htmlspecialchars($_POST['author']) : null;  // optional field
    $subject = htmlspecialchars($_POST['subject']);
    $publication_year = (int)$_POST['publication_year'];
    $quantity = (int)$_POST['quantity'];
    $source = htmlspecialchars($_POST['source']); // New field from the dropdown
    $current_page = isset($_POST['current_page']) ? (int)$_POST['current_page'] : 1;

    // Initialize an array for errors
    $errors = [];

    // Validate required fields
    if (empty($title) || empty($subject) || empty($source) || !isset($_POST['quantity'])) {
        $errors[] = "Title, Subject, Source, and Quantity are required.";
    }
    
    // Additional validation only if the field is enabled
    if ($source !== 'library_books') {
        if (empty($author)) {
            $errors[] = "Author is required for this source.";
        }
        if (empty($publication_year) || $publication_year <= 0) {
            $errors[] = "Publication Year must be a valid positive number.";
        }
    }

    // Validate quantity range.
    if (!is_numeric($quantity) || $quantity < 0 || $quantity > 10) {
        $errors[] = "Quantity must be between 0 and 10.";
    }
    
    // Check if the source is one of the allowed values.
    $allowedSources = ['books', 'library_books', 'author_books'];
    if (!in_array($source, $allowedSources)) {
        $errors[] = "Invalid source selection.";
    }
    
    // Optionally, check for duplicate title if needed
    if($source === 'books'){
        $checkSql = "SELECT * FROM books WHERE title = ?";
        $checkStmt = $conn->prepare($checkSql);
        if (!$checkStmt) {
            echo json_encode(['error' => "Error preparing check statement: " . $conn->error]);
            exit;
        }
        $checkStmt->bind_param("s", $title);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            $errors[] = "A book with this title already exists in the Books table.";
        }
        $checkStmt->close();
    }
    
    // If validation errors exist, return them as JSON
    if (!empty($errors)) {
        echo json_encode(['error' => implode('<br>', $errors)]);
        exit;
    }

    // Determine which table to insert into based on the 'source'
    if ($source === 'books') {
        $sql = "INSERT INTO books (title, author, subject, publication_year, quantity) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(['error' => "Error preparing insert statement for books: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("sssii", $title, $author, $subject, $publication_year, $quantity);
    
    } elseif ($source === 'library_books') {
        // For library_books, assume subject is stored as 'topic'
        $sql = "INSERT INTO library_books (title, topic, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(['error' => "Error preparing insert statement for library_books: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("ssi", $title, $subject, $quantity);
    
    } elseif ($source === 'author_books') {
        $sql = "INSERT INTO author_books (title, author, subject, publication_year, quantity) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(['error' => "Error preparing insert statement for author_books: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("sssii", $title, $author, $subject, $publication_year, $quantity);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'redirect' => "admin-books.php?status=added&page=" . $current_page]);
    } else {
        echo json_encode(['error' => "Error adding book: " . $conn->error]);
    }

    $stmt->close();
}
$conn->close();
?>
