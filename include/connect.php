<?php
if(session_id() == '') {
    session_start();
}
$link = mysqli_connect("localhost","dalysoft_admin","Amelhibamalak10@","dalysoft_grocery") or die("Error 11" . mysqli_error($link)); 
$pass1 = 'false';
$pass2 = 'false';
if (isset($_SESSION['user'])){
	
	$found = 'false';
	//check if user has signed out from different device:
	$result = mysqli_query($link, "SELECT `id` FROM `logged-in-users` WHERE `user` = '".$_SESSION['user']."'");
	while($row=mysqli_fetch_array($result)){
		$found = 'true';
	}
	
	if ($found == 'true'){
		$pass1 = 'true';
		$user = $_SESSION['user'];
		$clientid = '';
		//check if the user is admin
		$result = mysqli_query($link, "SELECT `role`, `clientid` FROM `users` WHERE `email_address` = '$user'");
		while ($row=mysqli_fetch_array($result)){
			$role = $row['role'];
			$clientid = $row['clientid'];
		}

		//check if user is still not activated via email
		/*
		$result = mysqli_query($link, "SELECT * FROM `users` WHERE `email_address` = '$user' AND `active` = '0'");
		$found = 'false';
		while ($row=mysqli_fetch_array($result)){
		$found = 'true';
		$role = $row['role'];
		}
		if ($found == 'true' && basename($_SERVER['PHP_SELF']) <> 'profile.php' && basename($_SERVER['PHP_SELF']) <> 'activate.php'){
		header("location: profile");
		}
		*/
	}else{
	unset($_SESSION['user']);
	$pass1 = 'false';
	}
}

if(isset($_COOKIE['userid']) && isset($_COOKIE['tokenid'])){
	$id = mysqli_real_escape_string($link, $_COOKIE['userid']);
	$token = mysqli_real_escape_string($link, $_COOKIE['tokenid']);
	
	$token_hashed = hash("sha256", $token);
	$timenow = time();
	
	$result = mysqli_query($link, "SELECT `user` FROM `logged-in-users` WHERE `id` = '$id' AND `token` = '$token_hashed' AND `endtime` > '".$timenow."'");

	$found = 'false';
	$email = '';
	$clientid = '';
	while($row=mysqli_fetch_array($result)){
		$found = 'true';
		$email = $row['user'];
	}
	
	if ($found == 'true'){
		$pass2 = 'true';
		$_SESSION['user'] = $email;
		$user = $email;
		$result = mysqli_query($link, "SELECT `clientid` FROM `users` WHERE `email_address` = '$email'");
		while($row=mysqli_fetch_array($result)){
			$clientid = $row['clientid'];
		}
	}
}
if($pass1 == 'false' && $pass2 = 'false'){
	if(!isset($preventLoginPageLoop)){header('location: login.php');}
}
?>