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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Modern font */
            margin: 0;
            padding: 0;
            background-image: url('admin-background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 450px; /* Increased container width */
            background-color: #3498db; /* Blue container background */
            border-radius: 15px; /* More rounded corners */
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.4); /* Stronger shadow */
            padding: 40px; /* Increased padding */
            text-align: center;
            color: #fff; /* White text */
            box-shadow: 0 10px 25px rgba(0, 120, 175, 0.5);
        }

        .login-logo img {
            width: 150px; /* Increased logo size */
            margin-bottom: -30px;
        }

        .login-header h1 {
            font-size: 35px; /* Larger header font */
            margin-bottom: -20px;
        }

        .login-header p {
            font-size: 20px; /* Larger paragraph font */
            margin-bottom: 40px;
        }

        .login-body input {
            width: calc(100% - 50px);
            padding: 15px; /* Increased input padding */
            margin-bottom: 15px;
            border: none;
            border-radius: 8px; /* More rounded input corners */
            background-color: rgba(255, 255, 255, 0.2); /* Transparent white input background */
            color: #fff;
            font-size: 16px;
        }

        .login-body input::placeholder {
            color: rgba(231, 231, 231, 0.7);
        }

        .login-body button {
            width: 150px; /* Reduced button width */
            padding: 15px; /* Increased button padding */
            border: none;
            border-radius: 8px; /* More rounded button corners */
            background-color: #ff9800;
            color: #fff;
            font-size: 18px; /* Larger button font */
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            margin: 0 auto; /* Center the button */
        }

        .login-body button:hover {
            background-color:rgb(245, 139, 1);
        }

        .login-body .username-icon,
        .login-body .password-icon {
            position: relative;
        }

        .login-body .username-icon::before,
        .login-body .password-icon::before {
            position: absolute;
            left: 15px; /* Increased icon spacing */
            top: 15px; /* Increased icon spacing */
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
        }

        .login-body .username-icon::before {
            content: "\f007";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
        }

        .login-body .password-icon::before {
            content: "\f023";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
        }

        .login-body label {
            color: rgba(255, 255, 255, 0.8);
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-size: 20px;
        }

        .login-body input {
            padding-left: 45px; /* Increased padding for icon space */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="login-container">
        <div class="login-logo">
            <img src="../img/LMS_logo.png" alt="Library Logo">
        </div>
        <div class="login-header">
            <h1>ADMINISTRATOR LOGIN</h1>
            <p>AklatURSM Management System</p>
        </div>
        <div class="login-body">
            <form method="POST" action="">
                <label for="username">Username</label>
                <div class="username-icon">
                    <input type="text" name="username" id="username" placeholder="username" required>
                </div>
                <label for="password">Password</label>
                <div class="password-icon">
                    <input type="password" name="password" id="password" placeholder="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>