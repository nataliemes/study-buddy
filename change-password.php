<?php

$message = "";
include 'connection.php';

if (isset($_GET['reset'])) {

    $selectResult = secureQuery("SELECT * FROM user WHERE code=? AND password_hash=''", "s", [$_GET['reset']])
                    ->get_result();

    if ($selectResult->num_rows > 0) {
        if (isset($_POST['submit'])) {
            $password = md5($_POST['password']);
            $confirm_password = md5($_POST['confirm-password']);

            if ($password !== $confirm_password){
                $message = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
            }
            else {
                $sql = "UPDATE user SET password_hash=?, code='' WHERE code=? AND password_hash=''";
                secureQuery($sql, "ss", [$password, $_GET['reset']]);
                $message = "<div class='alert alert-danger'>
                        Password updated successfully. <br>
                        You will be redirected to log in page. </div>";
                header("refresh: 3, url=http://localhost/PROJECT1/log-in.php");
            }
        }
    }
    else {
        $message = "ERROR: such reset code does not exist.
                    <br> You will be redirected to sign-up page.";
        header("refresh: 3, url= http://localhost/PROJECT1/sign-up.php");
    }
} else {
    header("Location: forgot-password.php"); 
}

?>

<!DOCTYPE html>
<html>
<body>
    <h2> Change Password </h2>
    <?php echo $message; ?>

    <form action="" method="post">
        <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
        <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
        <button name="submit" class="btn" type="submit">Change Password</button>
    </form>
    
    <p>Back to: <a href="index.php"> Login </a></p>
</body>
</html>