<?php $page_title = 'Profile';
$more_script = '<script type="text/javascript" src="js/form-validation.js"></script>';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php
if (isset($_SESSION['user'])){
	$result = mysqli_query($link, "SELECT * FROM `users` WHERE `email_address` = '$user' AND `clientid` = '$clientid'");
	
	$active = '0';
	$email_verified = '0';
	$user_first_name = '';
	$user_last_name = '';
	$profile_picture = '';
	$display_code = '';
	$role = '';
	
	while($row=mysqli_fetch_array($result)){
		$active = $row['active'];
		$email_verified = $row['email_verified'];
		$user_first_name = htmlspecialchars($row['first_name']);
		$user_last_name = htmlspecialchars($row['last_name']);
		$profile_picture = htmlspecialchars($row['profile-picture']);
		$display_code = htmlspecialchars($row['display_code']);
		$role = htmlspecialchars($row['role']);
	}
	
	if ($email_verified == '0'){
		<a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Primary link</a>
	$message = '<br /><a href="resend-activation-link.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Resend Activation Link</a>';
		if (isset($_GET['sent'])){
		
			if ($_GET['sent'] == '1'){
			
			$message = '<br /><span style="font-size:20px; padding:20px; color:green;">Check message; (spam or junk)</span>';
			
			}
		}
	
	echo '<h1>Please Check your email</h1>';
	echo "We've sent you a link in your email to confirm your account<br>";
	echo "Please click the link to complete the registration process.<br>";
	
		
	echo $message;
	}
	else{
		//show profile:
		?>
		<ul class="nav">
			<a class="nav-link" href="#">General</a>
			<a class="nav-link" href="profile-security.php">Security</a>
		</ul>
		<hr>
	
		<?php
		$uploadmessage = '';
		if (isset($_GET['success'])){
			if ($_GET['success'] == '1'){
				$uploadmessage =  '<div class="alert alert-success" role="alert">
							Image changed successfully
					</div>';
			}
		}
		if (isset($_GET['successGP'])){
			if ($_GET['successGP'] == '1'){
				$uploadmessage =  '<div class="alert alert-success" role="alert">
							Changes have been saved
					</div>';
			}
		}
		if (isset($_GET['uploaderror']) && !empty($_GET['uploaderror'])){
			if ($_GET['uploaderror'] == '1'){
				//File is not an image
				$uploadmessage = '<div class="alert alert-danger" role="alert">Not a valid image format!</div>';
			}
			if ($_GET['uploaderror'] == '2'){
			//File is too large
			$uploadmessage = '<div class="alert alert-danger" role="alert">Image size is too large!</div>';
			}
			if ($_GET['uploaderror'] == '3'){
			//error uploading the file
			$uploadmessage = '<div class="alert alert-danger" role="alert">Error uploading the image. Please try again.</div>';
			}
		
		}
		?>
		
		
		<?php echo $uploadmessage; ?>
<div class="container">
<!-- open row -->
	<div class="row">
		<!-- open col -->
		<div class="col">
			<div class="mb-3">
				<label for="email">Email</label>
				<input class="form-control" type="text" id="user_email" name="user_email" placeholder="<?php echo $user; ?>" readonly />
			</div>		
				<h4 class="mb-3">Profile Image</h4>
				<div class="mb-3">
					<div class="card" style="width:18rem;cursor:pointer;" id="change-profile-image">
						<?php
						 if ($profile_picture != ''){echo '<img class="card-img-top" src="uploads/profile-image/'.$profile_picture.'" alt="Profile Image" />';}						 
						 ?>
						 <div class="card-body">
							<p class="card-text text-center">Click to change</p>
						 </div>
					 </div>
					<form action="upload.php" id="uploadform" method="post" enctype="multipart/form-data">
					<input type="file" name="fileToUpload" id="fileToUpload" style="display:none;" onchange="javascript:this.form.submit();">
					<input type="submit" value="Upload Image" name="submitbtn" style="display:none;">
					</form>
				</div>
				<form action="php-scripts/process-edit-profile.php" id="general-profile" method="post">
					
					<div class="row">	
						<div class="col-md-6 mb-3">
							<label for="user_fname">First Name</label>
							<input class="form-control" type="text" id="user_fname" name="user_fname" value="<?php echo $user_first_name; ?>" />	
						</div>
						<div class="col-md-6 mb-3">
							<label for="user_Lname">Last Name</label>
							<input class="form-control" type="text" id="user_Lname" name="user_Lname" value="<?php echo $user_last_name; ?>" />	
						</div>
					</div>
					
					<?php
					//if role = owner
					if($role == 'Owner'){?>
						<div class="mb-3">
							<label for="discode">Display Code</label>
							<input class="form-control" type="text" id="discode" name="discode" value="<?php echo $display_code; ?>" />	
						</div>
					<?php }
					
					?>
					
					<hr class="mb-4">
					<div class="mb-3">
						<button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
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