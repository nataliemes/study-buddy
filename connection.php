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


    // $table   -   post/category/feedback
    // $status  -   admin/user
    function showDBdata($table, $status){

        // if table is post, we need to show an extra field: file_path
        $extraField = "";
        if ($table === "post"){
            $extraField = "t.file_path,";
        }

        // admin & user need to be shown different things
        $sql = "";
        if ($status === "user") {
            $sql = "SELECT * FROM {$table}
                    WHERE user_id={$_SESSION['USER_ID']}";
        }
        else if ($status === "admin"){
            $sql = "SELECT t.name, t.description, t.creation_date, {$extraField} u.username
            FROM {$table} t JOIN user u ON t.user_id = u.user_id";
        }

        global $mysqli;
        $queryResult = $mysqli->query($sql);
                    
        if ($queryResult) {
            if ($queryResult->num_rows > 0) {
                while ($row = $queryResult->fetch_assoc()) {
                    
                    echo "<h3> {$row['name']} </h3>
                        <p> {$row['description']} </p>";

                    if ($status === "admin") {
                        echo "<h5> {$row['username']} </h5>";
                    }

                    if ($table === "post") {
                        echo "<p> {$row['file_path']} </p>";
                    }
            
                    echo "<h5> {$row['creation_date']} </h5>";
                }
            } else {
                echo "No {$table} found";
            }
        }
        else {
            echo "Something went wrong with query";
        }
    }
    
?>