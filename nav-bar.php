<?php
    $link_name = "";
    $link_address = "";
    if (!isset($_SESSION['USERNAME'])) {
        $link_name = "Log in";
        $link_address = "http://localhost/web/auth/log-in.php";
        $link_icon = "<i class='fa-solid fa-right-to-bracket'></i>";
    }
    else {
        $link_name = $_SESSION['USERNAME'];
        $link_icon = "<i class='fa-solid fa-user'></i>";

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
        <h1> <i class="fa-solid fa-book"></i> Study Buddy </h1>
        <div>
            <a href='http://localhost/web/index.php'> <i class="fa-solid fa-house"></i> Home </a>
            <a href='http://localhost/web/about.php'> <i class="fa-solid fa-circle-info"></i> About </a>
            <a href='http://localhost/web/posts.php'> <i class="fa-solid fa-file-lines"></i> Posts </a>

            <a href='http://localhost/web/contact.php'> <i class="fa-solid fa-envelope"></i> Contact </a>
            <a href='http://localhost/web/faq.php'> <i class="fa-solid fa-circle-question"></i> FAQ </a>
            <?php echo "<a href={$link_address}> {$link_icon} {$link_name} </a>"; ?>
        </div>
    </nav>
</body>
</html>