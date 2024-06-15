<?php
    // tu shemosulia, loginis gverdze agar unda shediodes
    session_start();
    if (isset($_SESSION['EMAIL'])) {
        header("Location: http://localhost/PROJECT1/index.php");
        die();
    }

    include_once 'connection.php';
    $message="";
    

    if (isset($_GET['verification'])) {

        $selectResult = (secureQuery("SELECT * FROM user WHERE code=? AND password_hash!=''", "s", [$_GET['verification']]))
                        ->get_result();
    
        if ($selectResult->num_rows > 0) {
            
            secureQuery("UPDATE user SET code='' WHERE code=? AND password_hash!=''", "s", [$_GET['verification']]);
            $message = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
            $mysqli->query("UPDATE user SET registration_date=current_date()
                        WHERE code='' AND registration_date=0000-00-00");
        } 
        else {
            $message = "ERROR: such verification code does not exist.
                        <br> You will be redirected to sign-up page.";
            header("refresh: 3, url= http://localhost/PROJECT1/sign-up.php");
        }
    }

    if (isset($_POST['submit'])) {
        
        $email = trim($_POST['email']);
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM user
                WHERE email=? AND password_hash=?";

        $result = (secureQuery($sql, "ss", [$email, $password]))
                    ->get_result();
        
        if ($result->num_rows !== 1) {
            $message = "<div class='alert alert-danger'> Wrong email or password </div>";
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

                header("Location: http://localhost/PROJECT1/index.php");
            }
        }
    } 
?>

<!DOCTYPE html>
<html>
<body>

    <h2> Log in </h2>
    <?php echo $message; ?>
    
    <form action="http://localhost/PROJECT1/log-in.php" method="post">
        Email: <input type="email" class="email" name="email" required> <br>
        Password: <input type="password" class="password" name="password" required>
        <p><a href="forgot-password.php">Forgot Password?</a></p>
        <button name="submit" name="submit" class="btn" type="submit">Login</button>
    </form>
    
    <p> Don't have an account? <a href="sign-up.php"> Sign up </a></p>
    
</body>
</html>