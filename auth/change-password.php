<?php
    $message = "";
    require_once '../connection.php';

    session_start();
    if (!isset($_GET['reset']) || isset($_SESSION['USERNAME'])){
        header("location: http://localhost/study-buddy/index.php");
        die();
    }

    else {
        $selectResult = secureQuery("SELECT * FROM user WHERE code=? AND registration_date!=0000-00-00", "s", [$_GET['reset']])
                        ->get_result();

        if ($selectResult->num_rows > 0) {
            if (isset($_POST['submit'])) {
                $password = md5($_POST['password']);
                $confirm_password = md5($_POST['confirm-password']);

                if ($password !== $confirm_password){
                    $message = "<div class='alert'> Password and Confirm Password do not match. </div>";
                }
                else {
                    $sql = "UPDATE user SET password_hash=?, code='' WHERE code=? AND registration_date!=0000-00-00";
                    secureQuery($sql, "ss", [$password, $_GET['reset']]);
                    $message = "<div class='alert'>
                            Password updated successfully. <br>
                            You will be redirected to log-in page. </div>";
                    header("refresh: 6, url=http://localhost/study-buddy/auth/log-in.php");
                }
            }
        }
        else {
            $message = "<div class='alert'> Such reset code does not exist.
                        You will be redirected to log-in page. </div>";
            header("refresh: 6, url=http://localhost/study-buddy/auth/log-in.php");
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/study-buddy/css/style.css">
    <link rel="stylesheet" href="http://localhost/study-buddy/css/side-image-layout.css">
    <link rel="stylesheet" href="http://localhost/study-buddy/css/form.css">
    <title>Web Project Demo</title>
</head>
<body>
    <?php require_once "../nav-bar.php"; ?>

    <aside>
        <img src="http://localhost/study-buddy/images/reset.png" alt="image">
    </aside>

    <main>
        <form action="" method="post">
            <h2> Change Password </h2>
            <?php echo $message; ?>

            <label for="password"> Enter new password: </label> <br>
            <input type="password" name="password" id="password" required> <br>

            <label for="confirm-password"> Confirm new password: </label> <br>
            <input type="password" name="confirm-password" id="confirm-password" required> <br>

            <button name="submit" class="btn" type="submit"> Update </button>

            <p> Back to: <a href="http://localhost/study-buddy/auth/log-in.php"> Log in </a> </p>
        </form>
    </main>

    <?php include_once "../footer.php"; ?> 
</body>
</html>