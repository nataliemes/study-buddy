<?php
    // tu shemosulia, registraciis gverdze agar unda shediodes
    session_start();
    if (isset($_SESSION['USERNAME'])) {
        header("location: http://localhost/web/index.php");
        die();
    }

    // import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // load Composer's autoloader
    require_once '../vendor/autoload.php';

    require_once '../nav-bar.php';
    require_once '../connection.php';
    $message = "";

    if (isset($_POST['submit'])) {
        
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = md5($_POST['password']);
        $confirmPassword = md5($_POST['confirm-password']);

        if (empty($username)){  // password may contain spaces
            $message = "<div class='alert'>
                        Invalid username: it only contains spaces. </div>";
        }
        else if ($password !== $confirmPassword) {
            $message = "<div class='alert'>
                        Password and confirm password do not match. </div>";
        }
        else {
            $result_email = secureQuery("SELECT * FROM user WHERE email=?", "s", [$email])
                            ->get_result();
            $result_username = secureQuery("SELECT * FROM user WHERE username=?", "s", [$username])
                            ->get_result();

            // if email or username is taken
            if ($result_email->num_rows > 0) {
                $result_email = $result_email->fetch_assoc();

                // if user with this email is already registered
                if ($result_email['code'] == ''){
                    $message = "<div class='alert'>
                                Account with this email address already exists. </div>";
                }

                // if user with this email tried to register, but isn't verified
                else {
                    $message = "<div class='alert'>
                                You have already tried to register. <br>
                                Check the email to verify your account. </div>";
                }
            } 
            else if ($result_username->num_rows > 0){
                $message = "<div class='alert'>
                            Account with this username already exists. </div>";
            }

            // if email & username are available
            else {

                $code = md5($email);  // unique & random verification code 

                $sql = "INSERT INTO user (username, email, password_hash, code)
                        VALUES (?, ?, ?, ?)";

                secureQuery($sql, "ssss", [$username, $email, $password, $code]);

                $mail = new PHPMailer(true);   // passing `true` enables exceptions

                try {
                    // Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;          // Enable verbose debug output
                    $mail->isSMTP();                                   // Send using SMTP
                    $mail->Host       = 'REMOVED';              // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                          // Enable SMTP authentication
                    $mail->Username   = 'REMOVED';       // SMTP username
                    $mail->Password   = 'REMOVED';         // SMTP password (I have to enable 2FA & use app password)
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // Enable implicit TLS encryption
                    $mail->Port       = REMOVED;                           // TCP port to connect to

                    // Recipients
                    $mail->setFrom('REMOVED');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'no reply';
                    $mail->Body    = '<b><a href="http://localhost/web/auth/log-in.php/?verification='. $code. '">
                                    Click here to verify your account </a></b>';

                    $mail->send();
                }
                catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                
                $message = "<div class='alert alert-info'>
                            A verification link has been sent on your email address. </div>";

            }
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
            <h2> Sign up </h2>
            <?php echo $message; ?>
            
            <label for="username"> Username: </label> <br>
            <input type="text" name="username" id="username" required> <br>
            
            <label for="email"> Email: </label> <br>
            <input type="email" name="email" id="email" required> <br>

            <label for="password"> Password: </label> <br>
            <input type="password" name="password" id="password" required> <br>

            <label for="confirm-password"> Password: </label> <br>
            <input type="password" name="confirm-password" id="confirm-password" required> <br>

            <button name="submit" class="btn" type="submit"> Sign up </button>

            <p> Have an account? <a href="http://localhost/web/auth/log-in.php"> Log in </a> </p>
        </form>


    </main>

    <?php include_once "../footer.php"; ?>

</body>
</html>