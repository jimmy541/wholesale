<?php $page_title = 'Company Information';

$more_css = '<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />';

$more_script = '<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript" src="js/form-validation.js"></script>';?>


<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<?php

$company_name = '';
$address1 = '';
$address2 = '';
$city = '';
$state = '';
$zip_code = '';
$country = '';
$phone1 = '';
$phone2 = '';
$fax = '';
$email = '';
$website = '';
$checked = '';
if(isset($_GET['account']) && !empty($_GET['account']) && isset($_GET['token']) && !empty($_GET['token'])){
	$account = $_GET['account'];
	$token = $_GET['token'];
}
$query="SELECT `company_name`, `address1`, `address2`, `city`, `state`, `zip_code`, `country`, `phone1`, `phone2`, `fax`, `email`, `website` FROM `clients` WHERE `clientid` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $clientid);
$stmt->execute();
$stmt->bind_result($vlu_company_name, $vlu_address1, $vlu_address2, $vlu_city, $vlu_state, $vlu_zip_code, $vlu_country, $vlu_phone1, $vlu_phone2, $vlu_fax, $vlu_email, $vlu_website);

while ($stmt->fetch()) {
	$company_name = $vlu_company_name;
	$address1 = $vlu_address1;
	$address2 = $vlu_address2;
	$city = $vlu_city;
	$state = $vlu_state;
	$zip_code = $vlu_zip_code;
	$country = $vlu_country;
	$phone1 = $vlu_phone1;
	$phone2 = $vlu_phone2;
	$fax = $vlu_fax;
	$email = $vlu_email;
	$website = $vlu_website;
	
}

	function selectedState($state, $vlu){
	$sel = '';
	if($state == $vlu){
		$sel = 'selected';
	}
	return $sel;
}
	$statesChoices1 = '
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
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<div class="alert alert-danger" role="alert">Company name is required</div>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<div class="alert alert-success" role="alert">Successfully Updated.</div>';}
?>
<div class="container-fluid">
<!-- open row -->
	<div class="row">
	<!-- open col -->
	<div class="col">
	<div class="card">
		<div class="card-body">
			<form  id="editcompanyform" action="php-scripts/process-edit-company.php" method="post" autocomplete="off">
		<input autocomplete="false" name="hidden" type="text" style="display:none;">
		<?php echo $responseMsg; ?>
				<h4>Client:</h4>			
				<div class="mb-3">
					<label for="">Client ID:</label>
					<input class="form-control"  type="text" id="client" name="client" placeholder="<?php echo $clientid; ?>" readonly/>
				</div>
				<div class="mb-3">
					<label for="">Company Name:*</label>
					<input class="form-control"  type="text" id="company_name" name="company_name" value="<?php echo $company_name; ?>"/>
				</div>
				
				
				<hr class="mb-4">
				<h4>Address</h4>
				
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="">Address 1</label>
						<input class="form-control"  type="text" id="address1" name="address1" value="<?php echo $address1; ?>"/>
					</div>
					<div class="col-md-6 mb-3">
						<label for="">Address 2:</label>
						<input class="form-control" type="text" id="address2" name="address2" value="<?php echo $address2; ?>"/>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-5 mb-3">
						<label for="">City:</label>
						<input class="form-control" type="text" id="city" name="city" value="<?php echo $city; ?>"/>
					</div>
					<div class="col-md-4 mb-3">
						<label for="">State:</label>
						<select class="form-control select_state" id="state" name="state" ><?php echo $statesChoices1; ?></select>
					</div>
					<div class="col-md-3 mb-3">
						<label for="">Zip Code:</label>
						<input class="form-control" type="text" id="zip_code" name="zip_code" value="<?php echo $zip_code; ?>"/>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="">Phone Number 1:</label>
						<input class="form-control" type="text" id="phone_number1" name="phone_number1"  value="<?php echo $phone1; ?>"/>
					</div>
					
					<div class="col-md-6 mb-3">
						<label for="">Phone Number 2:</label>
						<input class="form-control" type="text" id="phone_number2" name="phone_number2"  value="<?php echo $phone2; ?>"/>
					</div>
					
				</div>
				
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="">Fax:</label>
						<input class="form-control" type="text" id="fax" name="fax" value="<?php echo $fax; ?>"/>
					</div>
					<div class="col-md-6 mb-3">
						<label for="">Email:</label>
						<input class="form-control" type="text" id="email" name="email" value="<?php echo $email; ?>"/>
					</div>
				</div>
				<div class="mb-3">
					<label for="">Website:</label>
					<input class="form-control" type="text" id="website" name="website" value="<?php echo $website; ?>"/>
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


<?php
$additional_script = '<script>
$(document).ready(function() {
    $(".select_state").select2();
});
</script>'; ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>