<?php
include '../validate/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $course = htmlspecialchars($_POST['course']);
    $student_id = htmlspecialchars($_POST['student_id']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Check if any field is empty
    if (empty($username) || empty($email) || empty($course) || empty($student_id)) {
        die("All fields are required.");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Check if username or email already exists
    $checkSql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        die("Username or email already exists.");
    }

    // Insert the new user into the database
    $sql = "INSERT INTO users (username, password, email, course, student_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $password, $email, $course, $student_id);

    if ($stmt->execute()) {
        // Redirect to admin-users.php with a success status
        header("Location: admin-users.php?status=added" . $current_page);
        exit;
    } else {
        echo "Error adding user: " . $conn->error;
    }

    // Close the statements
    $checkStmt->close();
    $stmt->close();
}

// Close the connection
$conn->close();
?>
