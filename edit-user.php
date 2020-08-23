<?php $page_title = 'Edit User';
$more_script = '<script type="text/javascript" src="js/form-validation.js"></script>';
//?>

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php
$user_code = '';
$found = 'false';
$first_name = '';
$last_name = '';
$display_code = '';
$email = '';
$role = '';
if(isset($_GET['user']) && !empty($_GET['user'])){
	$user_code = $_GET['user'];
	
	$query="SELECT `email_address`, `first_name`, `last_name`, `display_code`, `role` FROM `users` WHERE `uid` = ? AND `clientid` = ?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('ss', $user_code, $clientid);
	$stmt->execute();
	$stmt->bind_result($em, $fn, $ln, $dc, $ro);
	 //switch to false when done testing
	while ($stmt->fetch()) {
		$found = 'true';
		$email = $em;
		$first_name = $fn;
		$last_name = $ln;
		$display_code = $dc;
		$role = $ro;
		
	}
}
if ($found == 'true'){	
$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<span class="info-message-red">Item code and description fields are required.</span>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<span class="info-message-green">Successfully Added.</span>';}
?>
<br />
<div class="container">
	<!-- open row -->
	<div class="row">
		<!-- open col -->
		<div class="col">
			<h1>Edit user</h1>
			<?php echo $responseMsg; ?>
			<form  id="newuserform" action="php-scripts/process-edit-user.php" method="post" autocomplete="off">
			<input class="form-control" autocomplete="false" name="hidden" type="text" style="display:none;">
			<input class="form-control" type="hidden" value="<?php echo htmlspecialchars($user_code) ?>" name="usercode" />
				
					<h4 class="mb-3">Login Info</h4>
					
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="">Email:*</label>
							<input class="form-control"  type="email" id="useremail" name="useremail" value="<?php echo htmlspecialchars($email); ?>" autocomplete="off" disabled/>
						</div>
						<div class="col-md-6 mb-3">
							<label for="">Password:*</label>
							<div class="input-group">
								<input class="form-control"  type="password" id="password" name="password" value="......" autocomplete="off" disabled/>
								<div class="input-group-prepend">
									 <span class="input-group-text"><i class="fas fa-unlock-alt" id="unlockpwd" style="cursor:pointer"></i></span>
								</div>
							</div>
						</div>
					</div>
					<hr class="mb-4">
					<h4 class="mb-3">About</h4>
					
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="">First Name:*</label>
							<input class="form-control"  type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>"/>
						</div>
						<div class="col-md-6 mb-3">
							<label for="">Last Name:*</label>
							<input class="form-control" type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>"/>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="">Display Code:*</label>
							<input class="form-control" type="text"  id="display_code" name="display_code" value="<?php echo htmlspecialchars($display_code); ?>"/>
						</div>
						<div class="col-md-6 mb-3">
							<label for="">Role:*</label>
							<select class="form-control"   id="user_role" name="user_role">
								<option <?php if($role=='Administrator'){echo 'selected';} ?>>Administrator</option>
								<option <?php if($role=='Backend Operator'){echo 'selected';} ?>>Backend Operator</option>
								<option <?php if($role=='Sales Representative'){echo 'selected';} ?>>Sales Representative</option>
							</select>
						</div>
					</div>
					<hr class="mb-4">
					<div class="mb-3">
						<button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
					</div>
				
				

			<span style="color:red; font-size:20px;"><?php /*echo $errorMessage;*/ ?></span>
			</form>
		<!-- close col -->
		</div>
	<!-- close row -->
	</div>
<!-- close container -->
</div>
<?php }else{
	echo 'oops!!! this page does not exist.';
}?>





<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>