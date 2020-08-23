<?php 
$page_title = 'Login';
$preventLoginPageLoop = 'fd5as431';
?>
<?php
include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); 
if (isset($_SESSION['user'])){
	header('location: dashboard.php');
exit();
}
?>
<?php



$errorMessage = ''; 

if (isset($_GET['submit']) && isset($_SESSION['token'])){
	if (!empty($_GET['submit'])){
		if ($_GET['submit'] == 'empty' && $_GET['token'] == $_SESSION['token']){
			
			$errorMessage = 'error message'.'<br /><br />'; 
			unset($_SESSION['token']);			
		}elseif ($_GET['submit'] == 'nf' && $_GET['token'] == $_SESSION['token']){
			$errorMessage = 'Email and password don\'t match'.'<br /><br />';
			unset($_SESSION['token']);
		}
	}

}
if (isset($_GET['passreset']) && isset($_SESSION['token'])){
	if (!empty($_GET['passreset'])){
		if ($_GET['passreset'] == 'true' && $_GET['token'] == $_SESSION['token']){
			unset($_SESSION['token']);
			$errorMessage = 'error message 3'.'<br /><br />'; 
						
		}
	}

}


?>

<center><div class="text-center" id="login-form">
<form class="form-signin" action="php-scripts/process-login.php" method="post">
<img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
<h1 class="h3 mb-3 font-weight-normal">Login</h1>
<label for="email" class="sr-only">Email address</label>
<input class="form-control" placeholder="Email address" required autofocus type="email" id="email" name="email"/><br />
<label for="password" class="sr-only">Password</label>
<input type="password" id="password" name="password" class="form-control" placeholder="Password" required/><br>
<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

<span style="color:red; font-size:20px;"><?php echo $errorMessage; ?></span>
<span><a href="register.php" style="text-decoration:none;">Register</a></span> | <span><a href="reset-password.php" style="text-decoration:none;">Forgot Password</a></span>
</form>
</div>

</center>







<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>