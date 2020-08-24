<?php $page_title = 'Reset Password';
$preventLoginPageLoop = 'fd5as431';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php
if (isset($_SESSION['user'])){
	header('location: dashboard.php');
exit();
}
?>

<?php
$success_message = '';
if (isset($_GET['status'])){
	if (!empty($_GET['status'])){
		if ($_GET['status'] == 'sent'){
			$success_message = 'An email with reset instruction has been sent to you.';
		}
	}
}



?>


<center><div class="text-center" id="login-form">
	
	<span style="display:none; color:red;" id="email-status"></span>
	<?php echo '<div class="alert alert-success" role="alert">'.$success_message.'</div>'; ?>
	
	<form method="post" action="php-scripts/send-reset-password-link.php" class="form-signin">
	<h1 class="h3 mb-3 font-weight-normal">Reset Password</h1>
		
	<label class="sr-only" for="email">* Email Address</label>
	<input class="form-control" type="text" name="email" id="email" placeholder="* Email Address" autocomplete="off" /><br>
	
	<!--<div class="g-recaptcha" data-sitekey="6LedkEgUAAAAAAwqNg6VHY9ei5T8VjKRD29xl3w5"></div>-->
	<button class="btn btn-lg btn-primary btn-block" id="resetbtn" type="submit">Submit</button>
	</form>
</div>






<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>