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
<head>
    <script src="https://kit.fontawesome.com/166339ffbb.js" crossorigin="anonymous"></script>
</head>
<html>
<body>    
    <nav>
        <h1> LOGO </h1>
        <div>
            <a href='http://localhost/web/index.php'> Home </a>
            <a href='http://localhost/web/about.php'> About </a>
            <a href='http://localhost/web/posts.php'> Posts </a>
            <a href='http://localhost/web/contact.php'> Contact </a>
            <a href='http://localhost/web/faq.php'> FAQ </a>
        
            <?php echo "<a href={$link_address}> {$link_name} </a>"; ?>
        </div>
    </nav>
</body>
</html>