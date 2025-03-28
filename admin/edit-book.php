<?php
include '../validate/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = (int) $_POST['book_id'];
    $title = htmlspecialchars($_POST['title']);
    $author = isset($_POST['author']) ? htmlspecialchars($_POST['author']) : null;
    $subject = htmlspecialchars($_POST['subject']);
    $publication_year = (int)$_POST['publication_year'];
    $quantity = (int)$_POST['quantity'];
    $source = htmlspecialchars($_POST['source']);
    $current_page = isset($_POST['current_page']) ? (int)$_POST['current_page'] : 1;

    $errors = [];

    if (empty($title) || empty($subject) || empty($publication_year) || !isset($_POST['quantity'])) {
        $errors[] = "Title, Subject, Publication Year, and Quantity are required.";
    }

    if (!is_numeric($publication_year) || $publication_year <= 0) {
        $errors[] = "Publication Year must be a valid positive number.";
    }
    
    if (!is_numeric($quantity) || $quantity < 0 || $quantity > 10) {
        $errors[] = "Quantity must be between 0 and 10.";
    }
    
    if ($book_id <= 0) {
        $errors[] = "Invalid book ID.";
    }

    if (!empty($errors)) {
        echo json_encode(['error' => implode('<br>', $errors)]);
        exit;
    }

    // Determine which table to update based on 'source'
    if ($source === 'books') {
        $sql = "UPDATE books SET title = ?, author = ?, subject = ?, publication_year = ?, quantity = ? WHERE id = ?";
    } elseif ($source === 'author_books') {
        $sql = "UPDATE author_books SET title = ?, author = ?, subject = ?, publication_year = ?, quantity = ? WHERE id = ?";
    } elseif ($source === 'library_books') {
        // For library_books, note that the subject field is actually "topic".
        $sql = "UPDATE library_books SET title = ?, topic = ?, quantity = ? WHERE id = ?";
        // Note: Publication year may not exist in library_books—adapt as necessary.
    } else {
        echo json_encode(['error' => "Invalid source."]);
        exit;
    }

    // Prepare and execute the statement. For the library_books case,
    // adjust binding parameters if a field is missing.
    if ($source === 'library_books') {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(['error' => "Error preparing update statement: " . $conn->error]);
            exit;
        }
        // Here we assume library_books does not store publication_year.
        $stmt->bind_param("ssss", $title, $subject, $quantity, $book_id); // Adjust binding as needed in your schema
    } else {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(['error' => "Error preparing update statement: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("sssiii", $title, $author, $subject, $publication_year, $quantity, $book_id);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'redirect' => "admin-books.php?status=edited&page=" . $current_page]);
    } else {
        echo json_encode(['error' => "Error updating book: " . $conn->error]);
    }
    $stmt->close();
}

$conn->close();
?>
