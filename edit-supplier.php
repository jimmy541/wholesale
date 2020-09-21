<?php $page_title = 'Edit Supplier';

$more_css = '<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />';

$more_script = '<script type="text/javascript" src="js/copy-address.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>';?>

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<?php

$found = 'false';
$checked = '';
$account_number = '';
$name = '';
$address1 = '';
$address2 = '';
$city = '';
$state = '';
$zipcode = '';
$phone_number = '';
$ext = '';
$fax = '';
$email = '';
$website = '';
$active = '';
if(isset($_GET['token']) && !empty($_GET['token'])){
	$token = $_GET['token'];

	$query="SELECT `account_number`, `name`, `address1`, `address2`, `city`, `state`, `zipcode`, `phone_number`, `ext`, `fax`, `email`, `website`, `active` FROM `supplier` WHERE `hashed_id` = ? AND `clientid` = ?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('ss', $token, $clientid);
	$stmt->execute();
	$stmt->bind_result($account_numberV, $nameV, $address1V, $address2V, $cityV, $stateV, $zipcodeV, $phone_numberV, $extV, $faxV, $emailV, $websiteV, $activeV);
	 
	while ($stmt->fetch()) {
		$found = 'true';
		$account_number = $account_numberV;
		$name = $nameV;
		$address1 = $address1V;
		$address2 = $address2V;
		$city = $cityV;
		$state = $stateV;
		$zipcode = $zipcodeV;
		$phone_number = $phone_numberV;
		$ext = $extV;
		$fax = $faxV;
		$email = $emailV;
		$website = $websiteV;
		$active = $activeV;
		if($active == 'yes'){
			$checked = 'yes';
		}
	}

}else{
	echo 'oops!!! this page does not exist.';
}
if ($found == 'true'){
	function selectedState($state, $vlu){
	$sel = '';
	if($state == $vlu){
		$sel = 'selected';
	}
	return $sel;
}
	$statesChoices = '
	<option value="" '.selectedState($state, "").'></option>
	<option value="AL" '.selectedState($state, "AL").'>Alabama</option>
	<option value="AK" '.selectedState($state, "AK").'>Alaska</option>
	<option value="AZ" '.selectedState($state, "AZ").'>Arizona</option>
	<option value="AR" '.selectedState($state, "AR").'>Arkansas</option>
	<option value="CA" '.selectedState($state, "CA").'>California</option>
	<option value="CO" '.selectedState($state, "CO").'>Colorado</option>
	<option value="CT" '.selectedState($state, "CT").'>Connecticut</option>
	<option value="DE" '.selectedState($state, "DE").'>Delaware</option>
	<option value="DC" '.selectedState($state, "DC").'>District Of Columbia</option>
	<option value="FL" '.selectedState($state, "FL").'>Florida</option>
	<option value="GA" '.selectedState($state, "GA").'>Georgia</option>
	<option value="HI" '.selectedState($state, "HI").'>Hawaii</option>
	<option value="ID" '.selectedState($state, "ID").'>Idaho</option>
	<option value="IL" '.selectedState($state, "IL").'>Illinois</option>
	<option value="IN" '.selectedState($state, "IN").'>Indiana</option>
	<option value="IA" '.selectedState($state, "IA").'>Iowa</option>
	<option value="KS" '.selectedState($state, "KS").'>Kansas</option>
	<option value="KY" '.selectedState($state, "KY").'>Kentucky</option>
	<option value="LA" '.selectedState($state, "LA").'>Louisiana</option>
	<option value="ME" '.selectedState($state, "ME").'>Maine</option>
	<option value="MD" '.selectedState($state, "MD").'>Maryland</option>
	<option value="MA" '.selectedState($state, "MA").'>Massachusetts</option>
	<option value="MI" '.selectedState($state, "MI").'>Michigan</option>
	<option value="MN" '.selectedState($state, "MN").'>Minnesota</option>
	<option value="MS" '.selectedState($state, "MS").'>Mississippi</option>
	<option value="MO" '.selectedState($state, "MO").'>Missouri</option>
	<option value="MT" '.selectedState($state, "MT").'>Montana</option>
	<option value="NE" '.selectedState($state, "NE").'>Nebraska</option>
	<option value="NV" '.selectedState($state, "NV").'>Nevada</option>
	<option value="NH" '.selectedState($state, "NH").'>New Hampshire</option>
	<option value="NJ" '.selectedState($state, "NJ").'>New Jersey</option>
	<option value="NM" '.selectedState($state, "NM").'>New Mexico</option>
	<option value="NY" '.selectedState($state, "NY").'>New York</option>
	<option value="NC" '.selectedState($state, "NC").'>North Carolina</option>
	<option value="ND" '.selectedState($state, "ND").'>North Dakota</option>
	<option value="OH" '.selectedState($state, "OH").'>Ohio</option>
	<option value="OK" '.selectedState($state, "OK").'>Oklahoma</option>
	<option value="OR" '.selectedState($state, "OR").'>Oregon</option>
	<option value="PA" '.selectedState($state, "PA").'>Pennsylvania</option>
	<option value="RI" '.selectedState($state, "RI").'>Rhode Island</option>
	<option value="SC" '.selectedState($state, "SC").'>South Carolina</option>
	<option value="SD" '.selectedState($state, "SD").'>South Dakota</option>
	<option value="TN" '.selectedState($state, "TN").'>Tennessee</option>
	<option value="TX" '.selectedState($state, "TX").'>Texas</option>
	<option value="UT" '.selectedState($state, "UT").'>Utah</option>
	<option value="VT" '.selectedState($state, "VT").'>Vermont</option>
	<option value="VA" '.selectedState($state, "VA").'>Virginia</option>
	<option value="WA" '.selectedState($state, "WA").'>Washington</option>
	<option value="WV" '.selectedState($state, "WV").'>West Virginia</option>
	<option value="WI" '.selectedState($state, "WI").'>Wisconsin</option>
	<option value="WY" '.selectedState($state, "WY").'>Wyoming</option>';
	

$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<div class="alert alert-danger" role="alert">Supplier name is required</div>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<div class="alert alert-success" role="alert">Successfully Added.</div>';}
?>
<div class="container-fluid">
<div class="row mb-2">
<div class="col">
<div class="ab-hed"><a href="list-suppliers.php">Suppliers</a></div>
</div>
</div>
<!-- open row -->
	<div class="row">
	<!-- open col -->
		<div class="col">
		<div class="card">
		<div class="card-body">
			
			<form  action="php-scripts/process-edit-supplier.php" method="post" autocomplete="off">
			<input type="hidden" id="token" name="token" autocomplete="off" value="<?php echo $token; ?>"/>
			<input autocomplete="false" name="hidden" type="text" style="display:none;">
			<?php echo $responseMsg; ?>
				
				<h4>About</h4>
				<div class="custom-control custom-switch">
					<input class="custom-control-input" type="checkbox" id="active" name="active" <?php if($checked=='yes'){echo 'checked';} ?>>
					<label class="custom-control-label" for="active">Active</label>
				</div><br>
					
									
				<div class="row">
					<div class="col-md-6 mb-3"><label for="">Account Number:</label><input class="form-control"  type="text" id="account_number" name="account_number" autocomplete="off" value="<?php echo $account_number; ?>"/></div>
					<div class="col-md-6 mb-3"><label for="">Name: *</label><input class="form-control"  type="text" id="name" name="name" value="<?php echo $name; ?>"/></div>
				</div>
				
					<hr class="mb-4">
					<h4>Contact Info</h4>
				
				<div class="row">
					<div class="col-md-6 mb-3"><label for="">Address 1</label><input class="form-control"  type="text" id="address1" name="address1" value="<?php echo $address1; ?>"/></div>
					<div class="col-md-6 mb-3"><label for="">Address 2:</label><input class="form-control" type="text" id="address2" name="address2" value="<?php echo $address2; ?>"/></div>
				</div>
				<div class="row">
					<div class="col-md-5 mb-3"><label for="">City:</label><input class="form-control" type="text" id="city" name="city" value="<?php echo $city; ?>"/></div>
					<div class="col-md-4 mb-3"><label for="">State:</label><select class="form-control" class="select_state" id="state" name="state"><?php echo $statesChoices; ?></select></div>
					<div class="col-md-3 mb-3"><label for="">Zip Code:</label><input class="form-control" type="text" id="zipcode" name="zipcode" value="<?php echo $zipcode; ?>"/></div>
				</div>
				<div class="row">
					<div class="col-md-5 mb-3">
						<label for="">Phone Number:</label>
						<input class="form-control" type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>"/>
					</div>
					<div class="col-md-2 mb-3">
						<label for="">Extention:</label>
						<input class="form-control" type="text" id="ext" name="ext" placeholder="Ext." value="<?php echo $ext; ?>" />
					</div>
					<div class="col-md-5 mb-3">
						<label for="">Fax:</label>
						<input class="form-control" type="text" id="fax" name="fax" value="<?php echo $fax; ?>"/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3"><label for="">Email:</label><input class="form-control" type="text" id="email" name="email" value="<?php echo $email; ?>"/></div>
					<div class="col-md-6 mb-3"><label for="">Website: </label><input class="form-control"  type="text" id="website" name="website" value="<?php echo $website; ?>"/></div>
				</div>
					
				<hr class="mb-4">
				<div class="mb-3">
					<button class="btn btn-primary shadow btn-lg btn-block" type="submit">Save</button>
				</div>
				
				
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
    $('.select_state').select2();
});
</script>



<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>