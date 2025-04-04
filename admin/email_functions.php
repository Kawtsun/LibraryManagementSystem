<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_email($email_address, $name, $book_title) {
    $mail = new PHPMailer(true); // `true` enables exceptions

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Disable verbose debugging output
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'johnluizaustria@gmail.com'; // Your Gmail address
        $mail->Password   = 'uyxp gdzo dlir wbgz'; // IMPORTANT: Use an App Password!
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('johnluizaustria@gmail.com', 'AklatURSM'); // Your Gmail address
        $mail->addAddress($email_address, $name); // Use the provided email_address
        $mail->Subject = 'Reminder: Overdue Book Return – AklatURSM'; // Updated Subject
        $mail->Body       = "Dear " . htmlspecialchars($name) . ",

This is a courteous reminder that the book '" . htmlspecialchars($book_title) . "' you borrowed from AklatURSM is now overdue. We kindly request that you return it as soon as possible.

If you have any concerns or inquiries regarding the return, please feel free to contact our office.

Thank you for your cooperation.

Best regards,
AklatURSM";
        $mail->AltBody = "Dear " . $name . ",

This is a courteous reminder that the book '" . $book_title . "' you borrowed from AklatURSM is now overdue. We kindly request that you return it as soon as possible.

If you have any concerns or inquiries regarding the return, please feel free to contact our office.

Thank you for your cooperation.

Best regards,
AklatURSM";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: {$mail->ErrorInfo}");
        return false;
    }
}
?>