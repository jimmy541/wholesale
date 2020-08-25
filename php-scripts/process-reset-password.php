<?php
$preventLoginPageLoop = 'fd5as431';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
if (isset($_POST['newpswd']) && isset($_POST['connewpswd']) && isset($_POST['email']) && isset($_POST['id']) && isset($_POST['token']) ){
	//make sure password length is minimum 6 chars.
	if (strlen($_POST['newpswd']) > 5 || strlen($_POST['connewpswd']) > 5 && $_POST['connewpswd'] == $_POST['newpswd']){
		//make sure the request is valid. 
				
		$token =  mysqli_real_escape_string($link, $_POST['token']);
		$token2 = mysqli_real_escape_string($link, $_POST['id']);
		$email = 	mysqli_real_escape_string($link, $_POST['email']);
		
		
		
		$found = 'false';
			$stmt = $link->prepare("SELECT `id` FROM `password_resets` WHERE `email` = ? AND `token` = ? AND `token2` = ? AND `reseted` = '0'");
			$stmt->bind_param('sss', $email, $token, $token2);
			$stmt->execute();
			$stmt->bind_result($cu);
			while($stmt->fetch()){
				$found = 'true';
			}
			$stmt->close();
		
		//if valid request
		if($found == 'true'){
			//make sure provided new password match confirmation

			$newpassword = $_POST['newpswd'];
			
			
			
				$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
				shuffle($seed);
				$salt = '';
				foreach (array_rand($seed, 60) as $k) 
				$salt .= $seed[$k];
				$password = hash('sha512',$newpassword.$salt);
				$stmt = $link->prepare("UPDATE `users` SET `salt`='$salt',`password`='$password' WHERE `email_address` = '$email'");
				$stmt->execute();
				$stmt->close();
				//password changed successfully
				header("location: ../login.php?pwdrst=1");
				
				
			
			
		}else{
			// No match found
			header("location: ../login.php?pwdrst=2");
		}
		
	}else{
		//minimum 6 chars password fields
		header("location: ../login.php?error=2");
	}
}
?>