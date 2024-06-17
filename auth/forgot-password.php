<?php
    // tu shemosulia, forgot-password gverdze agar unda shediodes
    session_start();
    if (isset($_SESSION['EMAIL'])) {
        header("location: http://localhost/web/index.php");
        die();
    }

    // import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require_once '../vendor/autoload.php';

    require_once '../nav-bar.php';
    include_once '../connection.php';
    $message="";

    if (isset($_POST['submit'])) {
    
        $email = trim($_POST['email']);
        $code = md5($email);

        $result = secureQuery("SELECT * FROM user WHERE email=?", "s", [$email])
                    ->get_result();


        if ($result->num_rows > 0) {
            
            if (!empty($result->fetch_assoc()['code'])){
                $message = "<div class='alert alert-danger'>
                            Your account has not been verified. <br>
                            You must first finish the registration process.";
            }

            else {
                secureQuery("UPDATE user SET code=? WHERE email=?", "ss", [$code, $email]);

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
                    <b><a href="http://localhost/web/auth/change-password.php?reset='.$code.'">
                                Click here to change password </a></b>';

                    $mail->send();
                    $message = "<div class='alert alert-info'> A password reset link has been sent to your email address.
                                <br> You will no longer be able to log in with your old password. </div>";

                }
                catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $message = "<div class='alert alert-info'> Message could not be sent. Mailer Error: {$mail->ErrorInfo} </div>";
                }
            }
            
        } else {
            $message = "<div class='alert alert-danger'>
                        Your email address was not found.</div>";
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="auth.css">
    <title>Web Project Demo</title>
</head>
<body>
    
    <?php require_once "../nav-bar.php"; ?>

    <aside>
        <img src="../images/img.png" alt="image">
    </aside>

    <main>
        <form action="" method="post">
            <h2>Forgot Password</h2>
            <?php echo $message; ?>

            <label for="email"> Enter your e-mail: </label> <br>
            <input type="email" name="email" id="email" required> <br>

            <button name="submit" class="btn" type="submit"> Send Link </button>

            <p> Back to: <a href="http://localhost/web/auth/log-in.php"> Log in </a> </p>
        </form>
    </main>

    <?php include_once "../footer.php"; ?>
    
            
</body>

</html>