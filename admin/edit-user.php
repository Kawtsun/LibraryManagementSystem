<?php
include '../validate/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $user_id = (int)$_POST['user_id'];
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $course = htmlspecialchars($_POST['course']);
    $student_id = htmlspecialchars($_POST['student_id']);

    // Validate input data
    if (empty($username) || empty($email) || empty($course) || empty($student_id)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if ($user_id <= 0) {
        die("Invalid user ID.");
    }

    // Check for duplicate username or email
    $checkSql = "SELECT * FROM users WHERE (username = ? OR email = ?) AND user_id != ?";
    $checkStmt = $conn->prepare($checkSql);
    if (!$checkStmt) {
        die("Error preparing check statement: " . $conn->error);
    }
    $checkStmt->bind_param("ssi", $username, $email, $user_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        die("Username or email already exists for another user.");
    }

    // Update the user in the database
    $sql = "UPDATE users SET username = ?, email = ?, course = ?, student_id = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing update statement: " . $conn->error);
    }
    $stmt->bind_param("ssssi", $username, $email, $course, $student_id, $user_id);

    if ($stmt->execute()) {
        // Redirect to admin-users.php with success status
        header("Location: admin-users.php?status=edited");
        exit;
    } else {
        echo "Error updating user: " . $conn->error;
    }

    // Close the statements
    $checkStmt->close();
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
