<?php $page_title = 'Edit User';
$more_css = '';
$more_script = '<script type="text/javascript" src="js/form-validation.js"></script>';
?>

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<?php
$user_code = '';
$found = 'false';
$first_name = '';
$last_name = '';
$display_code = '';
$email = '';
$user_role = '';
$allow_limited_override = '';
$allow_free_override = '';
$show_assigned_customers_only = '';
if(isset($_GET['user']) && !empty($_GET['user'])){
	$user_code = $_GET['user'];
	
	$query="SELECT `email_address`, `first_name`, `last_name`, `display_code`, `role`, `allow_price_override`, `allow_free_override`, `show_assigned_customers_only` FROM `users` WHERE `uid` = ? AND `clientid` = ?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('ss', $user_code, $clientid);
	$stmt->execute();
	$stmt->bind_result($em, $fn, $ln, $dc, $ro, $apo, $afo, $saco);
	 //switch to false when done testing
	while ($stmt->fetch()) {
		$found = 'true';
		$email = $em;
		$first_name = $fn;
		$last_name = $ln;
		$display_code = $dc;
		$user_role = $ro;
		$allow_limited_override = $apo;
		$allow_free_override = $afo;
		$show_assigned_customers_only = $saco;
		
		
	}
}
if ($found == 'true'){	
$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<div class="alert alert-danger" role="alert">Item code and description fields are required.</div>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<div class="alert alert-success" role="alert">Successfully Added.</div>';}
?>

<div class="container-fluid">
	<!-- open row -->
	<div class="row">
		<!-- open col -->
		<div class="col">
			<div class="card">
			<div class="card-body">
			<?php echo $responseMsg; ?>
			<form  id="newuserform" action="php-scripts/process-edit-user.php" method="post" autocomplete="off">
			<input class="form-control" autocomplete="false" name="hidden" type="text" style="display:none;">
			<input class="form-control" type="hidden" value="<?php echo htmlspecialchars($user_code) ?>" name="usercode" />
				
					<h4>Login Info</h4>
					
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="">Email:</label>
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
					<h4>About</h4>
					
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
								<option <?php if($user_role=='Administrator'){echo 'selected';} ?>>Administrator</option>
								<option <?php if($user_role=='Backend Operator'){echo 'selected';} ?>>Backend Operator</option>
								<option <?php if($user_role=='Sales Representative'){echo 'selected';} ?>>Sales Representative</option>
							</select>
						</div>
					</div>
					<hr class="mb-4">
			<h4>Settings</h4>
			<div class="form-group">
			<div class="form-check">
			  <input class="form-check-input" type="checkbox" value="" id="allow_limited_override" name="allow_limited_override" <?php if($allow_limited_override == '1'){echo 'checked';} if($user_role == 'Administrator'){echo 'disabled';}  ?>>
			  <label class="form-check-label" for="allow_limited_override">
				Allow Limited Price Override
			  </label>
			 
			</div>
		  </div>
		  <div class="form-group">
			<div class="form-check">
			  <input class="form-check-input" type="checkbox" value="" id="allow_free_override" name="allow_free_override" <?php if($allow_free_override == '1'){echo 'checked';} if($user_role == 'Administrator'){echo 'disabled';} ?>>
			  <label class="form-check-label" for="allow_free_override">
				Allow Free Price Override
			  </label>
			 
			</div>
		  </div>
		   <div class="form-group">
				<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="show_assigned_customers" name="show_assigned_customers" <?php if($show_assigned_customers_only == '1'){echo 'checked';} if($user_role == 'Administrator'){echo 'disabled';} ?>>
				<label class="form-check-label" for="show_assigned_customers">
				Show Assigned Accounts Only
				</label>
     
				</div>
			</div>
					
					<hr class="mb-4">
					<div class="mb-3">
						<button class="btn btn-primary shadow btn-lg btn-block" type="submit">Save</button>
					</div>
				
				

			<span style="color:red; font-size:20px;"><?php /*echo $errorMessage;*/ ?></span>
			</form>
			</div>
			</div>
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