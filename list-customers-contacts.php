<?php
$page_title = 'Customers Contacts';
$more_script = '<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');
$found = 'false';
if(isset($_GET['account']) && !empty($_GET['account']) && isset($_GET['token']) && !empty($_GET['token'])){
	$account = $_GET['account'];
	$token = $_GET['token'];
}
$business_name = '';
$query="SELECT `business_name` FROM `customers` WHERE `account_number` = ? AND `clientid` = ? AND `hashed_id` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('sss', $account, $clientid, $token);
$stmt->execute();
$stmt->bind_result($bn);
while ($stmt->fetch()) {
	$business_name = $bn;
	$found = 'true';
}
if($found == 'true'){
?>
<?php echo '<ul class="nav">
	<a class="nav-link" href="list-customers.php">Customers</a>
	<a class="nav-link" href="#">Edit Customer</a>
	<a class="nav-link" href="list-customers-contacts.php?account='.htmlspecialchars($account).'&token='.htmlspecialchars($token).'">Customer Contacts</a>
	<a class="nav-link" href="edit-customer-settings.php?account='.htmlspecialchars($account).'&token='.htmlspecialchars($token).'">Customer Settings</a>
</ul><hr>'; ?>

<h2><?php echo htmlspecialchars($account).', '.htmlspecialchars($business_name); ?></h2><br/>
<form action="new-customer-contact.php">
	<input type="hidden" value="<?php echo $account;?>" name="account">
	<input type="hidden" value="<?php echo $token;?>" name="token">
	<button type="submit" class="btn btn-primary btn-lg">New Customer Contact</button>
</form>
<table class="row-border" id="gtable">
<caption>Customers Contacts</caption>
	<thead>
		<tr>
			<th>Role</th>
			<th>Name</th>
			<th>Phone</th>
			<th>Ext</th>
			<th>Fax</th>
			<th>Email</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			
		$query = "SELECT `customer_contact_types`.`type`, `customer_contacts`.`full_name`, `customer_contacts`.`phone_number`, `customer_contacts`.`ext`, `customer_contacts`.`fax`, `customer_contacts`.`email`, `customer_contacts`.`hashed_id` FROM `customer_contacts` LEFT JOIN `customer_contact_types` on `customer_contact_types`.`id` = `customer_contacts`.`type_of_contact` WHERE `customer_contacts`.`clientid` = '$clientid' AND `customer_contacts`.`account_number` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $account);
		$stmt->execute();
		$stmt->bind_result($typeofcontact, $fullname, $phone, $ext, $fax, $email, $hid);
		while($stmt->fetch()) { 
			echo '<tr><td data-label="Role">'.$typeofcontact.'</td>
			<td data-label="Name">'.htmlspecialchars($fullname).'</td>
			<td data-label="Phone">'.htmlspecialchars($phone).'</td>
			<td data-label="Ext">'.htmlspecialchars($ext).'</td>
			<td data-label="Fax">'.htmlspecialchars($fax).'</td>
			<td data-label="Email">'.htmlspecialchars($email).'</td>
			<td data-label="Action"><span class="action-icons"><a href="edit-customer-contact.php?hid='.$hid.'&account='.$account.'&token='.$token.'"><i class="fas fa-edit"></i></a><i id="delete'.$hid.'" class="fas fa-trash-alt"></i></span></td></tr>'; 
		}
		
		?>
</tbody>
</table>
<input type="hidden" id="subject" name="subject" value="custContact" />
<div class="populateDivGenDelete" id="populateDivGenCustDel">
	<div class="container text-center">
		<p class="mb-3">Are you sure you want to delete the selected record?</p>
		<div class="row">
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary btn-lg btn-block" id="yesBtn">Yes</button>
			</div>
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary btn-lg btn-block" id="noBtn">No</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#gtable').DataTable();
} );
</script>
<?php 
}else{
	echo 'oops!! this page does not exist.';
}
?>






<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>