<?php 
    session_start();  // for nav-bar
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/posts.js"></script>
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
                // echo "<button class='category active' onclick='showCategories(event, \"$cat\")'> {$cat} </button>";
                
                echo "<button class='category-toggle' data-category='{$cat}'> {$cat} </button>";
            }
            echo "</div>";
    
            showDBdata("post", "posts");
        ?>
    </main>

    <?php include_once 'footer.php'; ?>
</body>
</html>