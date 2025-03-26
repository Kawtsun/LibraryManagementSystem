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
        // SQL query to check if the username exists and retrieve user details
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
                $_SESSION['email'] = $user['email']; // Add this line
                $_SESSION['student_id'] = $user['student_id']; // Add this line

                var_dump($_SESSION); // Debug: Check session values

                header('Location: getstarted.php');  // Redirect to dashboard
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
</head>
<body>
    <div class="container">
        <!-- Login Section -->
        <div class="login-container">
            <div class="login-box">
                <h1 class="welcome-text">Welcome!</h1>
                <h2>LOGIN</h2>
                
                <!-- Display error if exists -->
                <?php if (!empty($error)) : ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div class="input-box">
                        <span class="icon">👤</span>
                        <input type="text" name="username" placeholder="Username" required />
                    </div>
                    <div class="input-box">
                        <span class="icon">🔒</span>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    <button type="submit">Login</button>
                </form>
                <p>Don't have an account? <a href="register.php">Sign up</a></p>
            </div>
        </div>

        <!-- Side Box with Logo and Title -->
        <div class="side-box">
            <img src="../img/LMS_logo.png" alt="Library Logo" />
            <h3 class="aklat-title">AklatURSM</h3>
            <h3>LIBRARY MANAGEMENT SYSTEM</h3>
        </div>
    </div>
</body>
</html>
