<?php
$page_title = 'Account Statement';
$more_script = '<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>
<script type="text/javascript" src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');
if(isset($_GET['customer']) && !empty($_GET['customer'])){
	$hashed_customer_number = $_GET['customer'];
	$customer_name = '';
	$query = "SELECT `business_name` FROM `customers` WHERE `hashed_id` = ? AND `clientid` = '$clientid'";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $hashed_customer_number);
	$stmt->execute();
	$stmt->bind_result($cusname);
	$stmt->fetch();
    $customer_name = $cusname;
	$stmt->close();
	
	
}else{
	die("Customer doesn't exist");
}
?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<input type="hidden" id="customerhash" value="<?php echo $hashed_customer_number; ?>"/>
<input type="hidden" id="invoicehash" value=""/>
<input type="hidden" id="doc-type" value="statement" />

<ul class="nav">
	<a class="nav-link" href="accounts-unpaid.php">Unpaid Accounts /</a>
</ul>
<hr>
<h3>Customer: <?php echo $customer_name; ?></h3>
<br>

<span class="info-message-green" style="display:none" id="email-sent-success">E-mail successfully sent.</span>

<div class="container-fluid">
		<div class="row mb-2">
			<div class="col">
				
					<li class="btn btn-light mb-2 mr-1 float-right" id="printstatement"><i class="fas fa-file-invoice mr-1"></i>Print</li>
					<li class="btn btn-light mb-2 mr-1 float-right" id="downloadstatement"><i class="fas fa-download mr-1"></i>Download</li>
					<li class="btn btn-light mb-2 mr-1 float-right" id="sendstatement"><i class="fas fa-share-square mr-1"></i>Send</li>
			
			</div>
		</div>
	<div class="row mb-2">
		<div class="col">
			<div class="card">
				<div class="card-body">
					 <div class="row">
						<div class="col bg-danger" style="height:5px !important"> </div>
						<div class="col bg-warning" style="height:5px !important"> </div>
						<div class="col" style="height:5px !important; background-color:#FFFF00!important;"> </div>
						<div class="col bg-success" style="height:5px !important"> </div>
						<div class="col bg-secondary" style="height:5px !important"> </div>
						<div class="w-100"></div>
						<div class="col">Over 90 Days</div>
						<div class="col">Over 60 Days</div>
						<div class="col">Over 30 Days</div>
						<div class="col">Less Than 30 Days</div>
						<div class="col">Total</div>
						<div class="w-100"></div>
							<?php
								$query = "SELECT SUM(`retail` + `tax` - `paid_total`) bln, SUM(case when `retail` + `tax` - `paid_total` <> 0 and `date_started` < DATE(DATE_ADD(NOW(), INTERVAL -90 DAY)) then `retail` + `tax` - `paid_total` else 0 end) as overnin, SUM(case when `retail` + `tax` - `paid_total` <> 0 and `date_started` < DATE(DATE_ADD(NOW(), INTERVAL -60 DAY)) and `date_started` >= DATE(DATE_ADD(NOW(), INTERVAL -90 DAY)) then `retail` + `tax` - `paid_total` else 0 end) as oversix, SUM(case when `retail` + `tax` - `paid_total` <> 0 and `date_started` < DATE(DATE_ADD(NOW(), INTERVAL -30 DAY)) and `date_started` >= DATE(DATE_ADD(NOW(), INTERVAL -60 DAY)) then `retail` + `tax` - `paid_total` else 0 end) as overthirty, SUM(case when `retail` + `tax` - `paid_total` <> 0 and `date_started` > DATE(DATE_ADD(NOW(), INTERVAL -30 DAY)) then `retail` + `tax` - `paid_total` else 0 end) as current FROM `orders` WHERE `clientid` = '$clientid' AND `customer_hash` = ? AND `order_type` = 'invoice' AND (`retail` + `tax` - `paid_total`) <> 0 ";
								$stmt = $link->prepare($query);
								$stmt->bind_param('s', $hashed_customer_number);
								$stmt->execute();
								$stmt->bind_result($bln, $over90, $over60, $over30, $curr);
								while($stmt->fetch()){
									echo '<div class="col font-weight-bold">'.number_format($over90, 2).'</div>
									<div class="col font-weight-bold">'.number_format($over60, 2).'</div>
									<div class="col font-weight-bold">'.number_format($over30, 2).'</div>
									<div class="col font-weight-bold">'.number_format($curr, 2).'</div>
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
					<table class="row-border" id="gtable">
					<caption>Account Statement</caption>
						<thead>
							<tr>
							<th style="dispay:none;">Invoice Hash</th>
								<th style="display:none;">Account Hashed ID</th>
								<th>Date</th>
								<th>Invoice Number</th>
								<th>Amount</th>
								<th>Balance</th>
								
										
							</tr>
						</thead>
						<tbody>
							<?php
							$query = "SELECT `invoice_number_hash`, `date_started`, `invoice_number`, `retail` + `tax` rt, `retail` + `tax` - `paid_total` bln FROM `orders` WHERE `clientid` = '$clientid' AND `customer_hash` = ? AND `order_type` = 'invoice' AND (`retail` + `tax` - `paid_total`) <> 0 ORDER BY `date_started` ASC";
							$stmt = $link->prepare($query);
							$stmt->bind_param('s', $hashed_customer_number);
							$stmt->execute();
							$stmt->bind_result($inhash, $ds, $invn, $ret, $bln);
							while($stmt->fetch()) { 
								echo '<tr disable-select>
									<td data-label="hashid" style="display:none;">'.htmlspecialchars($inhash).'</td>
									<td data-label="custhash" style="display:none;">'.htmlspecialchars($hashed_customer_number).'</td>
									<td data-label="Date">'.$ds.'</td>
									<td data-label="Invoice Number"><a href="invoice.php?invoice='.htmlspecialchars($inhash).'">'.htmlspecialchars($invn).'</a></td>
									<td data-label="Amount">'.number_format($ret, 2).'</td>
									<td data-label="Balance">'.number_format($bln, 2).'</td>';
									
								echo '</tr>'; 
							}
							$stmt->close();
							
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


<div class="populateDivSend" id="populateDivSend">
	<button type="button" class="close" aria-label="Close" id="closeIcon">
		<span aria-hidden="true">&times;</span>
	</button>
	<div class="container-fluid">
		<!-- open row -->
		<div class="row">
			<!-- open col -->
			<div class="col">
				
				<div class="mb-3">
					<label>Send To</label>
					<select class="form-control" id="emailto">
						
					</select>
				</div>
				<div class="mb-3" id="emailtoblock">
					<label>Email</label>
					<input type="text" class="form-control" id="emailaddress" />
				</div>
				<div class="mb-3">
					<label>Subject</label>
					<input type="text" class="form-control" id="emailsubject" />
				</div>
				<div class="mb-3">
					<label>Message</label>
					<textarea class="form-control" id="message_text" rows="4" cols="50"></textarea>
				</div>
				
				<div class="mb-3">
					<button class="btn btn-primary shadow btn-lg btn-block" id="send-email-button">Send</button>
				</div>
			<!-- close col -->
			</div>
		<!-- close row -->
		</div>
	<!-- close container -->
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