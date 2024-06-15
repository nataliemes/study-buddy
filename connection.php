<?php

    $mysqli = new mysqli("localhost", "root", "", "test");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: ". $mysqli->connect_error);
    }


    // TO-DO: fix 'die' & instead show an error page with the appropriate message
    function secureQuery($sql, $types, $data){
        global $mysqli;

        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . $mysqli->error);
        }

        $bind = $stmt->bind_param($types, ...$data);
        if ($bind === false) {
            die('Bind failed: ' . $stmt->error);
        }

        $exec = $stmt->execute();
        if ($exec === false) {
            die('Execute failed: ' . $stmt->error);
        }

        return $stmt;
    }
    
?>