<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Create Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #98D8EF;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
            width: 500px;
        }
        .logo {
            width: 150px;
            margin-bottom: 10px;
        }
        .form-box {
            background: #98D8EF;
            padding: 20px;
            border-radius: 10px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 95%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../img/LMS_logo.png" class="logo" alt="Library Logo">
        <h2>Create Account</h2>
        <div class="form-box">
            <form method="post" action="../validate/register-validate.php">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="text" name="course" placeholder="Course" required><br>
                <input type="text" name="student_id" placeholder="Student ID" required><br>
                <button type="submit">Create</button>
            </form>
        </div>
    </div>
</body>
</html>
