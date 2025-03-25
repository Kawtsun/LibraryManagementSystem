

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Create Account</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #4facfe, #00f2fe, #58aaf8, #3d8bfd);
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            padding: 30px;
            width: 600px;
            text-align: center;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .header {
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 10px;
            font-size: 45px;
            color: black;
        }

        p {
            font-size: 14px;
            color: rgb(0, 0, 0);
            margin-bottom: 20px;
        }

        .alert {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        /* Error Alert */
        .error {
            color: red;
            background: transparent;
        }

        /* Success Alert */
        .success {
            color: green;

        }

        .input-box {
            display: flex;
            align-items: center;
            background: #f9f9f9;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }

        .input-box i {
            margin-right: 10px;
            color: #888;
        }

        input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            padding: 8px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.5);
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Login Button Style */
        .login-btn {
            background-color: #28a745;
        }

        .login-btn:hover {
            background-color: #218838;
        }

        .btn-wrapper {
            width: 50%;
        }

        footer {
            margin-top: 20px;
            color: #fff;
            font-size: 12px;
        }

        footer a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Welcome to AklatURSM</h2>
            <p>Create your account and get started!</p>
        </div>

        <!-- PHP Display Error or Success -->
        <?php
        session_start();
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<div class='alert error'><i class='fas fa-times-circle'></i> $error</div>";
            }
            unset($_SESSION['errors']);
        }

        if (isset($_SESSION['success'])) {
            echo "<div class='alert success'><i class='fas fa-check-circle'></i> " . $_SESSION['success'] . "</div>";
        }
        ?>

        <form method="post" action="../validate/register-validate.php">
            <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-box">
                <i class="fas fa-book"></i>
                <input type="text" name="course" placeholder="Course" required>
            </div>
            <div class="input-box">
                <i class="fas fa-id-card"></i>
                <input type="text" name="student_id" placeholder="Student ID" required>
            </div>

            <!-- Button Group (Side-by-Side) -->
            <div class="button-group">
                <div class="btn-wrapper">
                    <button type="submit">Create Account</button>
                </div>
                <div class="btn-wrapper">
                    <button type="button" class="login-btn" onclick="window.location.href='login.php'">
                        <i class="fas fa-sign-in-alt"></i> Login Now
                    </button>
                </div>
            </div>
        </form>

        <footer>
            Designed by <a href="#" target="_blank">GROUP I - BSCS</a>
        </footer>
    </div>
</body>

</html>
