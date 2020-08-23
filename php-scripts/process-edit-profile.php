<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

$errorCode = '';

if (isset($user) && isset($_POST['user_fname']) && !empty($_POST['user_fname']) && isset($_POST['user_Lname']) && !empty($_POST['user_Lname']) ){
	
	$first_name = $_POST['user_fname'];
	$last_name = $_POST['user_Lname'];
	$discode = '';
	
	if(isset($_POST['discode']) && !empty($_POST['discode'])){
		$discode = $_POST['discode'];
	}
	
	$stmt = $link->prepare("UPDATE `users` SET `first_name`=?,`last_name`=? WHERE `email_address` = '$user' AND `clientid` = '$clientid'");
	$stmt->bind_param('ss',$first_name,$last_name);
	$stmt->execute();
	$stmt->close();
	
	if(!empty($discode) && strlen($discode) > 2){
		$stmt = $link->prepare("UPDATE `users` SET `display_code`=? WHERE `email_address` = '$user' AND `clientid` = '$clientid'");
		$stmt->bind_param('s',$discode);
		$stmt->execute();
		$stmt->close();
	}
	header("location: ../profile.php?successGP=1");
}
if (isset($user) && isset($_POST['currpswd']) && isset($_POST['newpswd']) && isset($_POST['connewpswd']) ){
	//make sure password length is minimum 6 chars.
	if (strlen($_POST['currpswd']) > 5  || strlen($_POST['newpswd']) > 5 || strlen($_POST['connewpswd']) > 5){
		//make sure current password is correct
		$currpassword = $_POST['currpswd'];
		$salt = '';
		$found = 'false';
		//get the salt value
		$query = "SELECT `salt` FROM `users` WHERE `email_address` = '$user'";
		if ($stmt = $link->prepare($query)) {
			$stmt->execute();
			$stmt->bind_result($saltV);
			while ($stmt->fetch()) {
				$salt = $saltV;
			}
			$stmt->close();
		}
		//hash the password
		$hashed_password = hash('sha512',$currpassword.$salt);
		//compare the hashed password with database
		$query = "SELECT `salt` FROM `users` WHERE `email_address` = '$user' AND `password` = '$hashed_password'";
		if ($stmt = $link->prepare($query)) {
			$stmt->execute();
			$stmt->bind_result($saltV);
			while ($stmt->fetch()) {
				$found = 'true';
			}
			$stmt->close();
		}
		
		//if password is correct
		if($found == 'true'){
			//make sure provided new password match confirmation

			$newpassword = $_POST['newpswd'];
			$connewpassword = $_POST['connewpswd'];
			
			if($newpassword == $connewpassword){
				$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
				shuffle($seed);
				$salt = '';
				foreach (array_rand($seed, 60) as $k) 
				$salt .= $seed[$k];
				$password = hash('sha512',$newpassword.$salt);
				$stmt = $link->prepare("UPDATE `users` SET `salt`='$salt',`password`='$password' WHERE `email_address` = '$user' AND `clientid` = '$clientid'");
				$stmt->execute();
				$stmt->close();
				//password changed successfully
				header("location: ../profile-security.php?success=1");
				
				
			}else{
				//password don't match confirmation
				header("location: ../profile-security.php?error=2");
			}
			
		}else{
			// current password provided is not correct
			header("location: ../profile-security.php?error=1");
		}
		
	}else{
		//minimum 6 chars password fields
		header("location: ../profile-security.php?error=3");
	}
}

?>