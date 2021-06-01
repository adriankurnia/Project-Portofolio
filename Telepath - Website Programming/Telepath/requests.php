<?php 
include("include/header.php");
?>

<div class = "main_column column" id = "main_column">
	<h4>Friend Requests</h4>
	<?php 

	$query = mysqli_query($con, "SELECT *FROM friend_requests WHERE user_to = '$userLoggedIn'");
	if(mysqli_num_rows($query) == 0){
		echo "You Have No Friend Request At This Time!";
	}
	else{
		while($row = mysqli_fetch_array($query)){
			$user_from = $row['user_from'];
			$user_from_obj = new User($con, $user_from);

			echo $user_from_obj->GetFirstAndLastName() . " Sent You a Friend Request!";

			$user_from_friend_array = $user_from_obj->getFriendArray();

			if(isset($_POST['accept_request' . $user_from])){
				$add_friend_query = mysqli_query($con, "UPDATE user SET teman = CONCAT(teman, '$user_from,') WHERE username = '$userLoggedIn'");
				$add_friend_query = mysqli_query($con, "UPDATE user SET teman = CONCAT(teman, '$userLoggedIn,') WHERE username = '$user_from'");

				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to = '$userLoggedIn' AND user_from = '$user_from'");
				echo "You Are Now Friend!";
				header("Location: requests.php");
			}

			if(isset($_POST['ignore_request' . $user_from])){
				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to = '$userLoggedIn' AND user_from = '$user_from'");
				echo "Request Ignored!";
				header("Location: requests.php");
			}
	?>

	<form action="requests.php" method="POST">
		<input type="submit" name="accept_request<?php echo $user_from; ?>" id = "accept_button" value = "Accept">
		<input type="submit" name="ignore_request<?php echo $user_from; ?>" id = "ignore_button" value = "Ignore">
	</form>
	
	<?php
		
		}
	}

	?>



</div>