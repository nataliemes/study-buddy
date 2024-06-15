<?php

    include 'nav-bar.php';
    $msg = "";
    
    // sesias dawyeba agar unda, nav-bar-shi daiwyo
    if (isset($_SESSION['EMAIL']) && isset($_POST['submit'])) {

        include_once 'connection.php';

        $subject = trim($_POST['subject']);
        $feedback = trim($_POST['feedback-text']);
        
        $sql = "INSERT INTO feedback (user_id, upload_date, subject, text)
                    VALUES ({$_SESSION['USER_ID']}, current_date(), ?, ?)";

        secureQuery($sql, "ss", [$subject, $feedback]);
        $msg = "Feedback was sent successfully!";
    }
    else if (!isset($_SESSION['EMAIL'])){
        $msg = "You have to be logged in to send feedback!
                <a href=auth/log-in.php> Log in </a> ";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <?php echo "<p> {$msg} </p>"; ?>
    <form action="" method="post">
        Subject: <br> <input type="text" name="subject" required> <br>
        Text: <br> <textarea rows="8" cols="60" id="feedback-text" name="feedback-text"
                    placeholder="write feedback here..." required></textarea><br>
        
        <button name="submit" name="submit" class="btn" type="submit"> Send </button>
    </form>
    
</body>
</html>