<?php

    // tu shemosuli araa, log out-is gverdze ver unda shediodes
    session_start();
    if (!isset($_SESSION['EMAIL'])) {   // es nagdad unda? ki mgoni
        header("Location: index.php");
        die();
    }

    session_unset();
    session_destroy();

    header("Location: index.php");
?>