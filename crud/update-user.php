<?php

	session_start();
	if (!isset($_SESSION['SESSION_EMAIL'])) {
		header("Location: auth/log-in.php");
		die();
	}
	
	// admini tu araa ar unda ixsnebodes es gverdi

	require_once "connection.php";

	$id = $_GET['id'];
	$sql = "SELECT * FROM user
            WHERE user_id = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()){
        die ("ERROR: could not find the user");
    }
    
    $row = ($stmt->get_result())->fetch_assoc();

	$username = $row['username'];
	$email = $row['email'];
	$is_admin = $row['is_admin'];

	if(isset($_POST['submit'])) {
		$user = trim($_POST['user']);
		$mail = trim($_POST['mail']);

		$sql = "UPDATE user
				SET username=?, email=?
				WHERE user_id = ?";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ssi", $user, $mail, $id);
		$stmt->execute();

        if (isset($_POST['user-role']) && !$is_admin){
            $sql = "UPDATE user
				SET is_admin=1
				WHERE user_id = ?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }

		echo("Record updated successfully!");
		header("refresh:5, url=admin-profile.php");
	}
	else {
?>

	<h2>Update Record</h2>
	<form action="" method="post" >

	Username: <br> <input type="text" value="<?php echo $username; ?>" name="user"> <br>
	Email: <br> <input type="text" value="<?php echo $email; ?>"name="mail"> <br>
	Role: <br>
	<select name="user-role" id="user-role">        <!-- TO-DO: default-ad rom axlandeli role iyos (JQuerry) -->
		<option value="admin"> Admin </option>
		<option value="user"> User </option>
	</select>

	<!--  formas vayolebt id-s, rom submit-ze dacheris mere php-shi gvqondes id  -->
	<input type="hidden" value="<?php echo $id; ?>">

	<input type="submit" value="Update" name="submit">
	</form>

<?php
	}
?>	