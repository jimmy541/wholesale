<?php
$page_title = 'Orders';
$more_script = '<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>
<script type="text/javascript" src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>


<?php

$order_type = 'invoice';
$order_type_btn = 'Quotes';
if(isset($_GET['show']) && $_GET['show'] == 'quotes'){
	$order_type = 'quote';
	$order_type_btn = 'Invoices';
}
$customer_detail = '';
$customer_detail_query = '';
if(isset($_GET['customer']) && !empty($_GET['customer'])){
	$customer_detail = $_GET['customer'];
	
	//make sure provided customer exists in database and get sanitized result
	
	$query = "SELECT `customer_hash` FROM `orders` WHERE `clientid` = '$clientid' AND `customer_hash` = ? LIMIT 1";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $customer_detail);
	$stmt->execute();
	$stmt->bind_result($cuh);
	while ($stmt->fetch()) {
		$customer_detail_query = " AND a.`customer_hash` = '$cuh' ";
	}
	
}

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
 ?>
<h3 class="page-header"><?php echo ucwords($order_type).'s'; ?></h3>
<input type="hidden" id="invoicehash" value="" />
<input type="hidden" id="customerhash" value="" />
<input type="hidden" id="invoice-number" value="<?php echo $invoice_number; ?>" />
<input type="hidden" id="paymentid" value="" />
<input type="hidden" id="doc-type" value="invoice" />
<div class="container-fluid">
	<div class="row">
		<div class="col">
			<ul class="invoice-top-buttons">
				<li id="view-order"><i class="fas fa-file-invoice"></i>View</li>
				<li id="print-order"><i class="fas fa-print"></i>Print</li>
				<li id="download-order"><i class="fas fa-download"></i>Download</li>
				<li id="send-order"><i class="fas fa-share-square"></i>Send</li>
				<li id="pull-sheet"><i class="fas fa-list"></i>Pull Sheet</li>
				<li id="delete-order"><i class="fas fa-trash-alt"></i>Delete</li>
				<?php if($order_type == 'invoice'){ ?>
					<li id="pay-invoice"><i class="fas fa-file-invoice-dollar"></i>Pay</li>
					<li id="payment-history"><i class="fas fa-money-check-alt"></i>Payments</li>
					
				<?php } ?>
				<li style="float:right;" id="show-quotes"><i class="fas fa-file-alt"></i><?php echo $order_type_btn; ?></li>
				
			</ul>
		</div>
	</div>
	
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
			
			<div class="row">
		<div class="col">
			<ul class="invoice-top-buttons">
				<li id="view-order"><i class="fas fa-file-invoice"></i>View</li>
				<li id="print-order"><i class="fas fa-print"></i>Print</li>
				<li id="download-order"><i class="fas fa-download"></i>Download</li>
				<li id="send-order"><i class="fas fa-share-square"></i>Send</li>
				<li id="pull-sheet"><i class="fas fa-list"></i>Pull Sheet</li>
				<li id="delete-order"><i class="fas fa-trash-alt"></i>Delete</li>
				<?php if($order_type == 'invoice'){ ?>
					<li id="pay-invoice"><i class="fas fa-file-invoice-dollar"></i>Pay</li>
					<li id="payment-history"><i class="fas fa-money-check-alt"></i>Payments</li>
					
				<?php } ?>
				<li style="float:right;" id="show-quotes"><i class="fas fa-file-alt"></i><?php echo $order_type_btn; ?></li>
				
			</ul>
		</div>
	</div>
	<div class="row">
	<div class="col">
					<span style="display:none" id="email-sent-success">E-mail successfully sent.</span>
					<table class="row-border" id="gtable">

						<thead>
							<tr>
								<th style="display:none;">Invoice ID</th>
								<th style="display:none;">CutomerID</th>
								<th>Date</th>
								<th><?php echo ucwords($order_type); ?> Number</th>
								<th>Customer</th>
								<th>Total</th>
								<?php if($order_type == 'invoice'){?><th>Balance</th><th>Status</th><?php } ?>
								
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th style="display:none;">Invoice ID</th>
								<th style="display:none;">CutomerID</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<?php if($order_type == 'invoice'){?><th></th><th></th><?php } ?>
								
							</tr>
						</tfoot>
						<tbody>
							<?php
							$query = "SELECT a.`invoice_number_hash`, a.`customer_hash`, a.`date_started`, a.`invoice_number`, (a.`retail` + a.`tax`) tx, a.`retail` + a.`tax` - a.`paid_total` bln, a.`status`, b.`business_name` FROM `orders` a LEFT JOIN `customers` b ON a.`customer_hash` = b.`hashed_id` AND b.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`order_type` = '$order_type' $customer_detail_query ORDER BY a.`date_started` DESC";
							$result = mysqli_query($link, $query); 
							while($row = mysqli_fetch_array($result)) { 
								echo '<tr>
								
								<td data-label="hashid" style="display:none;">'.htmlspecialchars($row['invoice_number_hash']).'</td>
								<td data-label="hashcustomer" style="display:none;" >'.htmlspecialchars($row['customer_hash']).'</td>
								<td data-label="Date">'.date('m/d/Y', strtotime($row["date_started"])).'</a></td>
								<td data-label="'.ucwords($order_type).' #" id="'.htmlspecialchars($row['invoice_number_hash']).'">'.$row["invoice_number"].'</td>
								<td data-label="Customer">'.htmlspecialchars($row['business_name']).'</td>
								<td data-label="Amount">'.$row['tx'].'</td>';
								if($order_type == 'invoice'){
									echo '<td data-label="Balance" id="invbalance'.htmlspecialchars($row['invoice_number_hash']).'">'.$row['bln'].'</td>';
									
									$order_status = '';
									$btn_style = '';
									if($row['status'] == 'Processing'){
										$order_status = 'Processing';
										$btn_style = 'btn-warning';
									}
									if($row['status'] == 'Shipped'){
										$order_status = 'Shipped';
										$btn_style = 'btn-info';
									}
									if($row['status'] == 'Delivered'){
										$order_status = 'Delivered';
										$btn_style = 'btn-success';
									}
									
									echo '<td data-label="Status"><button type="button" id="changestatus'.htmlspecialchars($row['invoice_number_hash']).'" class="btn '.$btn_style.'">'.$order_status.'</button></td>';
								}
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

<?php require('include/invoice-popups.php'); ?>





<script type="text/javascript">
$(document).ready(function() {
    Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
	});
	$('#gtable').parent().addClass('table-responsive');
	$('#payment_date').val(new Date().toDateInputValue());
} );
</script>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>