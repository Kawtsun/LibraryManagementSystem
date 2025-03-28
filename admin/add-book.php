<?php
include '../validate/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $author = isset($_POST['author']) ? htmlspecialchars($_POST['author']) : null; // Optional for some sources
    $subject = htmlspecialchars($_POST['subject']);
    $publication_year = isset($_POST['publication_year']) ? (int)$_POST['publication_year'] : null; // Optional for library_books
    $quantity = (int)$_POST['quantity'];
    $source = htmlspecialchars($_POST['source']);
    $current_page = isset($_POST['current_page']) ? (int)$_POST['current_page'] : 1; // Safely retrieve current page

    $errors = [];

    // Validate required fields
    if (empty($title) || empty($subject) || empty($source) || !isset($_POST['quantity'])) {
        $errors[] = "Title, Subject, Source, and Quantity are required.";
    }

    if ($source !== 'library_books') {
        // Validate author and publication_year for non-library_books sources
        if (empty($author)) {
            $errors[] = "Author is required for this source.";
        }
        if (empty($publication_year) || $publication_year <= 0) {
            $errors[] = "Publication Year must be a valid positive number.";
        }
    } else {
        // For library_books, make sure these are null
        $author = null;
        $publication_year = null;
    }

    if (!is_numeric($quantity) || $quantity < 0) {
        $errors[] = "Quantity must be a valid non-negative number.";
    }

    $allowedSources = ['books', 'library_books', 'author_books'];
    if (!in_array($source, $allowedSources)) {
        $errors[] = "Invalid source selection.";
    }

    // Duplicate title check
    $checkSql = "SELECT * FROM {$source} WHERE title = ?";
    $checkStmt = $conn->prepare($checkSql);
    if (!$checkStmt) {
        echo json_encode(['error' => "Error preparing duplicate check statement: " . $conn->error]);
        exit;
    }
    $checkStmt->bind_param("s", $title);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "A book with this title already exists in the selected source.";
    }
    $checkStmt->close();

    // Return errors if any exist
    if (!empty($errors)) {
        echo json_encode(['error' => implode('<br>', $errors)]);
        exit;
    }

    // Insert into the appropriate table
    if ($source === 'books') {
        $sql = "INSERT INTO books (title, author, subject, publication_year, quantity, Available) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiii", $title, $author, $subject, $publication_year, $quantity, $quantity);
    } elseif ($source === 'library_books') {
        $sql = "INSERT INTO library_books (title, topic, quantity, Available) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $title, $subject, $quantity, $quantity);
    } elseif ($source === 'author_books') {
        $sql = "INSERT INTO author_books (title, author, subject, publication_year, quantity, Available) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiii", $title, $author, $subject, $publication_year, $quantity, $quantity);
    }

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'redirect' => "admin-books.php?status=added&page=" . $current_page]);
    } else {
        echo json_encode(['error' => "Error adding book: " . $conn->error]);
    }
    $stmt->close();
}
$conn->close();
?>
