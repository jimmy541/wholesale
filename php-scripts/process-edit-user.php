<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

$errorCode = '';

if (isset($_POST['usercode']) && !empty($_POST['usercode']) && isset($_POST['first_name']) && !empty($_POST['first_name']) && isset($_POST['last_name']) && !empty($_POST['last_name']) && isset($_POST['display_code']) && !empty($_POST['display_code']) && isset($_POST['user_role']) && !empty($_POST['user_role'])){ //condition 1
	$user_code = $_POST['usercode'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$display_code = $_POST['display_code'];
	$user_role = $_POST['user_role'];
	
	$allow_price_override = '0';
	$allow_free_override = '0';
			
			if(isset($_POST["allow_limited_override"])){
				$allow_price_override = '1';
			}
			
			if(isset($_POST["allow_free_override"])){
				$allow_free_override = '1';
			}

	
	
	$change_password = 'false';
	$password_query = '';
	if (isset($_POST['password']) && !empty($_POST['password'])){
		$newpassword = $_POST['password'];
		$password = '';
		if($newpassword != '......'){
			$password = $newpassword;
			$change_password = 'true';
			$query = "SELECT `salt` FROM `users` WHERE `uid` = ?";
			if ($stmt = $link->prepare($query)) {
				$stmt->bind_param("s", $user_code);
				$stmt->execute();
				$stmt->bind_result($saltV);
				while ($stmt->fetch()) {
					$salt = $saltV;
				}
				$stmt->close();
			}
			$hashed_password = hash('sha512',$password.$salt);
			$password_query = "password='$hashed_password',";
		}
	}
	
	
		
			$stmt = $link->prepare("UPDATE `users` SET `first_name`=?,`last_name`=?, $password_query `display_code`=?,`role`=? WHERE `uid`=? AND `clientid`= ?");
			$stmt->bind_param('ssssss',$first_name,$last_name,$display_code,$user_role,$user_code,$clientid);
			$stmt->execute();
			$stmt->close();
			header("location: ../edit-user.php?success=1&user=$user_code");
}else{ //if condition 2 false
		header('location: ../dashboard.php');
}


?>