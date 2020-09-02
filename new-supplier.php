<?php $page_title = 'Add Supplier';?>
<?php $more_script = '<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript" src="js/copy-address.js"></script>'; ?>
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

$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<span class="info-message-red">Item code and description fields are required.</span>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<span class="info-message-green">Successfully Added.</span>';}
?>
<div class="ab-hed"><a href="list-suppliers.php">Suppliers</a></div><hr>
<br />



<div class="container-fluid">
<!-- open row -->
	<div class="row">
	<!-- open col -->
	<div class="col">
	<?php echo $responseMsg; ?>
	<h1>Add New Supplier</h1><br>
	<form  action="php-scripts/process-new-supplier.php" method="post" autocomplete="off">
	<input autocomplete="false" name="hidden" type="text" style="display:none;">
		
			<h4 class="mb-3">About</h4>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Account Number:</label>
					<input class="form-control"  type="text" id="account_number" name="account_number" autocomplete="off"/>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Name: *</label>
					<input class="form-control"  type="text" id="name" name="name"/>
				</div>
			</div>
			
			<hr class="mb-4">
			<h4 class="mb-3">Contact Info</h4>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Address 1</label>
					<input class="form-control"  type="text" id="address1" name="address1"/>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Address 2:</label>
					<input class="form-control" type="text" id="address2" name="address2"/>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-5 mb-3">
					<label for="">City:</label>
					<input class="form-control" type="text" id="city" name="city"/>
				</div>
				<div class="col-md-4 mb-3">
					<label for="">State:</label>
					<select class="form-control" class="select_state" id="state" name="state"><?php echo $statesChoices; ?></select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="">Zip Code:</label>
					<input class="form-control" type="text" id="zipcode" name="zipcode"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 mb-3">
					<label for="">Phone Number:</label>
					<input class="form-control" type="text" id="phone_number" name="phone_number" />
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extension</label>
					<input class="form-control" type="text" id="ext" name="ext" placeholder="Ext."/>
				</div>
				<div class="col-md-5 mb-3">
					<label for="">Fax:</label>
					<input class="form-control" type="text" id="fax" name="fax"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mb-3"><label for="">Email:</label><input class="form-control" type="text" id="email" name="email"/></div>
				<div class="col-md-6 mb-3"><label for="">Website: </label><input class="form-control"  type="text" id="website" name="website"/></div>
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
<script>
$(document).ready(function() {
    $('.select_state').select2();
});
</script>

<!-- The following div closes the main body div -->
</div>




<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>