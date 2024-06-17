<?php
    session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="style.css">

</head>
<body>
    <?php require_once "nav-bar.php"; ?>
    
    <main>
        <?php
            require_once "connection.php";
            $categories = $mysqli->query("SELECT name from category");
            $categories = array_column($categories->fetch_all(MYSQLI_ASSOC), 'name');

            echo "<div id='categories'>";
            foreach ($categories as $cat){
                echo "<button class='category active' onclick='showCategories(event, {$cat})'>My posts</button>";
            }
            echo "</div>";
        ?>


        <a href="http://localhost/web/crud/create-post.php"> Create new post </a>    

        <?php
            showDBdata("post", "admin");
        ?>
    </main>

    <?php include_once 'footer.php'; ?>
</body>
</html>