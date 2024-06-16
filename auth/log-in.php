<?php
    // tu shemosulia, loginis gverdze agar unda shediodes
    session_start();
    if (isset($_SESSION['EMAIL'])) {
        header("Location: http://localhost/web/index.php");
        die();
    }

    include_once '../connection.php';
    $message="";
    

    // verifying account
    if (isset($_GET['verification'])) {

        $selectResult = (secureQuery("SELECT * FROM user WHERE code=? AND registration_date=0000-00-00", "s", [$_GET['verification']]))
                        ->get_result();
    
        if ($selectResult->num_rows > 0) {

            $sql = "UPDATE user
                    SET registration_date = current_date(), 
                        code = ''
                    WHERE registration_date = 0000-00-00 AND code = ?";
            
            secureQuery($sql, "s", [$_GET['verification']]);
        } 
        else {
            $message = "ERROR: such verification code does not exist.
                        <br> You will be redirected to sign-up page.";
            header("refresh: 3, url=http://localhost/web/auth/sign-up.php");
            die();
        }
    }

    // logging into an existing account
    if (isset($_POST['submit'])) {
        
        $email = trim($_POST['email']);
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM user
                WHERE email=? AND password_hash=?";

        $result = (secureQuery($sql, "ss", [$email, $password]))
                    ->get_result();
        
        if ($result->num_rows === 0) {
            $message = "<div class='alert alert-danger'>
                        Wrong email or password </div>";
        }
        else {
            $row = $result->fetch_assoc();

            if ($row['code']){  // if code is not empty
                $message = "<div class='alert alert-info'>
                            Please, verify your account or update the forgotten password and try again.</div>";
            }
            else {
                $_SESSION['EMAIL'] = $email;
                $_SESSION['USER_ID'] = $row['user_id'];
                $_SESSION['USERNAME'] = $row['username'];
                $_SESSION['IS_ADMIN'] = $row['is_admin'];
                // $_SESSION['CREATED']   // vada rom gauvides ragac drois mere
   
                header("Location: http://localhost/web/index.php");
                die();
            }
        }
    } 
?>

<!DOCTYPE html>
<html>
<body>

    <h2> Log in </h2>
    <?php echo $message; ?>
    
    <form action="http://localhost/web/auth/log-in.php" method="post">
        Email: <input type="email" class="email" name="email" required> <br>
        Password: <input type="password" class="password" name="password" required>
        <p><a href="forgot-password.php">Forgot Password?</a></p>
        <button name="submit" name="submit" class="btn" type="submit">Login</button>
    </form>
    
    <p> Don't have an account? <a href="http://localhost/web/auth/sign-up.php"> Sign up </a></p>
    
</body>
</html>