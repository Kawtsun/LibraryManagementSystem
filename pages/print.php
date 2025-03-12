<?php

include '../validate/db.php';

$email = $name = $address = $contact = $student_id = $book_id = $date_borrowed = $return_date = "";
$errors = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize email
    if (empty($_POST["email"])) {
        $errors["email"] = "Email is required";
    } else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid email format";
        }
    }
    

    if (empty($_POST["name"])) {
        $errors["name"] = "Name is required";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }
    

    if (empty($_POST["address"])) {
        $errors["address"] = "Address is required";
    } else {
        $address = htmlspecialchars($_POST["address"]);
    }
    

    if (empty($_POST["contact"])) {
        $errors["contact"] = "Contact number is required";
    } else {
        $contact = htmlspecialchars($_POST["contact"]);

    }
    

    if (empty($_POST["student_id"])) {
        $errors["student_id"] = "Student ID is required";
    } else {
        $student_id = htmlspecialchars($_POST["student_id"]);
    }
    

    if (empty($_POST["book_id"])) {
        $errors["book_id"] = "Book ID is required";
    } else {
        $book_id = htmlspecialchars($_POST["book_id"]);
    }
    

    if (empty($_POST["date_borrowed"])) {
        $errors["date_borrowed"] = "Date borrowed is required";
    } else {
        $date_borrowed = htmlspecialchars($_POST["date_borrowed"]);

    }
    

    if (empty($_POST["return_date"])) {
        $errors["return_date"] = "Return date is required";
    } else {
        $return_date = htmlspecialchars($_POST["return_date"]);

    }
    

    if (empty($errors)) {

        // $servername = "localhost";
        // $username = "username";
        // $password = "password";
        // $dbname = "library";
        

        // $conn = new mysqli($servername, $username, $password, $dbname);
        

        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        
      
        $stmt = $conn->prepare("INSERT INTO transactions (email, name, address, contact_number, student_id, book_id, date_borrowed, return_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $email, $name, $address, $contact, $student_id, $book_id, $date_borrowed, $return_date);
        
        if ($stmt->execute()) {
            $transaction_id = $conn->insert_id;
            

            if (isset($_POST["print"])) {
                header("Location: print_transaction.php?id=" . $transaction_id);
                exit;
            }
            

            $email = $name = $address = $contact = $student_id = $book_id = $date_borrowed = $return_date = "";
            $success_message = "Transaction recorded successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Book Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-group {
            background-color: #a8e0ec;
            padding: 20px;
            border-radius: 5px;
        }
        .form-row {
            margin-bottom: 10px;
            display: flex;
        }
        .form-row label {
            width: 120px;
            display: inline-block;
            font-weight: bold;
        }
        .form-row input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            margin-left: 120px;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
        .btn-container {
            text-align: center;
            margin-top: 15px;
        }
        .btn-print {
            background-color: #a8e0ec;
            border: none;
            color: #000;
            padding: 8px 30px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Transaction Information</h1>
        
        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <div class="form-row">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                </div>
                <?php if (isset($errors["email"])): ?>
                    <div class="error"><?php echo $errors["email"]; ?></div>
                <?php endif; ?>
                
                <div class="form-row">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                </div>
                <?php if (isset($errors["name"])): ?>
                    <div class="error"><?php echo $errors["name"]; ?></div>
                <?php endif; ?>
                
                <div class="form-row">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo $address; ?>">
                </div>
                <?php if (isset($errors["address"])): ?>
                    <div class="error"><?php echo $errors["address"]; ?></div>
                <?php endif; ?>
                
                <div class="form-row">
                    <label for="contact">Contact Number</label>
                    <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>">
                </div>
                <?php if (isset($errors["contact"])): ?>
                    <div class="error"><?php echo $errors["contact"]; ?></div>
                <?php endif; ?>
                
                <div class="form-row">
                    <label for="student_id">Student ID</label>
                    <input type="text" id="student_id" name="student_id" value="<?php echo $student_id; ?>">
                </div>
                <?php if (isset($errors["student_id"])): ?>
                    <div class="error"><?php echo $errors["student_id"]; ?></div>
                <?php endif; ?>
                
                <div class="form-row">
                    <label for="book_id">Book ID</label>
                    <input type="text" id="book_id" name="book_id" value="<?php echo $book_id; ?>">
                </div>
                <?php if (isset($errors["book_id"])): ?>
                    <div class="error"><?php echo $errors["book_id"]; ?></div>
                <?php endif; ?>
                
                <div class="form-row">
                    <label for="date_borrowed">Date Borrowed</label>
                    <input type="date" id="date_borrowed" name="date_borrowed" value="<?php echo $date_borrowed; ?>">
                </div>
                <?php if (isset($errors["date_borrowed"])): ?>
                    <div class="error"><?php echo $errors["date_borrowed"]; ?></div>
                <?php endif; ?>
                
                <div class="form-row">
                    <label for="return_date">Return Date</label>
                    <input type="date" id="return_date" name="return_date" value="<?php echo $return_date; ?>">
                </div>
                <?php if (isset($errors["return_date"])): ?>
                    <div class="error"><?php echo $errors["return_date"]; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="btn-container">
                <button type="submit" name="print" class="btn-print">Print</button>
            </div>
        </form>
    </div>


    <script>
        document.querySelector('.btn-print').addEventListener('click', function(e) {

        });
    </script>
</body>
</html>