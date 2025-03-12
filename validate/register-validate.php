<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $course = $_POST['course'];
    $student_id = $_POST['student_id'];

    $errors = array();

    if (empty($username) || empty($password) || empty($email) || empty($course) || empty($student_id)) {
        array_push($errors, "All fields are required.");
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format.");
    }

    $sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        array_push($errors, "Email or username already exists.");
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: ../pages/register.php");
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, course, student_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $email, $course, $student_id);

        if ($stmt->execute()) {
            header("Location: ../pages/login.php");
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
