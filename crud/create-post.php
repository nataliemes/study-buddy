<?php

    session_start();
    if (!isset($_SESSION['EMAIL'])) {
        header("Location: http://localhost/web/index.php");
        die();
    }

    $message = "";

    require_once "../connection.php";
    $categories = $mysqli->query("SELECT name from category");
    $categories = array_column($categories->fetch_all(MYSQLI_ASSOC), 'name');


    if(isset($_POST['submit'])) {

		$name = trim($_POST['name']);
		$description = trim($_POST['description']);
        $filename = "";
        $chosen_categories = array();
        
        foreach ($categories as $cat){
            if (isset($_POST[$cat])){
                array_push($chosen_categories, $_POST[$cat]);
            }
        }

        if (empty($chosen_categories)){
            $message = "<div class='alert'> You must choose at least one category. </div>";
        }
        else if (empty($name) || empty($description)){
            $message = "<div class='alert'> Post could not be added.
                        Make sure not to leave any empty fields! </div>";
        }
        // empty($_FILES) - might be file_uploads set to "Off" in php.ini
        else if (empty($_FILES) || ($_FILES["file"]["error"] !== UPLOAD_ERR_OK)) {
            $message = "<div class='alert'> ERROR: File was not uploaded. </div>";
        }
        else if ($_FILES["file"]["size"] > 1048576) {
            $message = "<div class='alert'> ERROR: File too large (max 1MB). </div>";
        }
        else if ($_FILES["file"]["type"] !== "application/pdf") {
            $message = "<div class='alert'> ERROR: Invalid file type. </div>";
        }
        else {
            // Replace any characters not \w- in the original filename
            $pathinfo = pathinfo($_FILES["file"]["name"]);
            $base = $pathinfo["filename"];
            $base = preg_replace("/[^\w-]/", "_", $base);

            $filename = $base . "." . $pathinfo["extension"];

            $destination = "{$_SERVER['DOCUMENT_ROOT']}/web/uploads/{$filename}";

            // Add a numeric suffix if the file already exists
            $i = 1;
            while (file_exists($destination)) {
                $filename = $base . " ($i)." . $pathinfo["extension"];
                $destination = "{$_SERVER['DOCUMENT_ROOT']}/web/uploads/{$filename}";
                $i++;
            }

            if (!move_uploaded_file($_FILES["file"]["tmp_name"], $destination)) {
                $message = "Can't move uploaded file";
            }
            else {   // file uploaded successfully

                $sql = "INSERT INTO post (user_id, name, description, file_path, creation_date)
                        VALUES ({$_SESSION['USER_ID']}, ?, ?, ?, current_date())";
                secureQuery($sql, "sss", [$name, $description, $filename]);
                $post_id = $mysqli->insert_id;

                foreach ($chosen_categories as $cat){
                    $category_id = $mysqli->query("SELECT category_id FROM category WHERE name='{$cat}'");
                    $category_id = $category_id->fetch_assoc()['category_id'];

                    $query = "INSERT INTO post_category (post_id, category_id)
                            VALUES ($post_id, $category_id)";
                    $mysqli->query($query);    
                }

                $message = "<div class='alert'> Post added successfully! </div>";
            }
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/form.css">

</head>
<body id='create-post-page'>
    <?php require_once '../nav-bar.php'; ?>

    <main id="create-post-main">
        <form action="" method="post" enctype="multipart/form-data">

            <h2> Create new post </h2>
            <?php echo $message ?>

            <label for="name"> Name: </label> <br>
            <input type="text" name="name" required> <br>

            <label for="description"> Description: </label> <br>
            <textarea rows="8" cols="60" id="description" name="description"
                    placeholder="write description here..." required></textarea><br>

            <label for="file"> Upload File: </label>
            <input type="file" id="file" name="file"> <br> <br>

            <label> Choose categories: </label>
            <?php
                echo "<div id='categories-select'>";
                foreach ($categories as $cat){
                    echo "<div> <input type='checkbox' id={$cat} name={$cat} value={$cat}>";
                    echo "<label for={$cat}> {$cat} </label> </div>";
                }
                echo "</div> <br>";
            ?>

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

    <?php include_once '../footer.php'; ?>
</body>
</html>