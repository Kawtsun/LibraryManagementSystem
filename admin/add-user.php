<?php
include '../validate/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $course = htmlspecialchars($_POST['course']);
    $student_id = htmlspecialchars($_POST['student_id']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $current_page = isset($_POST['current_page']) ? (int)$_POST['current_page'] : 1;

    // Initialize an array for errors
    $errors = [];

    // Validate input data
    if (empty($username) || empty($email) || empty($course) || empty($student_id) || empty($_POST['password'])) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Check for duplicate username, email, or student ID
    $checkSql = "SELECT * FROM users WHERE username = ? OR email = ? OR student_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    if (!$checkStmt) {
        echo json_encode(['error' => "Error preparing check statement: " . $conn->error]);
        exit;
    }
    $checkStmt->bind_param("sss", $username, $email, $student_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['username'] === $username) {
            $errors[] = "Username already exists.";
        }
        if ($row['email'] === $email) {
            $errors[] = "Email already exists.";
        }
        if ($row['student_id'] === $student_id) {
            $errors[] = "Student ID already exists.";
        }
    }

    $checkStmt->close();

    // If there are errors, return them as JSON
    if (!empty($errors)) {
        echo json_encode(['error' => implode('<br>', $errors)]); // Combine errors into a single string
        exit;
    }

    // Insert the new user into the database
    $sql = "INSERT INTO users (username, password, email, course, student_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => "Error preparing insert statement: " . $conn->error]);
        exit;
    }
    $stmt->bind_param("sssss", $username, $password, $email, $course, $student_id);

    if ($stmt->execute()) {
        // Success! Redirect with success status and current page
        echo json_encode(['success' => true, 'redirect' => "admin-users.php?status=added&page=" . $current_page]);
    } else {
        echo json_encode(['error' => "Error adding user: " . $conn->error]);
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
