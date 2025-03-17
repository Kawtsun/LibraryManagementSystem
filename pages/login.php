<?php
session_start();

include '../validate/db.php';  // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        $error = "Username and password are required!";
    } else {
        // SQL query to check if the username exists
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch user data
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['username'] = $username;
                header('Location: dashboard.php');  // Redirect to dashboard
                exit();
            } else {
                // Invalid password
                $error = "Invalid username or password!";
            }
        } else {
            // Username not found
            $error = "Invalid username or password!";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Login</title>
    <link rel="stylesheet" href="../login.css">
    <style>
        /* Inline Style for error message */
        .error {
            color: red;  /* Red text color for errors */
            font-size: 14px;  /* Adjust font size */
            background-color: #f8d7da;  /* Light red background */
            padding: 10px;  /* Space around the text */
            border: 1px solid #f5c6cb;  /* Light red border */
            border-radius: 5px;  /* Rounded corners */
            margin-bottom: 15px;  /* Space below the error message */
            text-align: center;  /* Center the text */
        }

        /* Optional: You can also add transitions for smoother appearance */
        .error {
            transition: opacity 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>LOGIN</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form action="login.php" method="POST">
                <div class="input-box">
                    <span class="icon">&#128100;</span>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-box">
                    <span class="icon">&#128274;</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="../pages/register.php">Sign up</a></p>
        </div>
        <div class="side-box">
            <img src="../img/LMS_logo.png" alt="Library Logo">
            <h3>LIBRARY MANAGEMENT SYSTEM</h3>
        </div>
    </div>
</body>
</html>
