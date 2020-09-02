<?php $page_title = 'Edit Customer Settings';?>
<?php $more_script = '<script type="text/javascript" src="js/customer-settings.js"></script>';?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php

$responseMsg = '';

if(isset($_GET['account']) && !empty($_GET['account']) && isset($_GET['token']) && !empty($_GET['token'])){
	$account = $_GET['account'];
	$token = $_GET['token'];
}

$query="SELECT `account_number` FROM `customer_settings` WHERE `hashed_id` = ? AND `clientid` = '$clientid'";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $token);
$stmt->execute();
$stmt->bind_result($ac);
$found = 'false'; //switch to false when done testing
while ($stmt->fetch()) {
	$found = 'true';
}
$business_name = '';
$query="SELECT `business_name` FROM `customers` WHERE `account_number` = ? AND `clientid` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('ss', $account, $clientid);
$stmt->execute();
$stmt->bind_result($bn);
while ($stmt->fetch()) {
	$business_name = $bn;
}

if ($found == 'true'){
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<span class="info-message-red">Item code and description fields are required.</span>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<span class="info-message-green">Successfully Added.</span>';}
?>
<?php echo '<ul class="nav">
	<a class="nav-link" href="list-customers.php">Customers</a>
	<a class="nav-link" href="#">Edit Customer</a>
	<a class="nav-link" href="list-customers-contacts.php?account='.htmlspecialchars($account).'&token='.htmlspecialchars($token).'">Customer Contacts</a>
	<a class="nav-link" href="edit-customer-settings.php?account='.htmlspecialchars($account).'&token='.htmlspecialchars($token).'">Customer Settings</a>
</ul><hr>'; ?>
<div class="container-fluid">
<!-- open row -->
	<div class="row">
	<!-- open col -->
	<div class="col">
	<h2><?php echo htmlspecialchars($account).', '.htmlspecialchars($business_name); ?></h2><br />
	<?php echo $responseMsg; ?>
	<form  action="php-scripts/process-edit-customer-settings.php" method="post" autocomplete="off">
	<input type="hidden" name="account" value="<?php echo htmlspecialchars($account); ?>" />
	<input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />
		
			<h4 class="mb-3">General</h4>
			
			
			<div class="custom-control custom-switch">
					<input class="custom-control-input" type="checkbox" name="view_prices" id="view_prices" <?php echo ifchecked($link, $clientid, $account, 'view_prices'); ?>>
					<label class="custom-control-label" for="view_prices">Can View Prices</label>
			</div><br>
			
			<div class="custom-control custom-switch">
					<input class="custom-control-input" type="checkbox" name="can_place_order" id="can_place_order" <?php echo ifchecked($link, $clientid, $account, 'can_place_order'); ?>>
					<label class="custom-control-label" for="can_place_order">Can place order:</label>
			</div><br>
			
			<div class="custom-control custom-switch">
					<input class="custom-control-input" type="checkbox" name="can_view_history" id="can_view_history" <?php echo ifchecked($link, $clientid, $account, 'can_view_history'); ?>>
					<label class="custom-control-label" for="can_view_history">Can view order history:</label>
			</div><br>
			
			
			
			<div class="row">
				<div class="col-md-4 mb-3">
					<label for="">Pay in:   <small>Enter 0 for COD</small></label>
					<div class="input-group">
						<input class="form-control" type="number" min="0" name="terms" value="<?php echo getValue($link, $clientid, $account, 'terms') ?>" />
						<div class="input-group-prepend">
							<span class="input-group-text">Days</span>
						</div>
						
					</div>
				</div>
				
				<div class="col-md-4 mb-3">
					<label for="">Pricing Level</label>
					<select class="form-control" id="pricing_level" name="pricing_level"><?php echo optionsV($link, $clientid, $account, 'pricing_level'); ?></select>
				</div>
				<div class="col-md-4 mb-3" id="group-fields-dyn">
					<?php echo plV($link, $clientid, $account, 'pricing_level_value'); ?>
				</div>
			</div>
			
			<hr class="mb-4">
			<div class="mb-3">
				<button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
			</div>
		
	<span style="color:red; font-size:20px !important;"><?php /*echo $errorMessage;*/ ?></span>
	</form>
	<!-- close col -->
		</div>
	<!-- close row -->
	</div>
<!-- close container -->
</div>
<?php }else{
	echo '<h2>oops!!! This page does not exist</h2>';
}
function ifchecked($link, $clientid, $account_number, $vlu){
	$checked = getValue($link, $clientid,$account_number, $vlu);
	$nv = "";
	if ($checked == 'yes'){
		return "checked";
		
	}else{
		return "";
	}
}
function optionsV($link, $clientid, $account_number, $vlu){
	$selected = getValue($link, $clientid,$account_number, $vlu);
	$x1 = '';
	$x2 = '';
	$x3 = '';
	if ($selected == 'Normal'){$x1 = 'selected';}
	if ($selected == 'Decrease By %'){$x2 = 'selected';}
	if ($selected == 'Decrease By $'){$x3 = 'selected';}
	$options = '<option '.$x1.'>Normal</option>
			<option '.$x2.'>Decrease By %</option>
			<option '.$x3.'>Decrease By $</option>';
		return $options;
}
function plV($link, $clientid, $account_number, $vlu){
	$selected = getValue($link, $clientid,$account_number, 'pricing_level');
	$vl = getValue($link, $clientid,$account_number, 'pricing_level_value');
	$x = '';
	if ($selected == 'Decrease By %' || $selected == 'Decrease By $'){

	$x = '<label for="">'.$selected.'</label><input class="form-control" type="text" name="dby" value="'.$vl.'">';
	}
		return $x;
}
function getValue($link, $clientid, $account_number, $vlu){
	$vl = '';
	$query = "SELECT `$vlu` FROM `customer_settings` WHERE `clientid` = ? AND `account_number` = ?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('ss', $clientid, $account_number);
	$stmt->execute();
	$stmt->bind_result($vl);
	$stmt->fetch();
	return htmlspecialchars($vl);
	
}
?>

<!-- The following div closes the main body div -->
</div>




<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>