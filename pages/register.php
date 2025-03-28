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
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 40px;
        width: 600px;
        text-align: left;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .header {
        margin-bottom: 30px;
        text-align: center;
    }

    h2 {
        margin-bottom: 10px;
        font-size: 45px;
        color: #333; /* Darker, modern text color */
    }

    p {
        font-size: 16px;
        color: #555; /* Slightly lighter text color for subtext */
        margin-bottom: 20px;
        font-weight: bold;
    }

    .alert {
        margin-bottom: 15px;
        padding: 12px;
        border-radius: 8px;
        font-weight: bold;
        text-align: center;
    }

    .error {
        color: red;
        background: rgba(255, 0, 0, 0.1);
    }

    .success {
        color: green;
        background: rgba(0, 255, 0, 0.1);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .info-row div {
        width: 48%;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333; /* Darker label text */
    }

    input {
        width: 100%;
        padding: 12px;
        margin-bottom: 10px; /* Reduced bottom margin */
        border: 1px solid #ddd;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.8);
        transition: border-color 0.3s ease;
        color: #333; /* Darker input text */
    }

    input:focus {
        border-color: #007bff;
        outline: none;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-top: 25px;
    }

    button {
        width: 100%;
        padding: 14px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

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
        margin-top: 30px;
        color: #fff;
        font-size: 14px;
        text-align: center;
    }

    footer a {
        color: #fff;
        text-decoration: underline;
    }
</style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Welcome to AklatURSM</h2>
            <p>Create your account and get started!</p>
        </div>

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
            unset($_SESSION['success']);
        }
        ?>

        <form method="post" action="../validate/register-validate.php">
            <div class="info-row">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
            </div>
            <div class="info-row">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div>
                    <label for="course">Course:</label>
                    <input type="text" id="course" name="course" placeholder="Enter course" required>
                </div>
            </div>
            <div class="info-row">
                <div>
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" placeholder="Enter student ID" required>
                </div>
                <div>
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" id="contact_number" name="contact_number" placeholder="Enter contact number" required>
                </div>
            </div>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter full name" required>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter address" required>

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