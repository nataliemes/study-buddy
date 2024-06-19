<?php
    session_start();
    if (!isset($_SESSION['EMAIL'])) {
        header("Location: http://localhost/web/index.php");
        die();
    }

    $message = "";

    if(isset($_POST['submit'])) {

		$name = trim($_POST['name']);
		$description = trim($_POST['description']);

        if (empty($name) || empty($description)){
            $message = "Category could not be added. Make sure not to leave any empty fields!";
        }
        else {
            $name = str_replace(' ', '_', $name);

            require_once "../connection.php";

            $selectResult = secureQuery("SELECT * FROM category WHERE name=?", "s", [$name])
                            ->get_result();
        
            if ($selectResult->num_rows > 0){
                $message = "Category already exists";
            }
            else {            
                $sql = "INSERT INTO category (user_id, name, description, creation_date)
                        VALUES ({$_SESSION['USER_ID']}, ?, ?, current_date())";

                secureQuery($sql, "ss", [$name, $description]);

                $message = "Category added successfully!";
            }
        }
	}
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../auth/auth.css">
</head>
<body>
    <?php include '../nav-bar.php'; ?>
    <h2> Create new category </h2>
    <?php echo $message ?>

	<form action="" method="post" >
        Name: <br> <input type="text" name="name" required> <br>
        Description: <br> <textarea rows="8" cols="60" id="description" name="description"
                        placeholder="write description here..." required></textarea><br>


        <input type="submit" value="Create" name="submit">
	</form>

    <?php
        if ($_SESSION['IS_ADMIN']) {
            $link = "http://localhost/web/admin-profile.php";
        }
        else {
            $link = "http://localhost/web/user-profile.php";
        }
        echo "<a href={$link}> Back to profile </a>";
    ?>

</body>
</html>