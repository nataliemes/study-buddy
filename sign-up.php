<?php
    // tu shemosulia, registraciis gverdze agar unda shediodes
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
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = md5($_POST['password']);
        $confirmPassword = md5($_POST['confirm-password']);

        if (empty($username) || empty($password) || empty($confirmPassword)){
            $message = "<div class='alert alert-danger'>
                        Invalid input. Make sure no fields are empty. </div>";
        }
        else if ($password !== $confirmPassword) {
            $message = "<div class='alert alert-danger'>
                        Password and confirm password do not match. </div>";
        }
        else {
            $result_email = secureQuery("SELECT * FROM user WHERE email=?", "s", [$email]);
            $result_email = $result_email->get_result();
            $result_username = secureQuery("SELECT * FROM user WHERE username=?", "s", [$username]);
            $result_username = $result_username->get_result();

            // if email or username is taken
            if ($result_email->num_rows > 0) {
                $result_email = $result_email->fetch_assoc();
                if ($result_email['code'] == ''){  // if user with this email is already registered
                    $message = "<div class='alert alert-danger'>
                                Account with this email address already exists. </div>";
                }
                else {  // if user with this email tried to register, but isn't verified
                    $message = "<div class='alert alert-danger'>
                                You have already tried to register. Check the email to verify your account. </div>";
                }
            } 
            else if ($result_username->num_rows > 0){
                $message = "<div class='alert alert-danger'>
                            Account with this username already exists. </div>";
            }

            else {   // if email & username are available

                $code = md5($email);  // unique & random verification code 

                $sql = "INSERT INTO user (username, email, password_hash, code)
                        VALUES (?, ?, ?, ?)";

                secureQuery($sql, "ssss", [$username, $email, $password, $code]);

                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;          // Enable verbose debug output
                    $mail->isSMTP();                                   // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';              // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                          // Enable SMTP authentication
                    $mail->Username   = 'abaravici36@gmail.com';       // SMTP username
                    $mail->Password   = 'klbl nepq ehhy qvok';         // SMTP password (I have to enable 2FA & use app password)
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // Enable implicit TLS encryption
                    $mail->Port       = 465;                           // TCP port to connect to

                    // Recipients
                    $mail->setFrom('abaravici36@gmail.com');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);                                // Set email format to HTML
                    $mail->Subject = 'no reply';
                    $mail->Body    = '<b><a href="http://localhost/web/log-in.php/?verification='. $code. '">
                                    Click here to verify your account </a></b>';

                    $mail->send();
                }
                catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                echo "</div>";
                $message = "<div class='alert alert-info'>
                            A verification link has been sent on your email address. </div>";
                
            }
        }
    }
?> 

<!DOCTYPE html>
<html>

<body>    
    <h2> Register </h2>
    <?php echo $message; ?>

    <form action="" method="post">
        Username: <input type="text" class="username" name="username" required> <br>
        Email: <input type="email" class="email" name="email" required> <br>
        Password: <input type="password" class="password" name="password" required> <br>
        Confirm password: <input type="password" class="confirm-password" name="confirm-password" required> <br>
        <button name="submit" class="btn" type="submit">Register</button>
    </form>
    
    <p> Have an account? <a href="log-in.php"> Log in </a> </p>

</body>

</html>