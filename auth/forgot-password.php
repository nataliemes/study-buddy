<?php
    // tu shemosulia, forgot-password gverdze agar unda shediodes
    session_start();
    if (isset($_SESSION['USERNAME'])) {
        header("location: http://localhost/web/index.php");
        die();
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once '../vendor/autoload.php';
    include_once '../connection.php';
    $message="";


    if (isset($_POST['submit'])) {
    
        $email = trim($_POST['email']);
        $code = md5(uniqid(rand(), true));  // unique & random reset code

        $result = secureQuery("SELECT * FROM user WHERE email=?", "s", [$email])
                    ->get_result();


        if ($result->num_rows > 0) {
            
            if (!empty($result->fetch_assoc()['code'])){
                $message = "<div class='alert'> Your account has not been verified.
                            You must first finish the registration process. </div>";
            }
            else {
                secureQuery("UPDATE user SET code=? WHERE email=?", "ss", [$code, $email]);

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();                                      // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                 // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                             // Enable SMTP authentication
                    $mail->Username   = 'abaravici36@gmail.com';          // SMTP username
                    $mail->Password   = 'klbl nepq ehhy qvok';            // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      // Enable implicit TLS encryption
                    $mail->Port       = 465;                              // TCP port to connect to

                    // Recipients
                    $mail->setFrom('abaravici36@gmail.com');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'no reply';
                    $mail->Body    = '<a href="http://localhost/web/auth/change-password.php?reset='. $code .'">
                                        Click here to change password </a>';

                    $mail->send();
                    $message = "<div class='alert'> A password reset link has been sent to your email address.
                                <br> You will no longer be able to log in with your old password. </div>";
                }
                catch (Exception $e) {
                    $message = "<div class='alert'> Message could not be sent.
                                Mailer Error: {$mail->ErrorInfo} </div>";
                }
            }    
        } else {
            $message = "<div class='alert'> Your email address was not found. </div>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/side-image-layout.css">
    <link rel="stylesheet" href="../css/form.css">
    <title>Web Project Demo</title>
</head>
<body>
    <?php require_once "../nav-bar.php"; ?>

    <aside>
        <img src="../images/reset.png" alt="image">
    </aside>

    <main>
        <form action="" method="post">
            <h2> Forgot Password </h2>
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