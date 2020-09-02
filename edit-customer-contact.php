<?php $page_title = 'Edit Customer Contact';?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php

$business_name = '';
$account = '';
$found = 'false';
$active = 'no';
$typeofcontact = '';
if(isset($_GET['hid']) && !empty($_GET['hid']) && isset($_GET['token']) && !empty($_GET['token']) && isset($_GET['account']) && !empty($_GET['account'])){
	$hid = $_GET['hid'];
	$account = $_GET['account'];
	$token = $_GET['token'];
}

$query="SELECT `business_name`, `account_number` FROM `customers` WHERE `hashed_id` = ? AND `clientid` = ? AND `account_number` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('sss', $token, $clientid, $account);
$stmt->execute();
$stmt->bind_result($bn, $an);
 //switch to false when done testing
while ($stmt->fetch()) {
	$found = 'true';
	$business_name = $bn;
	$account_number = $an;
	
}

$query="SELECT `active`, `type_of_contact` FROM `customer_contacts` WHERE `hashed_id` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $hid);
$stmt->execute();
$stmt->bind_result($ac, $toc);
 //switch to false when done testing
while ($stmt->fetch()) {
	$active = $ac;
	$typeofcontact = $toc;

}
if ($found == 'true'){

$options = '';
$query="SELECT `id`, `type` FROM `customer_contact_types` ORDER BY `type` ASC";
$stmt = $link->prepare($query);
$stmt->execute();
$stmt->bind_result($dd, $tp);
 //switch to false when done testing
while ($stmt->fetch()) {
	$sel = '';
	if($dd == $typeofcontact){$sel=" selected";}
	$options .= '<option value="'.$dd.'" '.$sel.'>'.htmlspecialchars($tp).'</option>';
}	
	
$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<span class="info-message-red">Role and Full Name are required.</span>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<span class="info-message-green">Successfully Saved.</span>';}
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
	
	<h2><?php echo htmlspecialchars($account_number).', '.htmlspecialchars($business_name); ?></h2><br />
	
	<form  action="php-scripts/process-edit-customer-contacts.php" method="post" autocomplete="off">
	<input type="hidden" id="account-number" name="account-number" value="<?php echo htmlspecialchars($account); ?>"/>
	<input type="hidden" id="hid" name="hid" value="<?php echo htmlspecialchars($hid); ?>"/>
	<input type="hidden" id="token" name="token" value="<?php echo htmlspecialchars($token); ?>"/>
	<?php echo $responseMsg; ?>
		
			<h4 class="mb-3">General Info</h4>
			
			<div class="custom-control custom-switch">
					<input class="custom-control-input" type="checkbox" id="active" name="active" <?php if($active=='yes'){echo 'checked';} ?>>
					<label class="custom-control-label" for="active">Active</label>
			</div><br>
			
			<div class="row">		
				<div class="col-md-6 mb-3">
					<label for="">Role:*</label>
					<select class="form-control" id="type_of_contact" name="type_of_contact"><?php echo $options; ?></select>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Full Name:*</label>
					<input class="form-control"  type="text" id="full_name" name="full_name" value="<?php echo getValue($link, $hid, 'full_name'); ?>"/>
				</div>
			</div>
				
				<hr class="mb-4">
				<h4 class="mb-3">Contact Info</h4>
				
			<div class="row">	
				<div class="col-md-5 mb-3">
					<label for="">Phone Number:</label>
					<input class="form-control" type="text" id="phone_number" name="phone_number" value="<?php echo getValue($link, $hid, 'phone_number'); ?>"/>
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extension:</label>
					<input class="form-control" type="text" id="ext" name="ext" placeholder="Ext." value="<?php echo getValue($link, $hid, 'ext'); ?>"/>
				</div>
				<div class="col-md-5 mb-3">
					<label for="">Fax:</label>
					<input class="form-control" type="text" id="fax" name="fax" value="<?php echo getValue($link, $hid, 'fax'); ?>"/>
				</div>
			</div>
			<div class="mb-3">
					<label for="">Email:</label>
					<input class="form-control" type="text" id="email" name="email" value="<?php echo getValue($link, $hid, 'email'); ?>"/>
			</div>
			
			<hr class="mb-4">
			<div class="mb-3">
				<button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
			</div>
		
	</form>
	<!-- close col -->
		</div>
	<!-- close row -->
	</div>
<!-- close container -->
</div>
<?php }else{
	echo 'oops!!! this page does not exist.';
}

function getValue($link, $hid, $vlu){
	$vl = '';
	$query = "SELECT `$vlu` FROM `customer_contacts` WHERE `hashed_id` = ?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $hid);
	$stmt->execute();
	$stmt->bind_result($vl);
	$stmt->fetch();
	return htmlspecialchars($vl);
}

?>

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>