<?php $page_title = 'Replace Lost Password';
$preventLoginPageLoop = 'fd5as431';
$more_script = '<script type="text/javascript" src="js/form-validation.js"></script>';
?>

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php
if (isset($_SESSION['user'])){
	header('location: dashboard.php');
exit();
}

if (isset($_GET['email']) && isset($_GET['id']) && isset($_GET['token'])){
	if (!empty($_GET['email']) && !empty($_GET['id']) && !empty($_GET['email'])){
		
		$token =  $_GET['token'];
		$token2 = $_GET['id'];
		$email = $_GET['email'];
		
		$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
		$emailaddress = $email;
		
		if (preg_match($pattern, $emailaddress) === 1) {
			
			$stmt = $link->prepare("SELECT `id` FROM `password_resets` WHERE `email` = ? AND `token` = ? AND `token2` = ? AND `reseted` = '0'");
			$stmt->bind_param('sss', $emailaddress, $token, $token2);
			$stmt->execute();
			$found = 'false';
			while($stmt->fetch()){
				$found = 'true';
			}
			
			if ($found == 'true'){
			
			?>
		
			<center><div class="text-center" id="reset-password">
				<form method="post" action="php-scripts/process-reset-password.php" class="form-signin">
					<h1 class="h3 mb-3 font-weight-normal">Enter new password</h1>
					
					<label class="sr-only" for="newpswd">* New Password</label>
					<input class="form-control" type="password" name="newpswd" id="newpswd" placeholder="* New Password" autocomplete="off" /><br>
					<label class="sr-only" for="connewpswd">* Confirm Password</label>
					<input class="form-control" type="password" name="connewpswd" id="connewpswd" placeholder="* Confirm Password" autocomplete="off" /><br>
					<input type="hidden" name="email" value="<?php echo $emailaddress; ?>"/>
					<input type="hidden" name="id" value="<?php echo $token2; ?>"/>
					<input type="hidden" name="token" value="<?php echo $token; ?>"/>
					<!--<div class="g-recaptcha" data-sitekey="6LedkEgUAAAAAAwqNg6VHY9ei5T8VjKRD29xl3w5"></div>-->
					<button class="btn btn-lg btn-primary btn-block" id="resetbtn" type="submit">Submit</button>
				</form>
			</div></center>
	

			
			
			<?php }else{
				
				//record don't match
				echo '<div class="alert alert-danger" role="alert">Sorry, the page you have requested does not exist. Error code 5ffh98</div>';
			}
			
				
			
			}else{
				//email is not valid
				echo '<div class="alert alert-danger" role="alert">Sorry, the page you have requested does not exist. Error code 5llj5</div>';
			}
	}
}

?>






<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>