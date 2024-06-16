<?php

    session_start();

    // if not logged in, shouldn't have access to user profile
    if (!isset($_SESSION['EMAIL'])) {
        header("Location: index.php");
        die();
    }

    // if logged in & admin, should go to admin profile instead
    if ($_SESSION['IS_ADMIN']) {
        header("Location: admin-profile.php");
        die();
    }

	require_once "connection.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="nav-bar.css">
    <link rel="stylesheet" href="profile.css">

    <script src="profile.js" ></script>

    </head>
<body>

    <?php
        include 'nav-bar.php';
    ?>

    <h1 style='color: blue'> USER PAGE </h1>
    <a href='auth/log-out.php'> Log out </a>

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
