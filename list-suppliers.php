<?php
$page_title = 'Suppliers';
$more_script = '<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<br/>

<?php
if(isset($_GET['as'])){
	if($_GET['as'] == '1'){
		echo '<span class="gMessage">Successfully Added</span>';
	}
}
if(isset($_GET['es'])){
	if($_GET['es'] == '1'){
		echo '<span class="gMessage">Successfully Updated</span>';
	}
}
if(isset($_GET['rs'])){
	if($_GET['rs'] == '1'){
		echo '<span class="gMessage">Successfully Removed</span>';
	}
}
 ?>

<form action="new-supplier.php"><button type="submit" class="btn btn-primary btn-lg"">New Supplier</button></form>
<table class="row-border" id="gtable">
<caption>Suppliers</caption>
	<thead>
		<tr>
			<th>Supplier Name</th>
			<th>Account Number</th>
			<th>Phone Number</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$query = "SELECT * FROM `supplier` WHERE `clientid` = '$clientid'";
		$result = mysqli_query($link, $query); 
		while($row = mysqli_fetch_array($result)) { 
			echo '<tr><td data-label="Supplier Name">'.htmlspecialchars($row["name"]).'</td><td data-label="Account Number">'.htmlspecialchars($row["account_number"]).'</td><td data-label="Phone Number">'.$row['phone_number'].'</td><td><span class="action-icons"><a href="edit-supplier.php?token='.htmlspecialchars($row['hashed_id']).'"><i class="fas fa-edit"></i></a><i id="delete'.htmlspecialchars($row['hashed_id']).'" class="fas fa-trash-alt"></i></span></td></tr>'; 
		}
		?>
	</tbody>
</table>
<input type="hidden" id="subject" name="subject" value="supp" />
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

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>