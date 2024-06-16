<?php
    $link_name = "";
    $link_address = "";
    if (!isset($_SESSION['USERNAME'])) {
        $link_name = "Log in";
        $link_address = "http://localhost/web/auth/log-in.php";
    }
    else {
        $link_name = $_SESSION['USERNAME'];

        if ($_SESSION['IS_ADMIN']){
            $link_address = "http://localhost/web/admin-profile.php";
        }
        else {
            $link_address = "http://localhost/web/user-profile.php";
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Project Demo</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../nav-bar.css">
</head>
<body>    
    <nav>
        <h1> LOGO </h1>
        <a href='http://localhost/web/index.php'> Home </a>
        <a href='http://localhost/web/about.php'> About </a>
        <a href='http://localhost/web/posts.php'> Posts </a>
        <a href='http://localhost/web/contact.php'> Contact </a>
        <a href='http://localhost/web/faq.php'> FAQ </a>
        <?php echo "<a href={$link_address}> {$link_name} </a>"; ?>
    </nav>
</body>
</html>