<?php
include '../validate/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = (int)$_POST['book_id'];
    $title = htmlspecialchars($_POST['title']);
    $author = isset($_POST['author']) ? htmlspecialchars($_POST['author']) : null; // Optional for library_books
    $subject = htmlspecialchars($_POST['subject']);
    $publication_year = isset($_POST['publication_year']) ? (int)$_POST['publication_year'] : null; // Optional for library_books
    $quantity = (int)$_POST['quantity'];
    $source = htmlspecialchars($_POST['source']);
    $current_page = isset($_POST['current_page']) ? (int)$_POST['current_page'] : 1; // Safely retrieve the current page

    $errors = [];

    // Validation checks
    if (empty($title) || empty($subject) || empty($quantity)) {
        $errors[] = "Title, Subject, and Quantity are required.";
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

    if (!is_numeric($quantity) || $quantity < 0) { // No upper limit for quantity
        $errors[] = "Quantity must be a valid non-negative number.";
    }

    // Duplicate title check
    $checkSql = "SELECT * FROM {$source} WHERE title = ? AND id != ?";
    $checkStmt = $conn->prepare($checkSql);
    if (!$checkStmt) {
        echo json_encode(['error' => "Error preparing duplicate check: " . $conn->error]);
        exit;
    }
    $checkStmt->bind_param("si", $title, $book_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Another book with this title already exists in the selected source.";
    }
    $checkStmt->close();

    // Return errors if any exist
    if (!empty($errors)) {
        echo json_encode(['error' => implode('<br>', $errors)]);
        exit;
    }

    // Fetch current availability from the database
    $availabilitySql = "SELECT quantity, Available FROM {$source} WHERE id = ?";
    $availabilityStmt = $conn->prepare($availabilitySql);
    $availabilityStmt->bind_param("i", $book_id);
    $availabilityStmt->execute();
    $availabilityResult = $availabilityStmt->get_result();
    $currentData = $availabilityResult->fetch_assoc();
    $currentQuantity = (int)$currentData['quantity'];
    $currentAvailable = (int)$currentData['Available'];

    // Adjust availability based on the update
    $newAvailable = ($currentAvailable === $currentQuantity) ? $quantity : $quantity - ($currentQuantity - $currentAvailable);
    $availabilityStmt->close();

    // Update the database based on source
    if ($source === 'books') {
        $sql = "UPDATE books SET title = ?, author = ?, subject = ?, publication_year = ?, quantity = ?, Available = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiiii", $title, $author, $subject, $publication_year, $quantity, $newAvailable, $book_id);
    } elseif ($source === 'library_books') {
        $sql = "UPDATE library_books SET title = ?, topic = ?, quantity = ?, Available = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $title, $subject, $quantity, $newAvailable, $book_id);
    } elseif ($source === 'author_books') {
        $sql = "UPDATE author_books SET title = ?, author = ?, subject = ?, publication_year = ?, quantity = ?, Available = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiiii", $title, $author, $subject, $publication_year, $quantity, $newAvailable, $book_id);
    }

    // Execute the update and return success or error
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'redirect' => "admin-books.php?status=edited&page=" . $current_page]);
    } else {
        echo json_encode(['error' => "Error updating book: " . $conn->error]);
    }
    $stmt->close();
}

$conn->close();
?>
