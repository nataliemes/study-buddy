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
            $message = "<div class='alert'>
                        Category could not be added.
                        Make sure not to leave any empty fields! </div>";
        }
        else {
            $name = str_replace(' ', '_', $name);

            require_once "../connection.php";

            $selectResult = secureQuery("SELECT * FROM category WHERE name=?", "s", [$name])
                            ->get_result();
        
            if ($selectResult->num_rows > 0){
                $message = "<div class='alert'> Category already exists </div>";
            }
            else {            
                $sql = "INSERT INTO category (user_id, name, description, creation_date)
                        VALUES ({$_SESSION['USER_ID']}, ?, ?, current_date())";

                secureQuery($sql, "ss", [$name, $description]);

                $message = "<div class='alert'> Category added successfully! </div>";
            }
        }
	}
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/side-image-layout.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <?php include '../nav-bar.php'; ?>

    <aside>
        <img src="../images/thinking.png" alt="image">
    </aside>

    <main>
        <form action="" method="post" >
            <h2> Create new category </h2>
            <?php echo $message ?>

            <label for="name"> Name: </label> <br>
            <input type="text" name="name" required> <br>

            <label for="description"> Description: </label> <br>
            <textarea rows="8" cols="60" id="description" name="description"
                    placeholder="write description here..." required></textarea><br>

            <button name="submit" class="btn" type="submit"> Create </button>

            <?php
                if ($_SESSION['IS_ADMIN']) {
                    $link = "http://localhost/web/admin-profile.php";
                }
                else {
                    $link = "http://localhost/web/user-profile.php";
                }
                echo "<p> <a href={$link}> Back to profile </a> </p>";
            ?>
        </form>
    </main>

    <?php include '../footer.php'; ?>

</body>
</html>