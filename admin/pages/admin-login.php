<?php
session_start();

include '../../validate/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Input sanitization
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Query to validate admin credentials
    $sql = "SELECT * FROM admins WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $email;
            header("Location: admin-dashboard.php");
            exit;
        } else {
            echo "<script>alert('Invalid email or password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password.');</script>";
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
            overflow: hidden;
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
            padding: 20px;
        }

        .login-body input {
            display: block;
            width: 100%;
            padding: 12px 0px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
            <img src="../../img/LMS_logo.png" alt="Library Logo" class="logo">
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
                <label for="">Email Address</label>
                <input type="email" name="email" required>
                <label for="">Password</label>
                <input type="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>