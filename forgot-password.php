<?php
    // tu shemosulia, forgot-password gverdze agar unda shediodes
    session_start();
    if (isset($_SESSION['EMAIL'])) {
        header("location: index.php");
        die();
    }

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require_once 'vendor/autoload.php';

    include_once 'connection.php';
    $message="";

    if (isset($_POST['submit'])) {
    
        $email = trim($_POST['email']);
        $code = md5($email);

        $result = secureQuery("SELECT * FROM user WHERE email=?", "s", [$email])
                    ->get_result();

        // TO-DO: sanitize data better

        if ($result->num_rows > 0) {
            
            secureQuery("UPDATE user SET code=? WHERE email=?", "ss", [$code, $email]);

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'REMOVED';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'REMOVED';                     //SMTP username
                $mail->Password   = 'REMOVED';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = REMOVED;                                    //TCP port to connect to; use REMOVED if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('REMOVED');
                $mail->addAddress($email);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'no reply';
                $mail->Body    = 'Here is the link to change password
                <b><a href="http://localhost/web/change-password.php?reset='.$code.'">
                            Click here to change password </a></b>';

                $mail->send();
                $message = "<div class='alert alert-info'> A password reset link has been sent to your email address.
                            <br> You will no longer be able to log in with your old password. </div>";

                // setting empty password, so that user can no longer log in
                // & the reset code cannot be used as a verification code
                secureQuery("UPDATE user SET password_hash='' WHERE email=?", "s", [$email]);
            }
            catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                $message = "<div class='alert alert-info'> Message could not be sent. Mailer Error: {$mail->ErrorInfo} </div>";
            }
            
        } else {
            $message = "<div class='alert alert-danger'>$email - Email address not found.</div>";
        }
    }

?>

<!DOCTYPE html>
<html>
<body>                   
    <h2>Forgot Password</h2>
    <?php echo $message; ?>

    <form action="" method="post">
        <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
        <button name="submit" class="btn" type="submit">Send Reset Link</button>
    </form>
    
    <p> Back to: <a href="log-in.php"> Log in </a> </p>        
</body>

</html>