<?php
include '../validate/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $user_id = (int)$_POST['user_id'];
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $course = htmlspecialchars($_POST['course']);
    $student_id = htmlspecialchars($_POST['student_id']);
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $contact_number = htmlspecialchars($_POST['contact_number']);
    $current_page = isset($_POST['current_page']) ? (int)$_POST['current_page'] : 1; // Get current page from form

    // Initialize an array for errors
    $errors = [];

    // Validate input data
    if (empty($username) || empty($email) || empty($course) || empty($student_id) || empty($name) || empty($address) || empty($contact_number)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if ($user_id <= 0) {
        $errors[] = "Invalid user ID.";
    }

    // Check for duplicate username, email, or student ID
    $checkSql = "SELECT * FROM users WHERE (username = ? OR email = ? OR student_id = ?) AND user_id != ?";
    $checkStmt = $conn->prepare($checkSql);
    if (!$checkStmt) {
        echo json_encode(['error' => "Error preparing check statement: " . $conn->error]);
        exit;
    }
    $checkStmt->bind_param("sssi", $username, $email, $student_id, $user_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['username'] === $username) {
            $errors[] = "Username already exists for another user.";
        }
        if ($row['email'] === $email) {
            $errors[] = "Email already exists for another user.";
        }
        if ($row['student_id'] === $student_id) {
            $errors[] = "Student ID already exists for another user.";
        }
    }

    $checkStmt->close();

    // If there are errors, return them as JSON
    if (!empty($errors)) {
        echo json_encode(['error' => implode('<br>', $errors)]); // Combine errors into a single string
        exit;
    }

    // Update the user in the database
    $sql = "UPDATE users SET username = ?, email = ?, course = ?, student_id = ?, name = ?, address = ?, contact_number = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => "Error preparing update statement: " . $conn->error]);
        exit;
    }
    $stmt->bind_param("sssssssi", $username, $email, $course, $student_id, $name, $address, $contact_number, $user_id);

    if ($stmt->execute()) {
        // Success! Redirect with success status and current page
        echo json_encode(['success' => true, 'redirect' => "admin-users.php?status=edited&page=" . $current_page]);
    } else {
        echo json_encode(['error' => "Error updating user: " . $conn->error]);
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
