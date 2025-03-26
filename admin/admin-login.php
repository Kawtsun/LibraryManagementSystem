<?php
session_start();

include '../validate/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Manual sanitization for the username
    $username = htmlspecialchars(trim($username), ENT_QUOTES, 'UTF-8');

    // Query to validate admin credentials
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $username;
            header("Location: admin-dashboard.php");
            exit;
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 800px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        }

        .login-header {
            background-color: #98d8ef;
            /* Blue banner color */
            padding: 20px;
            text-align: center;
        }

        .login-header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 22px;
        }

        .login-body {
            padding: 15px;
        }

        .login-body input {
            display: block;
            width: calc(100% - 30px);
            /* Adjust width to stay within container padding */
            padding: 12px;
            margin: 0 auto 15px;
            /* Center the input and add space below */
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            transition: all 0.3s ease-in-out;
            box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.1);
        }


        .login-body input:focus {
            background-color: #ffffff;
            border: 1px solid #007BFF;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .login-body button {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .login-body button:hover {
            background-color: #0056b3;
        }

        .login-body label {
            display: block;
            margin: 15px 0;
            color: #737373;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
        </div>
    </header>

    <div class="login-container">
        <!-- Blue header banner -->
        <div class="login-header">
            <h1>ADMIN LOGIN</h1>
        </div>
        <!-- Login form -->
        <div class="login-body">
            <form method="POST" action="">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>