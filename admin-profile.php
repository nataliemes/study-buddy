<?php

	// nav-bar-shi mowmdeba user shemosulia tu ara
	include 'nav-bar.php';
	
	// sesias dawyeba agar unda, nav-bar-shi daiwyo
    if (!$_SESSION['IS_ADMIN']) {
        header("Location: user-profile.php");
        die();
    }

	require_once "connection.php";
	$message = "";

	if (isset($_POST['Delete'])){
        $mysqli->query("DELETE FROM user WHERE user_id={$_POST['user_id']}");
		$message = "User deleted successfully.";
    }
	
	if (isset($_POST['Download'])){
        // download file with user data in it


		$file = "user-info.txt";
		$txt = fopen($file, "w") or die("Unable to open file!");

		$info = "here's some info"; // write everythign here

		fwrite($txt, $info);
		fclose($txt);

		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		header("Content-Type: text/plain");
		readfile($file);
		die(); // smth wrong cause it keeps outputing navbar code in file
    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
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

	<h1 style='color: red'> ADMIN PAGE </h1>

	<?php echo $message; ?>

	<a href='auth/log-out.php'> Log out </a>


    <div class="tab">
	<button class="tablinks active" onclick="openTab(event, 'users')">All users</button>
        <button class="tablinks" onclick="openTab(event, 'posts')">All posts</button>
        <button class="tablinks" onclick="openTab(event, 'categories')">All categories</button>
        <button class="tablinks" onclick="openTab(event, 'feedback')">All feedback</button>
    </div>

	<div id="users" class="tabcontent first">
        
        

        <?php
            //Select records from table 
			$queryResult = $mysqli->query("SELECT * FROM user");

			if($queryResult) {
				if($queryResult->num_rows > 0) {

					// Display results into a table
					echo "
					<table border=1>
					<tr>
						<th> user_id </th>
						<th> username </th>
						<th> email </th>
						<th> is_admin </th>
						<th> registration date </th>
						<th> operations </th>
					</tr>
					";

					while($row = $queryResult->fetch_assoc()) {
						echo "<tr>
							<td>". $row['user_id'] ."</td>
							<td>". $row['username']. "</td>
							<td>". $row['email']."</td>
							<td>". $row['is_admin']."</td>
							<td>". $row['registration_date']."</td>";
						echo '<td>
							<a href="view-user.php?id='. $row['user_id'] .'" > View Posts </a>';
						if ($_SESSION['EMAIL'] !== $row['email']) {  // tavisi tavi rom ar shecvalos
							// echo '<a href="update-user.php?id='. $row['user_id'] .'" > Update </a>
							// <a href="delete-user.php?id='. $row['user_id'] .'" > Delete </a>
							// <a href="download-user-data.php?id='. $row['user_id'] .'" > Download data </a>';
							echo "<form action='' method='POST'>
									<input type='submit' value='Update' name='Update'>
									<input type='submit' value='Delete' name='Delete'>
									<input type='submit' value='Download' name='Download'>
									<input type='hidden' value='{$row['user_id']}' name='user_id'>
								</form>";
						}
					echo '</td>
						</tr>';
					}
					echo "</table>";			
				}			
				else {
					echo "No users found";
				}
			} 
			else {
				echo "Something wrong with query";
			}
        ?>   
    </div>

    <div id="posts" class="tabcontent">
        
        <a href="create-post.php"> Create new post </a>    

        <?php  // TO-DO: download file when clicked the file_path
		    $queryResult = $mysqli->query("
				SELECT p.title, p.description, p.file_path, p.upload_date, u.username
				FROM post p	JOIN user u ON p.user_id = u.user_id");
			
			if ($queryResult) {
				if ($queryResult->num_rows > 0) {
					while ($row = $queryResult->fetch_assoc()) {
						echo "<h3> {$row['title']} </h3>
							<p> {$row['description']} </p>
							<h5> {$row['file_path']} </h5>
							<h5> {$row['username']} </h5>
							<h5> {$row['upload_date']} </h5>";
					}
				} else {
					echo "No categories found";
				}
			} else {
				echo "Something went wrong with query";
			}  
        ?>   
    </div>

    <div id="categories" class="tabcontent">

        <a href="create-category.php"> Create new category </a>
        
        <?php
			$queryResult = $mysqli->query("
				SELECT c.name, c.description, c.creation_date, u.username
				FROM category c	JOIN user u ON c.user_id = u.user_id");
			
			if ($queryResult) {
				if ($queryResult->num_rows > 0) {
					while ($row = $queryResult->fetch_assoc()) {
						echo "<h3> {$row['name']} </h3>
							<p> {$row['description']} </p>
							<h5> {$row['username']} </h5>
							<h5> {$row['creation_date']} </h5>";
					}
				} else {
					echo "No categories found";
				}
			} else {
				echo "Something went wrong with query";
			}   
        ?>
    </div>

    <div id="feedback" class="tabcontent">

		<a href="contact.php"> Create new feedback </a>
		
		<?php
			$queryResult = $mysqli->query("
				SELECT f.subject, f.text, f.upload_date, u.username
				FROM feedback f JOIN user u ON f.user_id = u.user_id");
			
			if ($queryResult) {
				if ($queryResult->num_rows > 0) {
					while ($row = $queryResult->fetch_assoc()) {
						echo "<h3> {$row['subject']} </h3>
							<p> {$row['text']} </p>
							<h5> {$row['username']} </h5>
							<h5> {$row['upload_date']} </h5>";
					}
				} else {
					echo "No feedback found";
				}
			} else {
				echo "Something went wrong with query";
			}
        ?>
    
    </div>
   
</body>
</html>