<?php

	session_start();

	// if not logged in, shouldn't have access
    if (!isset($_SESSION['EMAIL'])) {
        header("Location: http://localhost/web/index.php");
        die();
    }

	// if logged in & normal user, shouldn't have access
    if (!$_SESSION['IS_ADMIN']) {
        header("Location: http://localhost/web/user-profile.php");
        die();
    }

	//////////////////////////////////////////////////////////////////

	require_once "../connection.php";
	$message = "";

	$id = $_POST['user_id'];

	$queryResult = $mysqli->query("SELECT * FROM user WHERE user_id = {$id}");
	$row = $queryResult->fetch_assoc();
	// not checking if query is successful, cause i'm giving id from db, user must exist
	
	$username = $row['username'];
	$email = $row['email'];
	$is_admin = $row['is_admin'];

	if (isset($_POST['saveUpdate'])) {

		$new_username = trim($_POST['user']);
		$new_email = trim($_POST['mail']);

		if ($new_username !== $username) {
			$sql = "UPDATE user
				SET username=?
				WHERE user_id = $id";

			secureQuery($sql, "s", [$new_username]);

			global $username;
			$username = $new_username;
		}

		if ($new_email !== $email) {
			$sql = "UPDATE user
				SET email=?
				WHERE user_id = $id";

			secureQuery($sql, "s", [$new_email]);

			global $email;
			$email = $new_email;
		}

        if ($_POST['user-role'] !== $is_admin){
            $sql = "UPDATE user
				SET is_admin = {$_POST['user-role']}
				WHERE user_id = {$id}";

			$mysqli->query($sql);
        }

		$message = "Record updated successfully!";
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

	<?php require_once "../nav-bar.php"; ?>

	<aside>
        <img src="../images/notes.png" alt="image">
    </aside>

	<main>
		<form action="" method="post" >
			<h2> Update Record </h2>
			<?php echo $message; ?>

			<label for="user"> Username: </label> <br>
            <input type="text" value="<?php echo $username; ?>" name="user" id="user"> <br>
			
			<label for="mail"> Email: </label> <br>
			<input type="email" value="<?php echo $email; ?>" name="mail" id="mail"> <br>
			
			<label> Role: </label>
			<select name="user-role" id="user-role">
				<option value="1"> Admin </option>
				<option value="0"> User </option>
			</select>

			<!--  formas vayolebt id-s, rom submit-ze dacheris mere php-shi gvqondes id  -->
			<input type="hidden" value="<?php echo $id; ?>" name="user_id">
			
			<button name="submit" name="saveUpdate" type="submit"> Update </button>

			<p> <a href='http://localhost/web/admin-profile.php'> Back to profile </a> </p>
		</form>
	</main>

    <?php include_once '../footer.php'; ?>

</body>
</html>
