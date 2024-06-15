<?php

	// nav-bar-shi mowmdeba user shemosulia tu ara
	include 'nav-bar.php';
	
	// sesias dawyeba agar unda, nav-bar-shi daiwyo
    if ($_SESSION['IS_ADMIN']) {
        header("Location: admin-profile.php");
        die();
    }

	echo "<h1 style='color: blue'> USER PAGE </h1>";
    echo "<a href='auth/log-out.php'> Log out </a>";

	require_once "connection.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" href="style.css"> -->

    <style>
    

        .tab {
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            height: 50px;
            
        }

        .tab button {
            border: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 17px;
            transition: 0.3s;
        }

        .tab button:hover {
            background-color: #ddd;
        }

        .tab button.active {
            background-color: #ccc;
        }

        .tabcontent {
            display: none;
            padding: 6px 12px;

            border: 1px solid #ccc;
            border-top: none;
            background-color: lightblue;
        }

        .tabcontent.first {
            display: block;
        }

    </style>

    <script src="profile.js" ></script>

    </head>
<body>


    <div class="tab">
        <button class="tablinks active" onclick="openTab(event, 'posts')">My posts</button>
        <button class="tablinks" onclick="openTab(event, 'categories')">My categories</button>
        <button class="tablinks" onclick="openTab(event, 'feedback')">My feedback</button>
    </div>

    <div id="posts" class="tabcontent first">
        
        <a href="create-post.php"> Create new post </a>    

        <?php
            //Select records from table 
            $myQuery = "SELECT * FROM post
                        WHERE user_id={$_SESSION['USER_ID']}";
            $queryResult = $mysqli->query($myQuery);


            if($queryResult) {
                if($queryResult->num_rows > 0) {
                    while($row = $queryResult->fetch_assoc()) {
                        echo "<h3> {$row['title']} </h3>
                            <p> {$row['description']} </p>
                            <p> {$row['file_path']} </p>
                            <h5> {$row['upload_date']} </h5>";
                    }
                }
                else {
                    echo "No posts found";
                }
            } 
            else {
                echo "Something went wrong with query";
            }

        ?>   
    </div>

    <div id="categories" class="tabcontent">

        <a href="create-category.php"> Create new category </a>
        
        <?php
            //Select records from table 
            $myQuery = "SELECT * FROM category
                        WHERE user_id={$_SESSION['USER_ID']}";
            $queryResult = $mysqli->query($myQuery);


            if($queryResult) {
                if($queryResult->num_rows > 0) {
                    while($row = $queryResult->fetch_assoc()) {
                        echo "<h3> {$row['name']} </h3>
                            <p> {$row['description']} </p>
                            <h5> {$row['creation_date']} </h5>";
                    }
                }
                else {
                    echo "No categories found";
                }
            } 
            else {
                echo "Something went wrong with query";
            }
        ?>
    </div>

    <div id="feedback" class="tabcontent">

        <a href="contact.php"> Create new feedback </a>
    
        <?php
            //Select records from table 
            $myQuery = "SELECT * FROM feedback
                        WHERE user_id={$_SESSION['USER_ID']}";
            $queryResult = $mysqli->query($myQuery);


            if($queryResult) {
                if($queryResult->num_rows > 0) {
                    while($row = $queryResult->fetch_assoc()) {
                        echo "<h3> {$row['subject']} </h3>
                            <p> {$row['text']} </p>
                            <h5> {$row['upload_date']} </h5>";
                    }
                }
                else {
                    echo "No feedback found";
                }
            } 
            else {
                echo "Something went wrong with query";
            }
        

        ?>
    
    </div>
   
</body>
</html> 
