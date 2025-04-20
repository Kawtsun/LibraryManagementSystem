<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!function_exists('send_ban_email')) {
    function send_ban_email($email_address, $name, $ban_reason, $ban_expiry_date) {
        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'johnluizaustria@gmail.com';
            $mail->Password   = 'uyxp gdzo dlir wbgz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('johnluizaustria@gmail.com', 'AklatURSM');
            $mail->addAddress($email_address, $name);
            $mail->Subject = 'AklatURSM Account Banned';
            $mail->isHTML(true);
            $mail->Body    = "Dear " . htmlspecialchars($name) . ",<br><br>" .
                                 "We regret to inform you that your AklatURSM account has been banned due to: <b>" . htmlspecialchars($ban_reason) . "</b>.<br><br>" .
                                 "Your account will be suspended until: <b>" . date('F j, Y, g:i a', strtotime($ban_expiry_date)) . "</b>.<br><br>" .
                                 "If you have any concerns or inquiries, please feel free to contact our office.<br><br><br>" .
                                 "Best regards,<br>" .
                                 "AklatURSM";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: {$mail->ErrorInfo}");
            return false;
        }
    }
}
?>