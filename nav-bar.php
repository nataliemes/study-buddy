<?php

    session_start();
    $link_name = "";
    $link_address = "";
    if (!isset($_SESSION['EMAIL'])) {
        $link_name = "Log in";
        $link_address = "log-in.php";
    }
    else {
        // TO-DO: bazis magivrad $_SESSION-shi sheinaxe username & is_admin
        
        include 'connection.php';

        $query = "SELECT * FROM user WHERE email='{$_SESSION['EMAIL']}'";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $link_name = "{$row['username']}";

            if ($row['is_admin']){   // === TRUE da === 1 ar mushaobs ratomgac
                $link_address = "http://localhost/PROJECT1/admin-profile.php";
            }
            else {
                $link_address = "http://localhost/PROJECT1/user-profile.php";
            }
        }
        else {
            die("ERROR: couldn't find user in the database!");
        }
    }


    echo "
        <nav>
            <h1> NAME </h1>
            <a href='http://localhost/PROJECT1/index.php'> Home </a>
            <a href='http://localhost/PROJECT1/about.php'> About </a>
            <a href='#'> Posts </a>
            <a href='http://localhost/PROJECT1/contact.php'> Contact </a>
            <a href='http://localhost/PROJECT1/faq.php'> FAQ </a>
            <a href='{$link_address}'> {$link_name} </a>
        </nav>
    ";

?>