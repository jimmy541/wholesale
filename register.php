<?php $page_title = 'Register';
$preventLoginPageLoop = 'fd5as431';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php
if (isset($_SESSION['user'])){
	header('location: dashboard.php');
exit();
}
?>
<script type="text/javascript" src="js/verify-registration.js"></script>
<?php
	$daysOptions = '';
	$yearsOptions = '';
	$monthsOptions = '';
	$startdate = date('Y', strtotime('110 years ago'));
	$enddate = date("Y");
	$years = range ($enddate,$startdate);
	foreach($years as $year)
	{
  		$yearsOptions .= '<option>'.$year."</option>";
	}
	
	
	$months = range (1,12);
	foreach($months as $month)
	{
  		$monthsOptions .= '<option>'.$month."</option>";
	}
	$days = range(1, 31);
	foreach($days as $day){
		$daysOptions .= '<option>'.$day.'</option>';
	}
	?>
	
<?php
$error_message = '';
$success_message = '';
if (isset($_GET['status']) && $_GET['reason'] && isset($_GET['email'])){
	if (!empty($_GET['status']) && !empty($_GET['reason']) && !empty($_GET['email'])){
		if ($_GET['status'] == 'email-exists' && hash("sha256", $_GET['email']) == $_GET['reason']){
			$error_message = 'Email exists';
		}
	}
}



?>


<center><div class="text-center" id="login-form">
	
	<span style="display:none; color:red;" id="email-status"></span>
	<?php echo '<span style="display:none; color:red;" id="email-status">'.$error_message.'</span>'; ?>
	<?php echo $success_message; ?>
	<form method="post" action="php-scripts/process-registration.php" id="registration-form" class="form-signin">
	<h1 class="h3 mb-3 font-weight-normal">Register</h1>
	<label class="sr-only" for="first_name">* First Name</label>
	<input class="form-control" type="text" name="first_name" id="first_name" placeholder="* First Name" autocomplete="off" autofocus/><br>
	
	<label class="sr-only" for="last_name">* Last Name</label>
	<input class="form-control" type="text" name="last_name" id="last_name" placeholder="* Last Name" autocomplete="off" /><br>
	
	<label class="sr-only" for="last_name">* Company Name</label>
	<input class="form-control" type="text" name="company_name" id="company_name" placeholder="* Company Name" autocomplete="off" /><br>
	
	<label class="sr-only" for="email">* Email Address</label>
	<input class="form-control" type="text" name="email" id="email" placeholder="* Email Address" autocomplete="off" /><br>
	
	<label class="sr-only" for="password">* Password</label>
	<input class="form-control" type="password" name="password" placeholder="* Password" id="password" /><br>
	
	
	<?php
		if (isset($_GET['status']) && $_GET['status'] == '3'){
				echo '<br/><span class="error-message-add-question" style="font-size:20px;">Email Exists</span><br />';
		}
	?>
	<!--<div class="g-recaptcha" data-sitekey="6LedkEgUAAAAAAwqNg6VHY9ei5T8VjKRD29xl3w5"></div>-->
	<button class="btn btn-lg btn-primary btn-block" id="registerbtn" type="submit">Register</button>
	<span><a href="login.php" style="text-decoration:none;">Login</a></span> | <span><a href="reset-password.php" style="text-decoration:none;">Forgot Password</a></span>
	</form>
</div>






<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>