<?php
    session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="nav-bar.css">

</head>
<body>
    <main>
        <?php
            require_once "nav-bar.php";
        ?>

        <a href="http://localhost/web/crud/create-post.php"> Create new post </a>    

        <!-- TO-DO: download file when clicked the file_path -->
        <?php
            require_once "connection.php";
            showDBdata("post", "admin");
        ?>
    </main>
</body>
</html>