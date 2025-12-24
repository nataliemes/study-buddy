<?php
    session_start();
    
    // tu shemosuli araa, log out-is gverdze ver unda shediodes
    if (!isset($_SESSION['USERNAME'])) {
        header("Location: http://localhost/study-buddy/index.php");
        die();
    }

    session_unset();
    session_destroy();

    header("Location: http://localhost/study-buddy/index.php");
    die();
?>