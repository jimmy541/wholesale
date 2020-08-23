<?php $page_title = 'Add Customer Contact';?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php

if(isset($_GET['account']) && !empty($_GET['account']) && isset($_GET['token']) && !empty($_GET['token'])){
	$account = $_GET['account'];
	$token = $_GET['token'];
}

function getSelectItemsSimple($link){
	$options = '<option></option>';
	$result = mysqli_query($link, "SELECT * FROM `customer_contact_types` ORDER BY `type` ASC");
	while($row=mysqli_fetch_array($result)){
		$options .= '<option value="'.$row['id'].'">'.htmlspecialchars($row['type']).'</option>';
	}
	return $options;
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

$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<span class="info-message-red">Item code and description fields are required.</span>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<span class="info-message-green">Successfully Added.</span>';}
?>
<?php echo '<ul class="nav">
	<a class="nav-link" href="list-customers.php">Customers</a>
	<a class="nav-link" href="#">Edit Customer</a>
	<a class="nav-link" href="list-customers-contacts.php?account='.htmlspecialchars($account).'&token='.htmlspecialchars($token).'">Customer Contacts</a>
	<a class="nav-link" href="edit-customer-settings.php?account='.htmlspecialchars($account).'&token='.htmlspecialchars($token).'">Customer Settings</a>
</ul><hr>'; ?>
<div class="container">
<!-- open row -->
	<div class="row">
	<!-- open col -->
	<div class="col">
	<h2><?php echo htmlspecialchars($account).', '.htmlspecialchars($business_name); ?></h2><br/>
	
	<?php echo $responseMsg; ?>
	
	<form  action="php-scripts/process-new-customer-contact.php" method="post" autocomplete="off">
	<input type="hidden" value="<?php echo htmlspecialchars($account); ?>" name="account_number"/>
	<input type="hidden" value="<?php echo htmlspecialchars($token); ?>" name="token"/>
		
			<h4 class="mb-3">General Info</h4>
			
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="">Role *</label>
					<select class="form-control" name="type_of_contact"><?php echo getSelectItemsSimple($link); ?></select>
				</div>
				<div class="col-md-6 mb-3">
					<label for="">Full Name: *</label>
					<input class="form-control"  type="text" id="full_name" name="full_name"/>
				</div>
			</div>	
				<hr class="mb-4">
				<h4 class="mb-3">Contact Info</h4>
				
			<div class="row">
				<div class="col-md-5 mb-3">
					<label for="">Phone Number:</label>
					<input class="form-control" type="text" id="phone_number" name="phone_number" />
				</div>
				<div class="col-md-2 mb-3">
					<label for="">Extention:</label>
					<input class="form-control" type="text" id="ext" name="ext" placeholder="Ext." />
				</div>
				<div class="col-md-5 mb-3"><label for="">Fax:</label><input class="form-control" type="text" id="fax" name="fax"/></div>
			</div>
			
			<div class="mb-3">
				<label for="">Email:</label>
				<input class="form-control" type="text" id="email" name="email"/>
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


<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>