<?php $page_title = 'Profile';
$more_script = '<script type="text/javascript" src="js/form-validation.js"></script>';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php
if (isset($_SESSION['user'])){
	$result = mysqli_query($link, "SELECT * FROM `users` WHERE `email_address` = '$user' AND `clientid` = '$clientid'");
	
	$active = '0';
	$user_first_name = '';
	$user_last_name = '';
	$profile_picture = '';
	while($row=mysqli_fetch_array($result)){
		$active = $row['active'];
		$user_first_name = htmlspecialchars($row['first_name']);
		$user_last_name = htmlspecialchars($row['last_name']);
		$profile_picture = htmlspecialchars($row['profile-picture']);
	}
	
	if ($active == '0'){
	$message = '<br /><span style="font-size:20px; padding:20px;"><a href="resend-activation-link.php">Resend Activation Link</span>';
		if (isset($_GET['sent'])){
		
			if ($_GET['sent'] == '1'){
			
			$message = '<br /><span style="font-size:20px; padding:20px; color:green;">Check message; (spam or junk)</span>';
			
			}
		}
	
	echo '<span style="font-size:20px; display:block; padding:20px; margin-top:20px;">Not Sure what this is</span>';
	echo $message;
	}
	else{
		//show profile:
		?>
		<ul class="nav">
			<a class="nav-link" href="profile.php">General</a>
			<a class="nav-link" href="#">Security</a>
		</ul>
		<hr>
	
		<?php
		$uploadmessage = '';
		if (isset($_GET['success'])){
			if ($_GET['success'] == '1'){
				$uploadmessage =  '<div class="alert alert-success" role="alert">
							Password updated successfully
					</div>';
			}
		}
		if (isset($_GET['error'])){
			if ($_GET['error'] == '1'){
				
				$uploadmessage = '<div class="alert alert-danger" role="alert">Please check the current password.</div>';
			}
			if ($_GET['error'] == '2'){
			
			$uploadmessage = '<div class="alert alert-danger" role="alert">New password don\'t match confirmed password</div>';
			}
			if ($_GET['error'] == '3'){
			//error uploading the file
			$uploadmessage = '<div class="alert alert-danger" role="alert">Password provided must be at least 6 char. long.</div>';
			}
		
		}
		?>
		
		
		<?php echo $uploadmessage; ?>
<div class="container-fluid">
<!-- open row -->
	<div class="row">
		<!-- open col -->
		<div class="col">
			<div class="mb-3">
				<label for="email">Email</label>
				<input class="form-control" type="text" id="user_email" name="user_email" placeholder="<?php echo $user; ?>" readonly />
			</div>		
				
				<form action="php-scripts/process-edit-profile.php" id="security-profile" method="post">
					
						
					<div class="mb-3">
							<label for="currpswd" >Current Password:</label>
							<input class="form-control" type="password" id="currpswd" name="currpswd" />
						</div>		
					<div class="row">
					
						<div class="col-md-6 mb-3">
							<label for="newpswd" >New Password:</label>
							<input class="form-control" type="password" id="newpswd" name="newpswd" />
						</div>
						<div class="col-md-6 mb-3">
							<label for="connewpswd" >Confirm Password:</label>
							<input class="form-control" type="password" id="connewpswd" name="connewpswd" />
						</div>
					</div>
					<hr class="mb-4">
					<div class="mb-3">
						<button class="btn btn-primary shadow btn-lg btn-block" type="submit">Save</button>
					</div>
				</form>
				
		</div>
	</div>
</div>
				
	<?php	
	}
}else{
echo '<div class="activation-page-message"><a href="login.php" style="text-decoration:none;">Message here</a></div>';

}

?>

<script>
$("#change-profile-image").click(function () {
	
    $("#fileToUpload").trigger('click');
});
</script>


<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>