<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $_SESSION["transaction_data"] = $_POST; // Store transaction data in session
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Overview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #add8e6;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            width: 80px;
            margin-left: 20px;
        }

        .container {
            width: 50%;
            margin: auto;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px gray;
            text-align: left;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        button:hover {
            background-color: darkgreen;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
        <h2>Library Management System</h2>
    </div>
    <div class="container">
        <h2>Transaction Overview</h2>
        <?php
        if (isset($_SESSION["transaction_data"])) {
            foreach ($_SESSION["transaction_data"] as $key => $value) {
                echo "<p><strong>" . ucfirst(str_replace("_", " ", $key)) . ":</strong> " . htmlspecialchars($value) . "</p>";
            }
        }
        ?>
        <div class="button-container">
            <form action="../validate/generate-pdf.php" method="post">
                <button type="submit">Print PDF</button>
            </form>
        </div>
    </div>

</body>

</html>