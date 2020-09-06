<?php
$page_title = 'Unpaid Accounts';
$more_script = '<style>#gtable_filter{display:none;}</style><script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>
<script type="text/javascript" src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<h3 class="page-header"><?php echo $page_title; ?></h3>


<input type="hidden" id="customerhash" value=""/>

 
	
		<div class="container-fluid bg-light">
		 
		</div>
	

<div class="container-fluid">
	<div class="row mb-2">
		<div class="col">
			<li class="btn btn-light mb-2 mr-1 float-right" id="print-list"><i class="fas fa-print"></i>Print</li>
			<li class="btn btn-light mb-2 mr-1 float-right" id="download-list"><i class="fas fa-download"></i>Download</li>
		</div>
	
	</div>
	
	<div class="row mb-2">
		<div class="col">
			<div class="card">
				<div class="card-body">
					 <div class="row">
						  <div class="col bg-danger" style="height:5px !important"> </div>
							<div class="col" style="height:5px !important; background-color:#FFFF00!important;"> </div>
							<div class="col bg-secondary" style="height:5px !important"> </div>
							<div class="w-100"></div>
							<div class="col">Past Due Total</div>
							<div class="col">Curent Total</div>
							<div class="col">Total Balance</div>
							<div class="w-100"></div>
							<?php
								$query = "SELECT SUM(a.`retail` + a.`tax` - a.`paid_total`) bln, SUM(case when a.`retail` + a.`tax` - a.`paid_total` <> 0 and a.`date_started` < DATE(DATE_ADD(NOW(), INTERVAL -`terms` DAY)) then a.`retail` + a.`tax` - a.`paid_total` else 0 end) as pastdue, SUM(case when a.`retail` + a.`tax` - a.`paid_total` <> 0 and a.`date_started` >= DATE(DATE_ADD(NOW(), INTERVAL -`terms` DAY)) then a.`retail` + a.`tax` - a.`paid_total` else 0 end) as current  FROM `orders` a WHERE a.`clientid` = '$clientid' AND a.`order_type` = 'invoice' AND (a.`retail` + a.`tax` - a.`paid_total`) <> 0";
								$stmt = $link->prepare($query);
								$stmt->execute();
								$stmt->bind_result($bln, $pastdue, $current);
								while($stmt->fetch()){
									echo '<div class="col font-weight-bold">'.number_format($pastdue, 2).'</div>
									<div class="col font-weight-bold">'.number_format($current, 2).'</div>
									<div class="col font-weight-bold">'.number_format($bln, 2).'</div>';
								}
								$stmt->close();
							?>
						   
					</div>
				</div>
			</div>
		</div>
	</div>


	
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
				<div class="row">
		<div class="col">
			<ul class="invoice-top-buttons-disabled">
				<li id="uncusstatement"><i class="fas fa-file-invoice"></i>Statement</li>
				
				
			</ul>
		</div>
	</div>
	<div class="row">
	<div class="col">
					<table class="row-border" id="gtable">
						<thead>
							<tr>
							<th style="dispay:none;"></th><!-- keep this line important -->
								<th style="display:none;">Account Hashed ID</th>
								<th>Account Number</th>
								<th>Business Name</th>
								<th>Past Due</th>
								<th>Current</th>
								<th>Total</th>
										
							</tr>
						</thead>
						<tfoot>
							<tr>
							<th style="dispay:none;"></th><!-- keep this line important -->
								<th style="display:none;">Account Hashed ID</th>
								<th>Account Number</th>
								<th>Business Name</th>
								<th></th>
								<th></th>
								<th></th>
										
							</tr>
						</tfoot>
						<tbody>
							<?php
							$query = "SELECT b.`account_number`, b.`business_name`, b.`hashed_id`, SUM(a.`retail` + a.`tax` - a.`paid_total`) bln, a.`terms`, SUM(case when a.`retail` + a.`tax` - a.`paid_total` <> 0 and a.`date_started` < DATE(DATE_ADD(NOW(), INTERVAL -`terms` DAY)) then a.`retail` + a.`tax` - a.`paid_total` else 0 end) as pastdue, SUM(case when a.`retail` + a.`tax` - a.`paid_total` <> 0 and a.`date_started` >= DATE(DATE_ADD(NOW(), INTERVAL -`terms` DAY)) then a.`retail` + a.`tax` - a.`paid_total` else 0 end) as current  FROM `orders` a LEFT JOIN `customers` b on a.`customer_hash` = b.`hashed_id` WHERE a.`clientid` = '$clientid' AND a.`order_type` = 'invoice' AND (a.`retail` + a.`tax` - a.`paid_total`) <> 0 GROUP BY a.`customer_hash`";
							$result = mysqli_query($link, $query); 
							while($row = mysqli_fetch_array($result)) { 
								echo '<tr><td></td>
									<td data-label="hashid" style="display:none;">'.htmlspecialchars($row['hashed_id']).'</td>
									<td data-label="Account Number">'.htmlspecialchars($row["account_number"]).'</td>
									<td data-label="Customer">'.htmlspecialchars($row['business_name']).'</td>
									<td data-label="Past Due">'.htmlspecialchars($row['pastdue']).'</td>
									<td data-label="Current">'.htmlspecialchars($row['current']).'</td>
									<td data-label="Total">'.number_format($row['bln'], 2).'</td>';
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
				
				







<script type="text/javascript">
$(document).ready(function() {
    Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
	});
	$('#payment_date').val(new Date().toDateInputValue());
	$('#gtable').parent().addClass('table-responsive');
	
	
	
} );
</script>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>