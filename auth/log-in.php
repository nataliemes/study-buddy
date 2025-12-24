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
            $message = "<div class='alert'>
                        Your account has been verified! </div>";
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
            $message = "<div class='alert'> Wrong email or password </div>";
        }
        else {
            $row = $result->fetch_assoc();

            if ($row['code']){  // if code is not empty
                $message = "<div class='alert'> Please, verify your account or
                            update the forgotten password and try again.</div>";
            }
            else {
                $_SESSION['EMAIL'] = $email;
                $_SESSION['USER_ID'] = $row['user_id'];
                $_SESSION['USERNAME'] = $row['username'];
                $_SESSION['IS_ADMIN'] = $row['is_admin'];

                header("Location: http://localhost/web/index.php");
                die();
            }
        }
    } 
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/web/css/style.css">
    <link rel="stylesheet" href="http://localhost/web/css/side-image-layout.css">
    <link rel="stylesheet" href="http://localhost/web/css/form.css">
</head>
<body>
    <?php require_once "../nav-bar.php"; ?>

    <aside>
        <img src="http://localhost/web/images/login.png" alt="image">
    </aside>

    <main>
        <form action="http://localhost/web/auth/log-in.php" method="post">
            <h2> Log in </h2>
            <?php echo $message; ?>

            <label for="email"> Email: </label> <br>
            <input type="email" name="email" id="email" required> <br>

            <label for="password"> Password: </label> <br>
            <input type="password" name="password" id="password" required> <br>

            <p><a href="forgot-password.php"> Forgot Password? </a></p>
            <button name="submit" class="btn" type="submit"> Log in </button>

            <p> Don't have an account? <a href="http://localhost/web/auth/sign-up.php"> Sign up </a></p>
        </form>
    </main>

    <?php include_once "../footer.php"; ?>
</body>
</html>