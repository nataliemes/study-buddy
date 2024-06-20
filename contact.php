<?php
    session_start();
    $message = "";
    
    if (isset($_SESSION['USERNAME']) && isset($_POST['submit'])) {

        require_once 'connection.php';

        $subject = trim($_POST['subject']);
        $feedback = trim($_POST['feedback-text']);
        
        $sql = "INSERT INTO feedback (user_id, creation_date, name, description)
                    VALUES ({$_SESSION['USER_ID']}, current_date(), ?, ?)";

        secureQuery($sql, "ss", [$subject, $feedback]);
        $message = "<div class='alert'> Feedback was sent successfully! </div>";
    }
    else if (!isset($_SESSION['USERNAME'])){
        $message = "<div class='alert'> You have to be logged in to send feedback! </div>";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body id="contact-page">

    <?php require_once 'nav-bar.php'; ?>

    <main id="contact-main">
        <form action="" method="post">
            <h2> Send feedback </h2>
            <?php echo "<p> {$message} </p>"; ?>

            <label for="subject"> Title: </label> <br>
            <input type="text" name="subject" id="subject" required> <br>

            <label for="feedback-text"> Text: </label> <br>
            <textarea id="feedback-text" name="feedback-text"
                        placeholder="write feedback here..." required></textarea>
            
            <button name="submit" name="submit" class="btn" type="submit"> Send </button>
        </form>
    </main>
    
    <?php include_once 'footer.php'; ?>
</body>
</html>