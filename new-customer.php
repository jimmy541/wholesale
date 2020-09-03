<?php $page_title = 'Add Customer';?>
<?php $more_script = '<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript" src="js/copy-address.js"></script>
<script type="text/javascript" src="js/form-validation.js"></script>'; ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php
$statesChoices = '
	<option value=""></option>
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District Of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>';
function getSelectItemsSimple($link, $tbl){
	$options = '<option></option>';
	$result = mysqli_query($link, "SELECT * FROM `$tbl` ORDER BY `description` ASC");
	while($row=mysqli_fetch_array($result)){
		$options .= '<option value="'.$row['id'].'">'.htmlspecialchars($row['description']).'</option>';
	}
	return $options;
}
$acct_num_to_return = '10001';
$stmt = $link->prepare("SELECT MAX(`account_number`) as mx FROM `customers` WHERE `clientid` = '$clientid'");
$stmt->execute();
$stmt->bind_result($sv);
while ($stmt->fetch()) {$settingvalue = $sv;}
if(!empty($settingvalue)){
	if (is_numeric($settingvalue)){
		$acct_num_to_return = $settingvalue + 1;
	}
	
}



$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<div class="alert alert-danger" role="alert">Item code and description fields are required.</div>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<div class="alert alert-success" role="alert">Successfully Added.</div>';}
?>
<ul class="nav">
	<a class="nav-link" href="list-customers.php">Customers</a>
</ul><hr>
<div class="container-fluid">
<!-- open row -->
	<div class="row">
	<!-- open col -->
	<div class="col">
<h1>Add new customer</h1>
<br />
<?php echo $responseMsg; ?>

	<form  id="newcustomerform" action="php-scripts/process-new-customer.php" method="post" autocomplete="off">
	<input class="form-control" autocomplete="false" name="hidden" type="text" style="display:none;">
		
			<h4>About</h4>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Account Number: *</label>
					<input class="form-control" value="<?php echo $acct_num_to_return; ?>" type="text" id="account_number" name="account_number" autocomplete="off"/>
				</div>
				<div class="col-md-6 mb-3"><label for="">Business Name: *</label><input class="form-control"  type="text" id="business_name" name="business_name"/>
				</div>
			</div>
			
			<div class="mb-3">
				<label for="">Website: </label><input class="form-control"  type="text" id="website" name="website"/>
			</div>
			
			<hr class="mb-4">
			<h4>Shipping Info</h4>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Address 1</label>
					<input class="form-control"  type="text" id="shipping_address1" name="shipping_address1"/></div>
				<div class="col-md-6 mb-3">
				<label for="">Address 2:</label>
				<input class="form-control" type="text" id="shipping_address2" name="shipping_address2"/></div>
			</div>
			
			<div class="row">
				<div class="col-md-5 mb-3">
					<label for="">City:</label>
					<input class="form-control" type="text" id="shipping_city" name="shipping_city"/>
				</div>
				<div class="col-md-4 mb-3">
					<label for="">State:</label>
					<select class="form-control select_shipping_state" id="shipping_state" name="shipping_state"><?php echo $statesChoices; ?></select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="">Zip Code:</label>
					<input class="form-control" type="text" id="shipping_zip_code" name="shipping_zip_code"/>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4 mb-3">
					<label for="">Phone Number 1:</label>
					<input class="form-control" type="text" id="shipping_phone_number1" name="shipping_phone_number1"/>
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extension:</label>
					<input class="form-control" type="text" id="shipping_phone_number1ext" name="shipping_phone_number1ext" placeholder="Ext." />
				</div>
				<div class="col-md-4 mb-3">
					<label for="">Phone Number 2:</label>
					<input class="form-control" type="text" id="shipping_phone_number2" name="shipping_phone_number2"/>
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extension:</label>
					<input class="form-control" type="text" id="shipping_phone_number2ext" name="shipping_phone_number2ext" placeholder="Ext." />
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Fax:</label>
					<input class="form-control" type="text" id="shipping_fax" name="shipping_fax"/>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Email:</label>
					<input class="form-control" type="text" id="shipping_email" name="shipping_email"/>
				</div>
			</div>
		
		
			<hr class="mb-4">
			<h4>Billing Info</h4>
			
			<div class="custom-control custom-switch">
					<input class="custom-control-input" type="checkbox" id="asshipping" name="asshipping" >
					<label class="custom-control-label" for="asshipping">Same as shipping</label>
			</div><br>
			
			<div class="row">			
				<div class="col-md-6 mb-3">
					<label for="">Address 1</label>
					<input class="form-control"  type="text" id="mailing_address1" name="mailing_address1"/>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Address 2:</label>
					<input class="form-control" type="text" id="mailing_address2" name="mailing_address2"/>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-5 mb-3">
					<label for="">City:</label>
					<input class="form-control" type="text" id="mailing_city" name="mailing_city"/>
				</div>
				<div class="col-md-4 mb-3">
					<label for="">State:</label>
					<select class="form-control select_mailling_state" id="mailing_state" name="mailing_state"><?php echo $statesChoices; ?></select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="">Zip Code:</label>
					<input class="form-control" type="text" id="mailing_zip_code" name="mailing_zip_code"/>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-4 mb-3">
					<label for="">Phone Number 1:</label>
					<input class="form-control" type="text" id="mailing_phone_number1" name="mailing_phone_number1"/>
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extention:</label>
					<input class="form-control" type="text" id="mailing_phone_number1ext" name="mailing_phone_number1ext" placeholder="Ext." />
				</div>
				<div class="col-md-4 mb-3">
					<label for="">Phone Number 2:</label>
					<input class="form-control" type="text" id="mailing_phone_number2" name="mailing_phone_number2" />
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extention:</label>
					<input class="form-control" type="text" id="mailing_phone_number2ext" name="mailing_phone_number2ext" placeholder="Ext." />
				</div>
			</div>	
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Fax:</label>
					<input class="form-control" type="text" id="mailing_fax" name="mailing_fax"/>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Email:</label>
					<input class="form-control" type="text" id="mailing_email" name="mailing_email"/>
				</div>
			</div>
			
			<hr class="mb-4">
			<div class="mb-3">
				<button class="btn btn-primary shadow btn-lg btn-block" type="submit">Save</button>
			</div>
		

	<span style="color:red; font-size:20px !important;"><?php /*echo $errorMessage;*/ ?></span>
	</form>
	<!-- close col -->
		</div>
	<!-- close row -->
	</div>
<!-- close container -->
</div>
<script>
$(document).ready(function() {
    $('.select_shipping_state').select2();
	$('.select_mailling_state').select2();
});
</script>





<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>