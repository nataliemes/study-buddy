<?php
    session_start();

    // if not logged in, shouldn't have access to user profile
    if (!isset($_SESSION['EMAIL'])) {
        header("Location: http://localhost/web/index.php");
        die();
    }

    // if logged in & admin, should go to admin profile instead
    if ($_SESSION['IS_ADMIN']) {
        header("Location: http://localhost/web/admin-profile.php");
        die();
    }

	$message = "";
	require_once "connection.php";

	if (isset($_POST['delete'])){
		$table = $_POST['table'];
        $mysqli->query("DELETE FROM {$table} WHERE {$table}_id = {$_POST['id']}");
		$message = "<div class='alert'> {$table} deleted successfully. </div>";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <script src="js/profile.js"></script>
</head>
<body>
    <?php require_once 'nav-bar.php'; ?>

    <header>
        <h1> User homepage </h1>
        <a href='auth/log-out.php'> Log out </a>
    </header>

    <main>
        <div class="tab">
            <button class="tablinks active" onclick="openTab(event, 'posts')">My posts</button>
            <button class="tablinks" onclick="openTab(event, 'categories')">My categories</button>
            <button class="tablinks" onclick="openTab(event, 'feedback')">My feedback</button>
        </div>

        <div id="posts" class="tabcontent first">
            <a href="http://localhost/web/crud/create-post.php"> Create new post </a>    
            <?php showDBdata("post", "user"); ?>
        </div>

        <div id="categories" class="tabcontent">
            <a href="http://localhost/web/crud/create-category.php"> Create new category </a>
            <?php showDBdata("category", "user"); ?>
        </div>

        <div id="feedback" class="tabcontent">
            <a href="http://localhost/web/contact.php"> Create new feedback </a>
            <?php showDBdata("feedback", "user"); ?>
        </div>
    </main>

    <?php include_once 'footer.php'; ?>
</body>
</html> 
