<?php
$page_title = 'Customers';
$more_css = '<style>#list_customers_php_table1_filter{display:none;}</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">';
$more_script = '<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
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
$active_query = " AND a.`active` = 'yes'";
$active_link = '<form class="float-right" style="display:inline-block;" action="list-customers.php" method="get"><input type="hidden" name="active" value="1" /><button type="submit" class="btn btn-secondary btn-sm shadow">Show Inactive</button></form>';
if(isset($_GET['active']) && !empty($_GET['active'])){
	$active_query = " AND a.`active` = 'no'";
	$active_link = '<form class="float-right" style="display:inline-block;" action="list-customers.php"><button type="submit" class="btn btn-secondary btn-sm shadow">Show Active</button></form>';
}
 ?>
<input type="hidden" id="customerhash" value="" />
<input type="hidden" id="customerid" value="" />
<input type="hidden" id="todaydate" value="<?php echo date('Y-m-d'); ?>" />
<input type="hidden" id="prior3months" value="<?php echo date('Y-m-d', strtotime("-3 months")); ?>" /> 
<div class="container-fluid">
	 <?php if($role != 'Sales Representative') { ?><div class="row">
		<div class="col">
			<form action="new-customer.php"><button type="submit" class="btn btn-primary shadow btn-sm float-right ml-1">New Customer</button></form>
			<?php echo $active_link; ?>
		</div>
	</div>
	 <?php } ?>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
				<div class="row">
		<div class="col">
			<ul class="invoice-top-buttons-disabled">
				<li id="view-customer-invoices"><i class="fas fa-file-invoice"></i>Invoices</li>
				<li id="customer-statement-ll"><i class="fas fa-list-alt"></i>Statement</li>
				<li id="customer-list-acchistory"><i class="fas fa-list"></i>History</li>
				<?php if($role != 'Sales Representative') { ?><li id="customer-payment-history"><i class="fas fa-money-check-alt"></i>Payments</li><?php } ?>
				<?php if($role != 'Sales Representative') { ?><li id="assign-salesperson-customer" data-toggle="modal" data-target=""><i class="fas fa-hand-pointer"></i>Assign</li><?php } ?>
			</ul>
		</div>
	</div>
	<div class="row">
	<div class="col">
					<table class="row-border" id="list_customers_php_table1">
						<thead>
							<tr>
								<th style="display:none;">Account ID</th>
								<th style="display:none;">Customer ID</th>
								<th>Account Number</th>
								<th>Business Name</th>
								<th>State</th>
								<th>Assigned Sales Rep.</th>
								<?php if($role != 'Sales Representative') { ?><th>Action</th><?php } ?>
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
								<?php if($role != 'Sales Representative') { ?><th></th><?php } ?>
							</tr>
						</tfoot>
						<tbody>
							<?php
							$only_assigned_query = '';
							if($role == 'Sales Representative' || $role == 'Backend Operator'){
								if($show_assigned_customers_only == '1'){
									$only_assigned_query = " AND a.`salesperson_id` = '$user_id'";
								}
							}
							$query = "SELECT a.`has_orders`, a.`account_number`, a.`hashed_id`, a.`business_name`, a.`shipping_city`, a.`shipping_state`, a.`salesperson_id`, b.`first_name`, b.`last_name` FROM `customers` a left join `users` b on a.`salesperson_id` = b.`uid`  WHERE a.`clientid` = '$clientid' $active_query $only_assigned_query";
							$result = mysqli_query($link, $query); 
							while($row = mysqli_fetch_array($result)) {
								$del_id_type = 'list_customers_php_delete';
								if($row['has_orders'] == 'yes'){$del_id_type = 'list_customers_php_inactive';}
								echo '<tr>
								<td style="display:none;">'.htmlspecialchars($row["account_number"]).'</td>
								<td data-label="Customer ID" style="display:none;">'.htmlspecialchars($row["hashed_id"]).'</td>
								<td data-label="Account Number">'.htmlspecialchars($row["account_number"]).'</td>
								<td data-label="Business Name">'.htmlspecialchars(ucwords(strtolower($row["business_name"]))).'</td>
								<td data-label="State">'.htmlspecialchars(ucwords(strtolower($row['shipping_city']))).' '.htmlspecialchars(strtoupper($row['shipping_state'])).'</td>
								<td data-label="Salesperson" id="'.htmlspecialchars($row['salesperson_id']).'">'.htmlspecialchars(ucwords(strtolower($row['first_name']))). ' '.htmlspecialchars(ucwords(strtolower($row['last_name']))).'</td>';
								if($role != 'Sales Representative') { echo '<td><span class="action-icons"><a href="edit-customer.php?account='.htmlspecialchars($row["account_number"]).'&token='.htmlspecialchars($row["hashed_id"]).'">
				<i class="fas fa-edit"></i></a><i id="'.$del_id_type.$row['hashed_id'].'" class="fas fa-trash-alt"></i></span></td>'; }
								echo '</tr>'; 
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
<input type="hidden" id="subject" name="subject" value="cust" />
<!-- Modal -->
<div class="modal fade" id="modal_delete_customer" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Delete Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
			<div class="row mb-3">
				<div class="col">
					<h6>Are you sure you want to delete the selected customer?</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">No</button>
				</div>
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-primary btn-block" id="list_customers_php_yes_btn">Yes</button>
				</div>
			</div>		
		  </div>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_deactivate_customer" tabindex="-1" role="dialog" aria-labelledby="modal_title2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title2">Deactivate Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
			<div class="row mb-3">
				<div class="col">
					<h6>This customer is linked to existing invoices. Would you like to make it inactive?</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">No</button>
				</div>
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-primary btn-block" id="list_customers_php_yes_deactivate_btn">Yes</button>
				</div>
			</div>		
		  </div>
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="assing_salesperson" tabindex="-1" aria-labelledby="assing_salespersonLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assing_salespersonLabel">Assign Salesperson</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
			<label for="salesperson">Salesperson</label>
			<select class="form-control salesperson" id="salesperson">
				<?php echo get_salesperson_list($link, $clientid); ?>
			</select>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-assign-salesperson">Save</button>
      </div>
    </div>
  </div>
</div>
<?php 
function get_salesperson_list($link, $clientid){
	$options = '';
	$query = "SELECT `uid`, `first_name`, `last_name` FROM `users` WHERE `clientid` = '$clientid'";
	$result = mysqli_query($link, $query);
	$options.= '<option></option>';
	while($row=mysqli_fetch_array($result)){
		$options.= '<option value="'.$row['uid'].'">';
		$options.= htmlspecialchars($row['first_name']).' '.htmlspecialchars($row['last_name']);
		$options.= '</option>';
	}
	return $options;
}
?>
<?php
$additional_script = ''; ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>