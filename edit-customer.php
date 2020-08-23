<?php $page_title = 'Edit Customer';
$more_script = '<script type="text/javascript" src="js/copy-address.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script><script type="text/javascript" src="js/form-validation.js"></script>
<script type="text/javascript" src="js/form-validation.js"></script>';?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php

$business_name = '';
$account_number = '';
$found = 'false';
$checked = '';
if(isset($_GET['account']) && !empty($_GET['account']) && isset($_GET['token']) && !empty($_GET['token'])){
	$account = $_GET['account'];
	$token = $_GET['token'];
}
$query="SELECT `business_name`, `account_number`, `shipping_state`, `mailing_state`, `active` FROM `customers` WHERE `hashed_id` = ? AND `clientid` = ? AND `account_number` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('sss', $token, $clientid, $account);
$stmt->execute();
$stmt->bind_result($bn, $an, $ss, $ms, $ac);
 //switch to false when done testing
while ($stmt->fetch()) {
	$found = 'true';
	$business_name = $bn;
	$account_number = $an;
	$checked = $ac;
	$sstate = $ss;
	$mstate = $ms;
	
}
if ($found == 'true'){
	function selectedState($state, $vlu){
	$sel = '';
	if($state == $vlu){
		$sel = 'selected';
	}
	return $sel;
}
	$statesChoices1 = '
	<option value="" '.selectedState($sstate, "").'></option>
	<option value="AL" '.selectedState($sstate, "AL").'>Alabama</option>
	<option value="AK" '.selectedState($sstate, "AK").'>Alaska</option>
	<option value="AZ" '.selectedState($sstate, "AZ").'>Arizona</option>
	<option value="AR" '.selectedState($sstate, "AR").'>Arkansas</option>
	<option value="CA" '.selectedState($sstate, "CA").'>California</option>
	<option value="CO" '.selectedState($sstate, "CO").'>Colorado</option>
	<option value="CT" '.selectedState($sstate, "CT").'>Connecticut</option>
	<option value="DE" '.selectedState($sstate, "DE").'>Delaware</option>
	<option value="DC" '.selectedState($sstate, "DC").'>District Of Columbia</option>
	<option value="FL" '.selectedState($sstate, "FL").'>Florida</option>
	<option value="GA" '.selectedState($sstate, "GA").'>Georgia</option>
	<option value="HI" '.selectedState($sstate, "HI").'>Hawaii</option>
	<option value="ID" '.selectedState($sstate, "ID").'>Idaho</option>
	<option value="IL" '.selectedState($sstate, "IL").'>Illinois</option>
	<option value="IN" '.selectedState($sstate, "IN").'>Indiana</option>
	<option value="IA" '.selectedState($sstate, "IA").'>Iowa</option>
	<option value="KS" '.selectedState($sstate, "KS").'>Kansas</option>
	<option value="KY" '.selectedState($sstate, "KY").'>Kentucky</option>
	<option value="LA" '.selectedState($sstate, "LA").'>Louisiana</option>
	<option value="ME" '.selectedState($sstate, "ME").'>Maine</option>
	<option value="MD" '.selectedState($sstate, "MD").'>Maryland</option>
	<option value="MA" '.selectedState($sstate, "MA").'>Massachusetts</option>
	<option value="MI" '.selectedState($sstate, "MI").'>Michigan</option>
	<option value="MN" '.selectedState($sstate, "MN").'>Minnesota</option>
	<option value="MS" '.selectedState($sstate, "MS").'>Mississippi</option>
	<option value="MO" '.selectedState($sstate, "MO").'>Missouri</option>
	<option value="MT" '.selectedState($sstate, "MT").'>Montana</option>
	<option value="NE" '.selectedState($sstate, "NE").'>Nebraska</option>
	<option value="NV" '.selectedState($sstate, "NV").'>Nevada</option>
	<option value="NH" '.selectedState($sstate, "NH").'>New Hampshire</option>
	<option value="NJ" '.selectedState($sstate, "NJ").'>New Jersey</option>
	<option value="NM" '.selectedState($sstate, "NM").'>New Mexico</option>
	<option value="NY" '.selectedState($sstate, "NY").'>New York</option>
	<option value="NC" '.selectedState($sstate, "NC").'>North Carolina</option>
	<option value="ND" '.selectedState($sstate, "ND").'>North Dakota</option>
	<option value="OH" '.selectedState($sstate, "OH").'>Ohio</option>
	<option value="OK" '.selectedState($sstate, "OK").'>Oklahoma</option>
	<option value="OR" '.selectedState($sstate, "OR").'>Oregon</option>
	<option value="PA" '.selectedState($sstate, "PA").'>Pennsylvania</option>
	<option value="RI" '.selectedState($sstate, "RI").'>Rhode Island</option>
	<option value="SC" '.selectedState($sstate, "SC").'>South Carolina</option>
	<option value="SD" '.selectedState($sstate, "SD").'>South Dakota</option>
	<option value="TN" '.selectedState($sstate, "TN").'>Tennessee</option>
	<option value="TX" '.selectedState($sstate, "TX").'>Texas</option>
	<option value="UT" '.selectedState($sstate, "UT").'>Utah</option>
	<option value="VT" '.selectedState($sstate, "VT").'>Vermont</option>
	<option value="VA" '.selectedState($sstate, "VA").'>Virginia</option>
	<option value="WA" '.selectedState($sstate, "WA").'>Washington</option>
	<option value="WV" '.selectedState($sstate, "WV").'>West Virginia</option>
	<option value="WI" '.selectedState($sstate, "WI").'>Wisconsin</option>
	<option value="WY" '.selectedState($sstate, "WY").'>Wyoming</option>';
	$statesChoices2 = '
	<option value="" '.selectedState($mstate, "").'></option>
	<option value="AL" '.selectedState($mstate, "AL").'>Alabama</option>
	<option value="AK" '.selectedState($mstate, "AK").'>Alaska</option>
	<option value="AZ" '.selectedState($mstate, "AZ").'>Arizona</option>
	<option value="AR" '.selectedState($mstate, "AR").'>Arkansas</option>
	<option value="CA" '.selectedState($mstate, "CA").'>California</option>
	<option value="CO" '.selectedState($mstate, "CO").'>Colorado</option>
	<option value="CT" '.selectedState($mstate, "CT").'>Connecticut</option>
	<option value="DE" '.selectedState($mstate, "DE").'>Delaware</option>
	<option value="DC" '.selectedState($mstate, "DC").'>District Of Columbia</option>
	<option value="FL" '.selectedState($mstate, "FL").'>Florida</option>
	<option value="GA" '.selectedState($mstate, "GA").'>Georgia</option>
	<option value="HI" '.selectedState($mstate, "HI").'>Hawaii</option>
	<option value="ID" '.selectedState($mstate, "ID").'>Idaho</option>
	<option value="IL" '.selectedState($mstate, "IL").'>Illinois</option>
	<option value="IN" '.selectedState($mstate, "IN").'>Indiana</option>
	<option value="IA" '.selectedState($mstate, "IA").'>Iowa</option>
	<option value="KS" '.selectedState($mstate, "KS").'>Kansas</option>
	<option value="KY" '.selectedState($mstate, "KY").'>Kentucky</option>
	<option value="LA" '.selectedState($mstate, "LA").'>Louisiana</option>
	<option value="ME" '.selectedState($mstate, "ME").'>Maine</option>
	<option value="MD" '.selectedState($mstate, "MD").'>Maryland</option>
	<option value="MA" '.selectedState($mstate, "MA").'>Massachusetts</option>
	<option value="MI" '.selectedState($mstate, "MI").'>Michigan</option>
	<option value="MN" '.selectedState($mstate, "MN").'>Minnesota</option>
	<option value="MS" '.selectedState($mstate, "MS").'>Mississippi</option>
	<option value="MO" '.selectedState($mstate, "MO").'>Missouri</option>
	<option value="MT" '.selectedState($mstate, "MT").'>Montana</option>
	<option value="NE" '.selectedState($mstate, "NE").'>Nebraska</option>
	<option value="NV" '.selectedState($mstate, "NV").'>Nevada</option>
	<option value="NH" '.selectedState($mstate, "NH").'>New Hampshire</option>
	<option value="NJ" '.selectedState($mstate, "NJ").'>New Jersey</option>
	<option value="NM" '.selectedState($mstate, "NM").'>New Mexico</option>
	<option value="NY" '.selectedState($mstate, "NY").'>New York</option>
	<option value="NC" '.selectedState($mstate, "NC").'>North Carolina</option>
	<option value="ND" '.selectedState($mstate, "ND").'>North Dakota</option>
	<option value="OH" '.selectedState($mstate, "OH").'>Ohio</option>
	<option value="OK" '.selectedState($mstate, "OK").'>Oklahoma</option>
	<option value="OR" '.selectedState($mstate, "OR").'>Oregon</option>
	<option value="PA" '.selectedState($mstate, "PA").'>Pennsylvania</option>
	<option value="RI" '.selectedState($mstate, "RI").'>Rhode Island</option>
	<option value="SC" '.selectedState($mstate, "SC").'>South Carolina</option>
	<option value="SD" '.selectedState($mstate, "SD").'>South Dakota</option>
	<option value="TN" '.selectedState($mstate, "TN").'>Tennessee</option>
	<option value="TX" '.selectedState($mstate, "TX").'>Texas</option>
	<option value="UT" '.selectedState($mstate, "UT").'>Utah</option>
	<option value="VT" '.selectedState($mstate, "VT").'>Vermont</option>
	<option value="VA" '.selectedState($mstate, "VA").'>Virginia</option>
	<option value="WA" '.selectedState($mstate, "WA").'>Washington</option>
	<option value="WV" '.selectedState($mstate, "WV").'>West Virginia</option>
	<option value="WI" '.selectedState($mstate, "WI").'>Wisconsin</option>
	<option value="WY" '.selectedState($mstate, "WY").'>Wyoming</option>';
$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<span class="info-message-red">Item code and description fields are required.</span>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<span class="info-message-green">Successfully Added.</span>';}
?>
<?php echo '<ul class="nav">
	<a class="nav-link" href="list-customers.php">Customers</a>
	<a class="nav-link" href="#">Edit Customer</a>
	<a class="nav-link" href="list-customers-contacts.php?account='.htmlspecialchars($account_number).'&token='.htmlspecialchars($token).'">Customer Contacts</a>
	<a class="nav-link" href="edit-customer-settings.php?account='.htmlspecialchars($account_number).'&token='.htmlspecialchars($token).'">Customer Settings</a>
</ul><hr>'; ?>

<div class="container">
<!-- open row -->
	<div class="row">
	<!-- open col -->
	<div class="col">
	<h2><?php echo htmlspecialchars($account_number).', '.htmlspecialchars($business_name); ?></h2><br />
	<form  id="newcustomerform" action="php-scripts/process-edit-customer.php" method="post" autocomplete="off">
	<input autocomplete="false" name="hidden" type="text" style="display:none;">
	<input type="hidden" id="account_number" name="account_number" value="<?php echo htmlspecialchars($account_number); ?>"/>
	<input type="hidden" id="token" name="token" value="<?php echo htmlspecialchars($token); ?>"/>
	<?php echo $responseMsg; ?>
		
			<h4 class="mb-3">About</h4>
			
			<div class="custom-control custom-switch">
					<input class="custom-control-input" type="checkbox" id="active" name="active" <?php if($checked=='yes'){echo 'checked';} ?>>
					<label class="custom-control-label" for="active">Active</label>
			</div><br>
						
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Business Name:</label>
					<input class="form-control"  type="text" id="business_name" name="business_name" value="<?php echo getValue($link, $clientid, $account_number, 'business_name'); ?>"/>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Website: </label>
					<input class="form-control"  type="text" id="website" name="website" value="<?php echo getValue($link, $clientid, $account_number, 'website'); ?>"/>
				</div>
			</div>
			
			<hr class="mb-4">
			<h4 class="mb-3">Shipping Info</h4>
			
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Address 1</label>
					<input class="form-control"  type="text" id="shipping_address1" name="shipping_address1" value="<?php echo getValue($link, $clientid, $account_number, 'shipping_address1'); ?>"/>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Address 2:</label>
					<input class="form-control" type="text" id="shipping_address2" name="shipping_address2" value="<?php echo getValue($link, $clientid, $account_number, 'shipping_address2'); ?>"/>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-5 mb-3">
					<label for="">City:</label>
					<input class="form-control" type="text" id="shipping_city" name="shipping_city" value="<?php echo getValue($link, $clientid, $account_number, 'shipping_city'); ?>"/>
				</div>
				<div class="col-md-4 mb-3">
					<label for="">State:</label>
					<select class="form-control select_shipping_state" id="shipping_state" name="shipping_state" ><?php echo $statesChoices1; ?></select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="">Zip Code:</label>
					<input class="form-control" type="text" id="shipping_zip_code" name="shipping_zip_code" value="<?php echo getValue($link, $clientid, $account_number, 'shipping_zip_code'); ?>"/>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4 mb-3">
					<label for="">Phone Number 1:</label>
					<input class="form-control" type="text" id="shipping_phone_number1" name="shipping_phone_number1"  value="<?php echo getValue($link, $clientid, $account_number, 'shipping_phone_number1'); ?>"/>
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extension:</label>
					<input class="form-control" type="text" id="shipping_phone_number1ext" name="shipping_phone_number1ext" placeholder="Ext."  value="<?php echo getValue($link, $clientid, $account_number, 'shipping_phone_number1ext'); ?>"/>
				</div>
				<div class="col-md-4 mb-3">
					<label for="">Phone Number 2:</label>
					<input class="form-control" type="text" id="shipping_phone_number2" name="shipping_phone_number2"  value="<?php echo getValue($link, $clientid, $account_number, 'shipping_phone_number2'); ?>"/>
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extension:</label>	
					<input class="form-control" type="text" id="shipping_phone_number2ext" name="shipping_phone_number2ext" placeholder="Ext."  value="<?php echo getValue($link, $clientid, $account_number, 'shipping_phone_number2ext'); ?>"/>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Fax:</label>
					<input class="form-control" type="text" id="shipping_fax" name="shipping_fax" value="<?php echo getValue($link, $clientid, $account_number, 'shipping_fax'); ?>"/>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Email:</label>
					<input class="form-control" type="text" id="shipping_email" name="shipping_email" value="<?php echo getValue($link, $clientid, $account_number, 'shipping_email'); ?>"/>
				</div>
			</div>
		
			<hr class="mb-4">
			<h4 class="mb-3">Billing Info</h4>
			
			<div class="custom-control custom-switch">
					<input class="custom-control-input" type="checkbox" id="asshipping" name="asshipping" <?php if($checked=='yes'){echo 'checked';} ?>>
					<label class="custom-control-label" for="asshipping">Same as shipping</label>
			</div><br>
			
			
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Address 1</label>
					<input class="form-control"  type="text" id="mailing_address1" name="mailing_address1" value="<?php echo getValue($link, $clientid, $account_number, 'mailing_address1'); ?>"/>
				
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Address 2:</label>
					<input class="form-control" type="text" id="mailing_address2" name="mailing_address2" value="<?php echo getValue($link, $clientid, $account_number, 'mailing_address2'); ?>"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 mb-3">
					<label for="">City:</label>
					<input class="form-control" type="text" id="mailing_city" name="mailing_city" value="<?php echo getValue($link, $clientid, $account_number, 'mailing_city'); ?>"/>
				</div>
				<div class="col-md-4 mb-3">
					<label for="">State:</label><select class="form-control select_mailling_state" id="mailing_state" name="mailing_state" ><?php echo $statesChoices2; ?></select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="">Zip Code:</label>
					<input class="form-control" type="text" id="mailing_zip_code" name="mailing_zip_code" value="<?php echo getValue($link, $clientid, $account_number, 'mailing_zip_code'); ?>"/>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4 mb-3">
					<label for="">Phone Number 1:</label>
					<input class="form-control" type="text" id="mailing_phone_number1" name="mailing_phone_number1"  value="<?php echo getValue($link, $clientid, $account_number, 'mailing_phone_number1'); ?>"/>
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extention:</label>
					<input class="form-control" type="text" id="mailing_phone_number1ext" name="mailing_phone_number1ext" placeholder="Ext."  value="<?php echo getValue($link, $clientid, $account_number, 'mailing_phone_number1ext'); ?>"/>
				</div>
				<div class="col-md-4 mb-3">
					<label for="">Phone Number 2:</label>
					<input class="form-control" type="text" id="mailing_phone_number2" name="mailing_phone_number2"  value="<?php echo getValue($link, $clientid, $account_number, 'mailing_phone_number2'); ?>"/>
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extention:</label>
					<input class="form-control" type="text" id="mailing_phone_number2ext" name="mailing_phone_number2ext" placeholder="Ext."  value="<?php echo getValue($link, $clientid, $account_number, 'mailing_phone_number2ext'); ?>"/>
				</div>
			</div>
			<div class="row">	
				<div class="col-md-6 mb-3">
					<label for="">Fax:</label>
					<input class="form-control" type="text" id="mailing_fax" name="mailing_fax" value="<?php echo getValue($link, $clientid, $account_number, 'mailing_fax'); ?>"/>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Email:</label>
					<input class="form-control" type="text" id="mailing_email" name="mailing_email" value="<?php echo getValue($link, $clientid, $account_number, 'mailing_email'); ?>"/>
				</div>
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

function getValue($link, $clientid, $account_number, $vlu){
	$vl = '';
	$query = "SELECT `$vlu` FROM `customers` WHERE `clientid` = ? AND `account_number` = ?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('ss', $clientid, $account_number);
	$stmt->execute();
	$stmt->bind_result($vl);
	$stmt->fetch();
	return htmlspecialchars($vl);
}

?>

<script>
$(document).ready(function() {
    $('.select_shipping_state').select2();
	$('.select_mailling_state').select2();
});
</script>



<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>