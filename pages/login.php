<?php
session_start();
include '../validate/db.php';
include 'email-ban.php'; // Include email functions

require '../PHPMailer-master/PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/PHPMailer-master/src/SMTP.php';

$error = ""; // Initialize error message
$banned_on_login = false; // Flag to indicate if banned during this login attempt

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Username and password are required!";
    } else {
        $sql_user = "SELECT * FROM users WHERE username = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param('s', $username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Check if the user should be banned due to overdue books
                if ($user['ban_status'] != 'banned') {
                    if (checkAndBanUser($conn, $user['email'], $user['username'], $user['email'])) {
                        $error = "Account Banned";
                        $_SESSION['banned_username'] = $username;
                        $banned_on_login = true; // Set the flag
                    } else {
                        // Proceed with login if not banned
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['student_id'] = $user['student_id']; // Assuming student_id might be used elsewhere
                        header('Location: getstarted.php');
                        exit();
                    }
                } else {
                    // User is already banned
                    if (new DateTime() < new DateTime($user['ban_expiry_date'])) {
                        $error = "Account Banned";
                        $_SESSION['banned_username'] = $username;
                    } else {
                        // Ban expired, reactivate user
                        $update_status_sql = "UPDATE users SET ban_status = 'active', ban_reason = NULL, ban_expiry_date = NULL WHERE username = ?";
                        $update_status_stmt = $conn->prepare($update_status_sql);
                        $update_status_stmt->bind_param('s', $username);
                        $update_status_stmt->execute();

                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['student_id'] = $user['student_id']; // Assuming student_id might be used elsewhere
                        header('Location: getstarted.php');
                        exit();
                    }
                }
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Invalid username or password!";
        }

        $stmt_user->close();
    }
}

// Function to check for overdue books for the current user (identified by email) and ban if necessary
function checkAndBanUser($conn, $user_email, $username, $email) {
    $five_days_ago = date('Y-m-d', strtotime('-5 days')); // Calculate the date 5 days ago
    $sql_transactions = "SELECT t.transaction_id, t.return_date
                               FROM `libarry`.`transactions` t
                               WHERE t.email = ? AND t.return_date <= ? AND t.date_returned IS NULL";
    $stmt_transactions = $conn->prepare($sql_transactions);
    $stmt_transactions->bind_param('ss', $user_email, $five_days_ago);
    $stmt_transactions->execute();
    $result_transactions = $stmt_transactions->get_result();

    if ($result_transactions->num_rows > 0) {
        // User has at least one book whose return date was 5 or more days ago
        $ban_expiry_date = date('Y-m-d H:i:s', strtotime('+3 days')); // Ban for 3 days
        $ban_reason_text = "Account banned due to a book(s) being overdue for 5 or more days (return date(s): ";
        $return_dates = [];
        while ($row = $result_transactions->fetch_assoc()) {
            $return_dates[] = $row['return_date'];
        }
        $ban_reason_text .= implode(', ', $return_dates) . ").";

        $update_sql_user = "UPDATE users SET ban_status = 'banned', ban_reason = ?, ban_expiry_date = ? WHERE email = ?";
        $update_stmt_user = $conn->prepare($update_sql_user);
        $update_stmt_user->bind_param('sss', $ban_reason_text, $ban_expiry_date, $user_email);
        $update_stmt_user->execute();

        include 'email-ban.php';
        send_ban_email($email, $username, $ban_reason_text, $ban_expiry_date);

        return true; // User has been banned
    }
    return false; // User is not banned
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Login</title>
    <link rel="stylesheet" href="../login.css">
    <style>
    .modal {
        display: none; /* Hidden by default */
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
        position: fixed;
        z-index: 1001;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6); /* Slightly darker background overlay */
    }

    /* Styles for the modal content */
    .modal-content {
        background-color: #fff;
        border-radius: 8px; /* Modern rounded corners */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
        padding: 20px; /* Reduced padding */
        width: auto; /* Adjust width to content */
        max-width: 80%; /* Slightly reduced max width */
        text-align: center; /* Center all text content */
        position: relative;
    }

    /* Close button styling */
    .close {
        color: #aaa;
        font-size: 20px; /* Slightly smaller close button */
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s ease-in-out;
        position: absolute !important;
        top: 10px !important; /* Align to the top */
        right: 10px !important; /* Align to the right */
        margin: 0 !important; /* Remove any margins that might affect positioning */
        z-index: 1002 !important;
        float: none !important; /* Override float property */
    }


    .close:hover,
    .close:focus {
        color: #333;
        opacity: 1;
    }

    /* Account banned icon styling */
    .ban-icon-container {
        margin-bottom: 15px; /* Reduced spacing below icon */
    }

    .ban-icon {
        width: 60px; /* Reduced icon size */
        height: 60px; /* Reduced icon size */
        /* Center the icon within its container if needed */
        margin: 0 auto;
        display: block;
    }

    /* Heading style */
    .modal-content h2 {
        color: #e74c3c; /* Red for emphasis */
        margin-bottom: 10px; /* Reduced spacing below heading */
        font-size: 22px; /* Slightly smaller heading */
        font-weight: 600; /* Semi-bold */
    }

    /* Paragraph text style */
    .modal-content p {
        color: #555;
        line-height: 1.4; /* Slightly tighter line height */
        margin-bottom: 8px; /* Reduced spacing below paragraphs */
        font-size: 14px; /* Slightly smaller font size */
    }

    /* Countdown timer style */
    #countdown {
        color: #c0392b; /* Darker red for countdown */
        font-weight: bold;
        font-size: 16px; /* Slightly smaller countdown */
    }

    /* Style for the reason text */
    #banReason {
        font-style: italic;
        color: #777;
        font-size: 13px; /* Slightly smaller reason text */
    }

    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-box">
                <h1 class="welcome-text">Welcome!</h1>
                <h2>LOGIN</h2>

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

        <div class="side-box">
            <img src="../img/LMS_logo.png" alt="Library Logo" />
            <h3 class="aklat-title">AklatURSM</h3>
            <h3>LIBRARY MANAGEMENT SYSTEM</h3>
        </div>

        <div id="banModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeModal">&times;</span>
                <div class="ban-icon-container">
                    <img src="ban-icon.png" alt="Banned Icon" class="ban-icon">
                </div>
                <h2>Account Status: Banned</h2>
                <p>We regret to inform you that your AklatURSM account has been banned due to a late return of a borrowed book.</p>
                <p id="banReason"></p>
                <p>Your account will be reactivated in: <span id="countdown"></span></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById("banModal");
            var span = document.getElementById("closeModal");
            var isBannedOnLoad = <?php echo $banned_on_login ? 'true' : 'false'; ?>;

            // Function to show the ban modal
            function showBanModal() {
                modal.style.display = "flex";
            }

            // Function to hide the ban modal
            function hideBanModal() {
                modal.style.display = "none";
            }

            // Close modal on X click
            if (span && modal) {
                span.addEventListener('click', function () {
                    hideBanModal();
                    fetch('clear_ban_modal_session.php');
                });
            }

            // Close modal if clicked outside
            window.addEventListener('click', function (event) {
                if (event.target == modal) {
                    hideBanModal();
                    fetch('clear_ban_modal_session.php');
                }
            });

            // Countdown timer
            function startCountdown(expiryDateString) {
                var expiryDate = new Date(expiryDateString).getTime();
                var countdownElement = document.getElementById("countdown");

                var x = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = expiryDate - now;

                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    countdownElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                    if (distance < 0) {
                        clearInterval(x);
                        countdownElement.innerHTML = "Account Reactivated";
                        setTimeout(hideBanModal, 3000); // Hide modal after 3 seconds
                    }
                }, 1000);
            }

            <?php if (isset($_SESSION['banned_username'])): ?>
                // Fetch ban expiry date and reason, then start countdown and show modal
                fetchBanDetails('<?php echo $_SESSION['banned_username']; ?>');
                showBanModal(); // Show the modal on page load if banned_username is set
            <?php endif; ?>

            function fetchBanDetails(username) {
                fetch('get_ban_details.php?username=' + username)
                    .then(response => response.json())
                    .then(data => {
                        if (data.expiry_date && data.ban_reason) {
                            document.getElementById('banReason').textContent = "Reason: " + data.ban_reason;
                            startCountdown(data.expiry_date);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // If banned on the current login attempt, show the modal immediately
            if (isBannedOnLoad) {
                showBanModal();
            }
        });
    </script>
</body>
</html>