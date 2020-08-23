<?php
$preventLoginPageLoop = 'fd5as431';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 
$email = '';
$password = '';
$found = 'false';
$active = '0';

if (isset($_POST['email']) && isset($_POST['password'])){
	if (!empty($_POST['email']) && !empty($_POST['password'])){
		$email = $_POST['email'];
		$password = $_POST['password'];
		$email_escaped = $email;
		$password_escaped = $password;
		$salt = '';
		
		
		$query = "SELECT `salt` FROM `users` WHERE `email_address` = ?";
		if ($stmt = $link->prepare($query)) {
			
			$stmt->bind_param("s", $email_escaped);
			
			$stmt->execute();
			
			$stmt->bind_result($saltV);
			
			while ($stmt->fetch()) {
				$salt = $saltV;
			}
			$stmt->close();
			
		}
		
		
		$hashed_password = hash('sha512',$password_escaped.$salt);
		$failed_attempts = 0;
		
		$query = "SELECT `active`, `salt` FROM `users` WHERE `email_address` = ? AND `password` = ?";
		if ($stmt = $link->prepare($query)) {
			$stmt->bind_param("ss", $email_escaped, $hashed_password);
			

			$stmt->execute();
			$stmt->bind_result($activeV, $saltV);
			while ($stmt->fetch()) {
				$found = 'true';
				$active = $activeV;
				$salt = $saltV;
			}
			$stmt->close();
		}
		
		if ($found == 'false'){
					$query2 = "UPDATE `users` SET `failed_attempts` = `failed_attempts` + 1 WHERE `email_address` = ?";
					if ($stmt2 = $link->prepare($query2)) {
						$stmt2->bind_param("s", $email_escaped);
						
						$stmt2->execute();
						$stmt2->close();
					}
				
				
			
			
			$_SESSION['token'] = hash("sha256", rand(100, 1000000));
			unset($_SESSION['user']);
			header("location: ../login.php?submit=nf&token=".$_SESSION['token']);
		}elseif ($found == 'true'){
			
			
			$_SESSION['user'] = $email_escaped;
			
			
			
			$query = "UPDATE `users` SET `failed_attempts` = '0' WHERE `email_address` = ?";
			if ($stmt = $link->prepare($query)) {
				$stmt->bind_param("s", $email_escaped);
				
				$stmt->execute();
				$stmt->close();
			}
			
			if ($active == '1'){
			$cookietime = time() + (86400 * 30);
			$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
			shuffle($seed);
			$cookie_value1 = '';
			foreach (array_rand($seed, 60) as $k) 
			$cookie_value1 .= $seed[$k];
			$cookie_value1 = hash("sha256", $email_escaped.$cookie_value1);
			setcookie("userid", $cookie_value1, $cookietime, "/"); // 86400 = 1 day
			$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
			shuffle($seed);
			$cookie_value2 = '';
			foreach (array_rand($seed, 60) as $k) 
			$cookie_value2 .= $seed[$k];
			setcookie("tokenid", $cookie_value2, $cookietime, "/"); // 86400 = 1 day
			$token_hashed = hash("sha256", $cookie_value2);
			
			$query = "INSERT INTO `logged-in-users`(`user`, `id`, `token`, `endtime`) VALUES (?, ?, ?, ?)";
			if ($stmt = $link->prepare($query)) {
				$stmt->bind_param("ssss", $email_escaped, $cookie_value1, $token_hashed, $cookietime);
				
				$stmt->execute();
				$stmt->close();
			}
				
			header("location: ../dashboard.php");
			
			}else{
				
			header("location: ../profile.php");
			
			}
		}	
	}else{
		
	$_SESSION['token'] = hash("sha256", rand(100, 1000000));
	unset($_SESSION['user']);
	header("location: ../login.php?submit=empty".$_SESSION['token']);
	}
}else{
	
$_SESSION['token'] = hash("sha256", rand(100, 1000000));
	unset($_SESSION['user']);
	header("location: ../login.php?submit=empty".$_SESSION['token']);
}
?>