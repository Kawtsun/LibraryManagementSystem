<?php
session_start();
include '../validate/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $student_id = trim($_POST['student_id']);
    
    $errors = array();

    // Check if any field is empty
    if (empty($username) || empty($password) || empty($email) || empty($course) || empty($student_id)) {
        array_push($errors, "All fields are required.");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format.");
    }

    // Check if email, username, or student ID already exists
    $sql = "SELECT * FROM users WHERE email = ? OR username = ? OR student_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        array_push($errors, "Database query preparation failed: " . $conn->error);
    } else {
        $stmt->bind_param("sss", $email, $username, $student_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                array_push($errors, "An account with this Email, Username, or Student ID already exists.");
            }
        } else {
            array_push($errors, "Database query execution failed: " . $stmt->error);
        }
        $stmt->close();
    }

    // Redirect if errors exist
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../pages/register.php");
        exit();
    }

    // Hash password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, course, student_id) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        array_push($errors, "Database query preparation failed: " . $conn->error);
    } else {
        $stmt->bind_param("sssss", $username, $hashed_password, $email, $course, $student_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "🎉 Account created successfully! You can now log in. 🎉";
            header("Location: ../pages/login.php");
            exit();
        } else {
            array_push($errors, "Error inserting data: " . $stmt->error);
        }
        $stmt->close();
    }

    // Redirect if errors occur
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../pages/register.php");
        exit();
    }
}
?>