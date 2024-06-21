<?php

    $mysqli = new mysqli("localhost", "root", "", "test");

    if ($mysqli->connect_error) {
        die("Connection failed: ". $mysqli->connect_error);
    }

    // executes queries with prepared statements
    function secureQuery($sql, $types, $data) {
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


    // $table -   post / category / feedback
    // $page  -   admin / user / posts
    function showDBdata($table, $page){

        // if table is post, we need to show an extra field: file_path
        // & we also need to get categories of that post
        $extraFields = $extraJoin = "";
        if ($table === "post"){
            $extraFields = "t.file_path, GROUP_CONCAT(c.name SEPARATOR ', ') as categories, ";
            $extraJoin = "JOIN post_category pc ON pc.post_id = t.post_id
				        JOIN category c ON c.category_id = pc.category_id
                        GROUP BY t.post_id";
        }

        // different pages need different content to be shown
        $sql = "";
        if ($page === "user") {
            $sql = "SELECT * FROM {$table}
                    WHERE user_id={$_SESSION['USER_ID']}";
        }
        else {   // admin profile or posts page
            $sql = "SELECT t.{$table}_id, t.name, t.description, t.creation_date, {$extraFields} u.username
            FROM {$table} t JOIN user u ON t.user_id = u.user_id
            {$extraJoin}";
        }

        global $mysqli;
        $queryResult = $mysqli->query($sql);
                    
        if ($queryResult) {
            if ($queryResult->num_rows > 0) {
                while ($row = $queryResult->fetch_assoc()) {

                    echo "<div class='infobox'>";

                    if ($page === "posts"){
                        $class = str_replace(", ", " ", $row['categories']);
                        echo "<div class='post {$class}'>";
                    }
                    
                    echo "<h3> {$row['name']} </h3>
                        <p> {$row['description']} </p>";

                    if ($table === "post") {
                        echo "<h5> {$row['categories']} </h5>";
                        echo "<a href=uploads/{$row['file_path']} target=_blank> {$row['file_path']} </a>";
                    }

                    if ($page === "admin") {
                        echo "<h6> by: {$row['username']} </h6>";
                    }

                    echo "<h6> {$row['creation_date']} </h6>";

                    // deleting option on profiles
                    if ($page === "user" || $page === "admin"){
                        echo "<div> <form action='' method='POST'>
                                <input type='submit' value='Delete' name='delete'>
                                <input type='hidden' value='{$table}' name='table'>
                                <input type='hidden' value='{$row[$table . '_id']}' name='id'>
                            </form> </div>";
                    }

                    if ($page === "posts"){
                        echo "</div>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p> No {$table} found. </p>";
            }
        }
        else {
            die ("ERROR: something went wrong with query");
        }
    }   
?>