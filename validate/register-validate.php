<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $course = $_POST['course'];
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];

    $errors = array();

    // Check if any field is empty
    if (empty($username) || empty($_POST['password']) || empty($email) || empty($course) || empty($student_id)) {
        array_push($errors, "All fields are required.");
    }

    // Validate email format
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format.");
    }

    // Check if username or email already exists
    $sql = "SELECT * FROM users WHERE email = ? OR student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        array_push($errors, "Email or Student ID already exists.");
    }

    // Redirect if errors exist
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: ../pages/register.php");
        exit();
    } else {
         // Insert data into database
         $stmt = $conn->prepare("INSERT INTO users (username, password, email, course, student_id, name, address, contact_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
         $stmt->bind_param("ssssssss", $username, $password, $email, $course, $student_id, $name, $address, $contact_number);

        if ($stmt->execute()) {
            $_SESSION['success'] = "🎉Account created successfully! You can now log in.🎉";
            header("Location: ../pages/register.php");
            exit();
        } else {
            array_push($errors, "Error: " . $stmt->error);
            $_SESSION['errors'] = $errors;
            header("Location: ../pages/register.php");
            exit();
        }
    }
}
?>