<?php
session_start();

include '../validate/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // // Database connection
    // $host = 'localhost';
    // $user = 'root';  // Default XAMPP MySQL username
    // $password = '';  // Default XAMPP MySQL password (empty)
    // $dbname = 'library_system';  // Your database name

    // // Create a connection
    // $conn = new mysqli($host, $user, $password, $dbname);

    // // Check the connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check if the username and password are correct
    $sql = "SELECT * FROM users WHERE username = ? AND password = MD5(?)";  // MD5 for password hashing
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');  // Redirect to the dashboard
    } else {
        // Invalid login
        $error = "Invalid username or password!";
    }

    $stmt->close();
    $conn->close();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Login</title>
    <link rel="stylesheet" href="../login.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>LOGIN</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form action="Dashboard.php" method="POST">
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
