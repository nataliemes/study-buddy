<?php

	session_start();

	// if not logged in, shouldn't have access to admin profile
    if (!isset($_SESSION['EMAIL'])) {
        header("Location: http://localhost/web/index.php");
        die();
    }

	// if logged in & normal user, should go to user profile instead
    if (!$_SESSION['IS_ADMIN']) {
        header("Location: http://localhost/web/user-profile.php");
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

		$info = "here's some info"; // write everything here

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
	
	<!-- <link rel="stylesheet" href="style.css"> -->
	<link rel="stylesheet" href="nav-bar.css">
	<link rel="stylesheet" href="profile.css">

    <script src="profile.js" ></script>
</head>
<body>

	<?php include 'nav-bar.php'; ?>

	<h1 style='color: red'> ADMIN PAGE </h1>

	<?php echo $message; ?>

	<a href='http://localhost/web/auth/log-out.php'> Log out </a>


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
        <a href="http://localhost/web/crud/create-post.php"> Create new post </a>    

        <!-- TO-DO: download file when clicked the file_path -->
		<?php showDBdata("post", "admin"); ?>   
    </div>

    <div id="categories" class="tabcontent">

        <a href="http://localhost/web/crud/create-category.php"> Create new category </a>
        <?php showDBdata("category", "admin"); ?>
    </div>

    <div id="feedback" class="tabcontent">
		<a href="http://localhost/web/contact.php"> Create new feedback </a>
		<?php showDBdata("feedback", "admin"); ?>
    </div>
   
</body>
</html>