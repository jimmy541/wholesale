<?php
$page_title = 'Customers';
$more_script = '<style>#gtable_filter{display:none;}</style><script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>
<script type="text/javascript" src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<?php
if(isset($_GET['as'])){
	if($_GET['as'] == '1'){
		echo '<div class="alert alert-success" role="alert">Successfully Added</div>';
	}
}
if(isset($_GET['es'])){
	if($_GET['es'] == '1'){
		echo '<div class="alert alert-success" role="alert">Successfully Updated</div>';
	}
}
if(isset($_GET['rs'])){
	if($_GET['rs'] == '1'){
		echo '<div class="alert alert-success" role="alert">Successfully Removed</div>';
	}
}
$active_query = " AND `active` = 'yes'";
$active_link = '<form class="float-right" style="display:inline-block;" action="list-customers.php" method="get"><input type="hidden" name="active" value="1" /><button type="submit" class="btn btn-secondary btn-sm shadow">Show Inactive</button></form>';
if(isset($_GET['active']) && !empty($_GET['active'])){
	$active_query = " AND `active` = 'no'";
	$active_link = '<form class="float-right" style="display:inline-block;" action="list-customers.php"><button type="submit" class="btn btn-secondary btn-sm shadow">Show Active</button></form>';
}
 ?>
<input type="hidden" id="customerhash" value="" />
<input type="hidden" id="customerid" value="" />
<input type="hidden" id="todaydate" value="<?php echo date('Y-m-d'); ?>" />
<input type="hidden" id="prior3months" value="<?php echo date('Y-m-d', strtotime("-3 months")); ?>" /> 

<div class="container-fluid">
	<div class="row">
		<div class="col">
			<form action="new-customer.php"><button type="submit" class="btn btn-primary shadow btn-sm float-right ml-1">New Customer</button></form>
			<?php echo $active_link; ?>
		</div>
	</div>
	

	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
				<div class="row">
		<div class="col">
			<ul class="invoice-top-buttons-disabled">
				<li id="edit-customer"><i class="fas fa-edit"></i>Edit</li>
				<li id="view-customer-invoices"><i class="fas fa-file-invoice"></i>Invoices</li>
				<li id="customer-statement-ll"><i class="fas fa-list-alt"></i>Statement</li>
				<li id="customer-list-acchistory"><i class="fas fa-list"></i>History</li>
				<li id="customer-payment-history"><i class="fas fa-money-check-alt"></i>Payments</li>
				<li id="assign-salesperson-customer" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-hand-pointer"></i>Assign</li>
			</ul>
		</div>
	</div>
	<div class="row">
	<div class="col">
					<table class="row-border" id="gtable">
						<thead>
							<tr>
								
								<th style="display:none;">Account ID</th>
								<th style="display:none;">Customer ID</th>
								<th>Account Number</th>
								<th>Business Name</th>
								<th>State</th>
								<th>Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								
								<th style="display:none;">Account ID</th>
								<th style="display:none;">Customer ID</th>
								<th>Account Number</th>
								<th>Business Name</th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
						<tbody>
							<?php
							$query = "SELECT * FROM `customers` WHERE `clientid` = '$clientid' $active_query";
							$result = mysqli_query($link, $query); 
							while($row = mysqli_fetch_array($result)) {
								$del_id_type = 'delete';
								if($row['has_orders'] == 'yes'){$del_id_type = 'inactive';}
								echo '<tr>
								<td style="display:none;">'.htmlspecialchars($row["account_number"]).'</td>
								<td data-label="Customer ID" style="display:none;">'.htmlspecialchars($row["hashed_id"]).'</td>
								<td data-label="Account Number">'.htmlspecialchars($row["account_number"]).'</td>
								<td data-label="Business Name">'.htmlspecialchars($row["business_name"]).'</td>
								<td data-label="State">'.htmlspecialchars($row['shipping_state']).'</td>
								<td><span class="action-icons"><i id="'.$del_id_type.$row['hashed_id'].'" class="fas fa-trash-alt"></i></span></td>
								</tr>'; 
							}
							?>
					</tbody>
					</table>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#gtable').DataTable();
	$('#gtable').parent().addClass('table-responsive');
} );
</script>
<input type="hidden" id="subject" name="subject" value="cust" />
<div class="populateDivGenDelete" id="populateDivGenCustDel">
	<div class="container text-center">
		<p class="mb-3">Are you sure you want to delete the selected record?</p>
		<div class="row">
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary shadow btn-lg btn-block" id="yesBtn">Yes</button>
			</div>
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary shadow btn-lg btn-block" id="noBtn">No</button>
			</div>
		</div>
	</div>
</div>
<div class="populateDivGenDelete" id="populateDivGenCustInactive">
	<div class="container text-center">
		<p class="mb-3">This customer is linked to existing invoices. Would you like to make it inactive?</p>
		<div class="row">
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary shadow btn-lg btn-block" id="yesInactiveBtn">Yes</button>
			</div>
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary shadow btn-lg btn-block" id="noBtn">No</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Salesperson</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form></form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>





<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>