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

	$message = "";
	require_once "connection.php";

	if (isset($_POST['delete'])){
		$table = $_POST['table'];
        $mysqli->query("DELETE FROM {$table} WHERE {$table}_id = {$_POST['id']}");
		$message = "{$table} deleted successfully.";
    }

	if (isset($_POST['download'])){
        // download file with user data in it

		$id = $_POST['id'];

		$sql = "SELECT username, email, is_admin, registration_date FROM user
                WHERE user_id = {$id}";
		$user = ($mysqli->query($sql))->fetch_assoc();    // only 1 row

		$file = "{$user['username']}-info.txt";
		$txt = fopen($file, "w") or die("Unable to open file!");

		$output = "User Information:\n";
		$output .= "------------------\n";
		$output .= "Username: {$user['username']}\n";
		$output .= "Email: {$user['email']}\n";
		$output .= "Is Admin: " . ($user['is_admin'] ? 'Yes' : 'No') . "\n";
		$output .= "Registration Date: {$user['registration_date']}\n\n";


		// feedbacks
		$sql = "SELECT name, description, creation_date FROM feedback
                WHERE user_id = {$id}";
		
		$feedbacks = ($mysqli->query($sql))->fetch_all(MYSQLI_ASSOC);
		$output .= "Feedbacks:\n";
		$output .= "----------\n";
		
		if ($feedbacks) {
			foreach ($feedbacks as $feedback) {
				$output .= "Name: {$feedback['name']}\n";
				$output .= "Description: {$feedback['description']}\n";
				$output .= "Creation Date: {$feedback['creation_date']}\n\n";
			}
		} else {
			$output .= "No feedbacks found.\n\n";
		}

		// categories
		$sql = "SELECT name, description, creation_date FROM category
                WHERE user_id = {$id}";
		
		$categories = ($mysqli->query($sql))->fetch_all(MYSQLI_ASSOC);
		$output .= "Categories:\n";
		$output .= "----------\n";
		
		if ($feedbacks) {
			foreach ($categories as $category) {
				$output .= "Name: {$category['name']}\n";
				$output .= "Description: {$category['description']}\n";
				$output .= "Creation Date: {$category['creation_date']}\n\n";
			}
		} else {
			$output .= "No categories found.\n\n";
		}


		// posts
		$sql = "SELECT p.name as post_name, p.description, p.file_path, p.creation_date,
					GROUP_CONCAT(c.name SEPARATOR ', ') as cat_names
				FROM post p JOIN post_category pc ON pc.post_id = p.post_id
				JOIN category c ON c.category_id = pc.category_id
				WHERE p.user_id = {$id}
				GROUP BY p.post_id";	
		

		$posts = ($mysqli->query($sql))->fetch_all(MYSQLI_ASSOC);
		$output .= "Posts:\n";
		$output .= "------\n";

		if ($posts) {
			
			foreach ($posts as $post) {
				$output .= "Name: {$post['post_name']}\n";
				$output .= "Description: {$post['description']}\n";
				$output .= "File: {$post['file_path']}\n";
				$output .= "Creation Date: {$post['creation_date']}\n";
				$output .= "Categories: {$post['cat_names']}\n\n";
			}
		} else {
			$output .= "No posts found.\n\n";
		}

		fwrite($txt, $output);
		fclose($txt);

		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		header("Content-Type: text/plain");
		readfile($file);
		die();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="profile.css">

    <script src="profile.js" ></script>
</head>
<body>

	<?php include 'nav-bar.php'; ?>

	<header>
		<h1 style='color: red'> ADMIN PAGE </h1>

		<?php echo $message; ?>

		<a href='http://localhost/web/auth/log-out.php'> Log out </a>
	</header>

	<main>
		<div class="tab">
			<button class="tablinks active" onclick="openTab(event, 'user')">All users</button>
			<button class="tablinks" onclick="openTab(event, 'post')">All posts</button>
			<button class="tablinks" onclick="openTab(event, 'category')">All categories</button>
			<button class="tablinks" onclick="openTab(event, 'feedback')">All feedback</button>
		</div>

		<div id="user" class="tabcontent first">
			
			<?php
				require_once "connection.php";
				$queryResult = $mysqli->query("SELECT * FROM user WHERE registration_date != 0000-00-00");

				if($queryResult) {
					if($queryResult->num_rows > 0) {					

						while($row = $queryResult->fetch_assoc()) {
							echo "<br><br> user_id: " . $row['user_id'] .
									"<br> username: " . $row['username'] .
									"<br> email: " . $row['email'] .
									"<br> is_admin: " . $row['is_admin'] .
									"<br> registration date: " . $row['registration_date'];
							
							if ($_SESSION['EMAIL'] !== $row['email']) {  // tavisi tavi rom ar shecvalos
								echo "<form action='' method='POST'>
										<input type='submit' value='Delete' name='delete'>
										<input type='submit' value='Download' name='download'>
										<input type='hidden' value='{$row['user_id']}' name='id'>
										<input type='hidden' value='user' name='table'>
									</form>";
								echo "<form action='crud/update-user.php' method='POST'>
									<input type='submit' value='Update' name='update'>
									<input type='hidden' value='{$row['user_id']}' name='user_id'>
								</form>";
							}
						}			
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

		<div id="post" class="tabcontent">
			<a href="http://localhost/web/crud/create-post.php"> Create new post </a>    

			<!-- TO-DO: download file when clicked the file_path -->
			<?php showDBdata("post", "admin"); ?>   
		</div>

		<div id="category" class="tabcontent">

			<a href="http://localhost/web/crud/create-category.php"> Create new category </a>
			<?php showDBdata("category", "admin"); ?>
		</div>

		<div id="feedback" class="tabcontent">
			<a href="http://localhost/web/contact.php"> Create new feedback </a>
			<?php showDBdata("feedback", "admin"); ?>
		</div>

	</main>

	<?php include 'footer.php'; ?>
   
</body>
</html>