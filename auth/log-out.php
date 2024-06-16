<?php

    // tu shemosuli araa, log out-is gverdze ver unda shediodes
    session_start();
    
    // if (!isset($_SESSION['EMAIL'])) {
    //     header("Location: http://localhost/web/index.php");
    //     die();
    // }

    session_unset();
    session_destroy();

    header("Location: http://localhost/web/index.php");
    die();
?>