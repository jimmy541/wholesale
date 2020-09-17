<?php
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password'])){
	if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['password'])){
		
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$email = $_POST['email'];
			$display_code = '';
			if(isset($_POST['display_code']) && !empty($_POST['display_code'])){
				$display_code = $_POST['display_code'];
			}else{
				$display_code = $firstName;
			}
			$role = $_POST['user_role'];
			$allow_price_override = '0';
			$allow_free_override = '0';
			$show_assigned_customers = '0';
			
			if(isset($_POST["allow_limited_override"])){
				$allow_price_override = '1';
			}
			
			if(isset($_POST["allow_free_override"])){
				$allow_free_override = '1';
			}
			
			if(isset($_POST["show_assigned_customers"])){
				$show_assigned_customers = '1';
			}
			
			
			$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
			shuffle($seed);
			$salt = '';
			foreach (array_rand($seed, 60) as $k) 
			$salt .= $seed[$k];
			$password = hash('sha512',$_POST['password'].$salt);
			
			
			
			$todayDate = date('Y-m-d');
			$activationCode = hash("sha256", rand(100, 5000).$salt); // do not remove - also used to create new setting id in settings table
			
			$found = 'false';
			$query = "SELECT `email_address` FROM `users` WHERE `email_address` = ?";
			if ($stmt = $link->prepare($query)) {
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$stmt->bind_result($eml);
				while ($stmt->fetch()) {
					$found = 'true';
				}
				$stmt->close();
			}
			if ($found == 'false'){
				$query = "INSERT INTO `users`(`uid`,`password`, `salt`, `first_name`, `last_name`, `display_code`, `role`, `email_address`, `date_created`, `active`, `activation-code`, `failed_attempts`, `clientid`, `email_verified`, `allow_price_override`, `allow_free_override`, `show_assigned_customers_only`) VALUES (UUID(),?,?,?,?,?,?,?,?,?,?,?,?,'1',?,?,?)";
				$activeV = '1';
				if($role == 'Administrator'){
					$allow_price_override = '1';
					$allow_free_override = '1';
				}
				$fatmps = '0';
				if ($stmt = $link->prepare($query)) {
					$stmt->bind_param("sssssssssssssss", $password,$salt,$firstName,$lastName,$display_code,$role,$email,$todayDate,$activeV,$activationCode,$fatmps, $clientid, $allow_price_override, $allow_free_override, $show_assigned_customers);
					

					$stmt->execute();
					$stmt->close();
				}
				header('location: ../list-users.php');
			}
		
	}
}
// used in javascript to check if 
if (isset($_POST['userToCheck'])){
	if (!empty($_POST['userToCheck'])){
	
	$userToCheck = mysqli_real_escape_string($link, $_POST['userToCheck']);
	$found = 'false';
	$query = "SELECT `clientid` FROM `users` WHERE `email_address` = ?";
			if ($stmt = $link->prepare($query)) {
				$stmt->bind_param("s", $userToCheck);
				$stmt->execute();
				$stmt->bind_result($clnt);
				while ($stmt->fetch()) {
					$found = 'true';
				}
				$stmt->close();
			}
	echo $found;
	
	}
}

?>