<?php
$preventLoginPageLoop = 'fd5as431';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
//require_once('mail.php');

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['company_name'])){
	if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['company_name'])){
		//$recaptcha_secret = "6LedkEgUAAAAAMNs2jtuHW2zw8PTNPOBhwgDo02U";
        //$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
        //$response = json_decode($response, true);	
		//if($response["success"] === true){
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$email = $_POST['email'];
			$companyname = $_POST['company_name'];
			$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
			shuffle($seed);
			$salt = '';
			foreach (array_rand($seed, 60) as $k) 
			$salt .= $seed[$k];
			$password = hash('sha512',$_POST['password'].$salt);
			
			
			$role = 'Owner';
			$todayDate = date('Y-m-d');
			$activationCode = hash("sha256", rand(100, 5000).$salt); // do not remove - also used to create new setting id in settings table
			
			$found = 'false';
			$clientid = 5415;
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
			$result = mysqli_query($link, "SELECT (MAX(`clientid`) + 4) as mx FROM `users`");
			while($row=mysqli_fetch_array($result)){
				$clientid = $row['mx'];
			}
			
			
			
			if ($found == 'false'){
				$query = "INSERT INTO `users`(`uid`,`password`, `salt`, `first_name`, `last_name`, `role`, `email_address`, `date_created`, `active`, `activation-code`, `failed_attempts`, `clientid`) VALUES (UUID(),?,?,?,?,?,?,?,?,?,?,?)";
				$activeV = '1';
				$fatmps = '0';
				if ($stmt = $link->prepare($query)) {
					$stmt->bind_param("sssssssssss", $password,$salt,$firstName,$lastName,$role,$email,$todayDate,$activeV,$activationCode,$fatmps, $clientid);
					

					$stmt->execute();
					$stmt->close();
				}

				$query = "INSERT INTO `clients`(`clientid`, `company_name`, `date_created`) VALUES ('$clientid', ?, now())";
				if ($stmt = $link->prepare($query)) {
					$stmt->bind_param("s", $company_name)
					$stmt->execute();
					$stmt->close();
				}
				$query = "INSERT INTO `settings`(`hashed_id`, `clientid`, `setting_name`, `setting_value`) VALUES ('$activationCode','$clientid','round_number_format','4')";
				if ($stmt = $link->prepare($query)) {
					$stmt->execute();
					$stmt->close();
				}
				/*
				//send activation code
				$mail->addAddress($email);     // Add a recipient
				$mail->Subject = 'Activate New Account at 7awel.com';

				$message = '<!DOCTYPE html><html dir="rtl" lang="ar"><head><meta charset="utf-8"><title>Activate new account</title><style>body{font-size: 20px;line-height: 30px;}h1{color: #007dc6;}</style></head><body><h1 style="direction:rtl">&#1605;&#1585;&#1581;&#1576;&#1575;&#1611; &#1576;&#1603;&#1605; &#1601;&#1610; &#1605;&#1608;&#1602;&#1593; &#1581;&#1575;&#1608;&#1604;.</h1>';
				$message .= '<div style="direction:rtl">&#1604;&#1602;&#1583; &#1602;&#1605;&#1578;&#1605; &#1576;&#1578;&#1587;&#1580;&#1610;&#1604; &#1581;&#1587;&#1575;&#1576; &#1580;&#1583;&#1610;&#1583; &#1601;&#1610; &#1575;&#1604;&#1605;&#1608;&#1602;&#1593;. &#1606;&#1608;&#1583; &#1576;&#1588;&#1603;&#1585;&#1603;&#1605; &#1593;&#1604;&#1609; &#1575;&#1604;&#1573;&#1606;&#1590;&#1605;&#1575;&#1605; &#1604;&#1604;&#1605;&#1608;&#1602;&#1593; &#1608;&#1606;&#1578;&#1605;&#1606;&#1609; &#1604;&#1603;&#1605; &#1571;&#1608;&#1602;&#1575;&#1578; &#1605;&#1605;&#1578;&#1593;&#1577;.<br />';
				$message .= ' &#1571;&#1606;&#1578;&#1605; &#1593;&#1604;&#1609; &#1576;&#1593;&#1583; &#1582;&#1591;&#1608;&#1577; &#1608;&#1575;&#1581;&#1583;&#1577; &#1605;&#1606; &#1578;&#1601;&#1593;&#1610;&#1604; &#1581;&#1587;&#1575;&#1576;&#1603;&#1605;  &#1601;&#1610; &#1581;&#1575;&#1608;&#1604;.<br />';
				$message .= '&#1575;&#1604;&#1585;&#1580;&#1575;&#1569; &#1575;&#1604;&#1602;&#1610;&#1575;&#1605; &#1576;&#1575;&#1604;&#1590;&#1594;&#1591; &#1593;&#1604;&#1609; &#1575;&#1604;&#1585;&#1575;&#1576;&#1591; &#1575;&#1604;&#1570;&#1578;&#1610; &#1603;&#1610; &#1578;&#1578;&#1605;&#1603;&#1606;&#1608;&#1575; &#1605;&#1606; &#1578;&#1601;&#1593;&#1610;&#1604; &#1581;&#1587;&#1575;&#1576;&#1603;&#1605; <a href="http://7awel.com/activate?email='.$email.'&id='.$activationCode.'">'.'&#1573;&#1590;&#1594;&#1591; &#1607;&#1606;&#1575;</a></div></body></html>';

				$mail->Body    = $message;
				
				$mail->Send();
				*/
				
				
				$_SESSION['user'] = $email;
				
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
					$stmt->bind_param("ssss", $email,$cookie_value1,$token_hashed,$cookietime);
					$stmt->execute();
					$stmt->close();
				}	
				
				
				header("location: ../profile.php");
			}else{
				header("location: ../register.php?status=email-exists&reason=".hash("sha256", $email)."&email=$email");
			}
		//}else{
		// failed bot verification
		//header("location: ../register.php?status=3");
		//}
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