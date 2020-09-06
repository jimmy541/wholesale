<?php
$page_title = 'Account History';
$more_script = '<style>#gtable_filter{display:none;}</style><script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>
<script type="text/javascript" src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

$hashed_customer_number = '';
$datefrom = date('Y-m-d');
$dateto = date('Y-m-d');
if(isset($_GET['customer_select']) && !empty($_GET['customer_select'])){
	$hashed_customer_number = $_GET['customer_select'];
	$customer_name = '';
	$query = "SELECT `business_name` FROM `customers` WHERE `hashed_id` = ? AND `clientid` = '$clientid'";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $hashed_customer_number);
	$stmt->execute();
	$stmt->bind_result($cusname);
	$stmt->fetch();
    $customer_name = $cusname;
	$stmt->close();
	
	if(isset($_GET['datefrom']) && validateDate($_GET['datefrom']) && isset($_GET['dateto']) && validateDate($_GET['dateto'])){
		$datefrom = $_GET['datefrom'];
		$dateto = $_GET['dateto'];
    }
	
}



function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<div class="container-fluid">
	<div class="row mb-2">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<form method="get">
						<div class="form-group row">
						  <div class="col-3">
							<label for="datefrom">From</label>
							
							<input class="form-control" name="datefrom" id="datefrom" type="date" value="<?php echo $datefrom; ?>">
						  </div>
						  <div class="col-3">
							<label for="dateto">To</label>
							<input class="form-control" name="dateto" id="dateto" type="date" value="<?php echo $dateto; ?>">
						  </div>
						  <div class="col-5">
							<label for="customer_select">Customer</label>
							<select class="customer_select form-control" id="customer_select" name="customer_select" style="height: 38px !important">
								<option></option>
								<?php
									$query = "SELECT `hashed_id`, `business_name` FROM `customers` WHERE `clientid` = '$clientid' ORDER BY `business_name` ASC";
									$stmt = $link->prepare($query);
									$stmt->execute();
									$stmt->bind_result($hashedid, $busname);
									while($stmt->fetch()){
										$selected = '';
										if($hashedid == $hashed_customer_number){$selected = 'selected';}
										echo '<option value="'.htmlspecialchars($hashedid).'" '.$selected.'>'.htmlspecialchars($busname).'</option>';
									}
									$stmt->close();
								?>
							</select>
						  </div>
						  <div class="col-1">
							<label for="" style="visibility:hidden !important;">Search</label>
							<input type="submit" class="btn btn-primary shadow mb-2" value="Search" />
						  </div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row mb-2">
		<div class="col">
			<div class="card">
				<div class="card-body">
<?php 
	if(!empty($customer_name)){
		echo '<h3>Customer: '.$customer_name.'</h3><br>';
		echo '<div class="container-fluid bg-light">
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
			<div class="w-100"></div>';
			
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
			
		   
		  echo '</div>
		</div>';
	} 
?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<ul class="invoice-top-buttons">
				<li id="printacchistory"><i class="fas fa-file-invoice"></i>Print</li>
				<li id="downloadacchistory"><i class="fas fa-download"></i>Download</li>
				<li id="sendhistory"><i class="fas fa-share-square"></i>Send</li>
				
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
<input type="hidden" id="customerhash" value="<?php echo $hashed_customer_number; ?>"/>
<input type="hidden" id="datefrom" value="<?php echo $datefrom; ?>"/>
<input type="hidden" id="dateto" value="<?php echo $dateto; ?>"/>
<input type="hidden" id="invoicehash" value=""/>
<input type="hidden" id="doc-type" value="ahistory" />
<span class="info-message-green" style="display:none" id="email-sent-success">E-mail successfully sent.</span>
<table class="row-border" id="gtable">
	<thead>
		<tr>
		<th style="dispay:none;">Invoice Hash</th>
			<th style="display:none;">Account Hashed ID</th>
			<th>Date</th>
			<th>Description</th><!-- balance forward, invoice #, payment, late fee -->
			<th>Amount</th>
			<th>Balance</th>
			
					
		</tr>
	</thead>
	<tfoot>
		<tr>
		<th style="dispay:none;">Invoice Hash</th>
			<th style="display:none;">Account Hashed ID</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			
					
		</tr>
	</tfoot>
	<tbody>
		<?php
		$running_balance = 0;
		
		//empty the temperory table
		$query = "DELETE FROM `temp_account_history` WHERE `clientid` = '$clientid' AND `customer_hash` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $hashed_customer_number);
		$stmt->execute();
		$stmt->close();
		
		//insert the records in the temporary table
		$query = "INSERT INTO `temp_account_history`(`customer_hash`, `in_pay_id`, `date`, `description`, `amount`, `type`, `clientid`) SELECT `customer_hash`, `invoice_number_hash` id, `date_started` dt, CONCAT('Invoice No. ', `invoice_number`) description, `retail` + `tax` amnt, 'plus' as type, `clientid` FROM `orders` WHERE `clientid` = '$clientid' AND `order_type` = 'invoice' AND `customer_hash` = ? AND `date_started` >= '$datefrom' AND `date_started` <= '$dateto' union all SELECT `customer_hashed_id`, `payment_id` id, `pay_date` dt, CONCAT(`payment_method`, ' Payment ', `reference_no`) description, `pay_amount` amnt, 'minus' as type, `clientid` FROM `payments` WHERE `clientid` = '$clientid' AND `customer_hashed_id` = ? AND `pay_date` >= '$datefrom' AND `pay_date` <= '$dateto'";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ss', $hashed_customer_number, $hashed_customer_number);
		$stmt->execute();
		$stmt->close();
		
		
		//get the total of all payments made
		$query = "SELECT SUM(`pay_amount`) FROM `payments` WHERE `clientid` = '$clientid' AND `customer_hashed_id` = ? AND `pay_date` < '$datefrom'";
		
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $hashed_customer_number);
		$stmt->execute();
		$stmt->bind_result($pmnts);
		$payments_to_date = '';
		
		while($stmt->fetch()){
			$payments_to_date = $pmnts;
		}
		$stmt->close();
		
		$balancealltime = '0';
		
		
		
			
			//get the total of all invoices to date
			$query = "SELECT SUM(`retail`) + SUM(`tax`) blnall FROM `orders` WHERE `clientid` = '$clientid' AND `customer_hash` = ? AND `date_started` < '$datefrom' AND `order_type` = 'invoice'";
			
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $hashed_customer_number);
			$stmt->execute();
			$stmt->bind_result($blnall);
			
			
			while($stmt->fetch()){
				$balancealltime = $blnall;
			}
			$stmt->close();
			$running_balance = $balancealltime - $payments_to_date;
		
		
		
		//get the result from the temporary table sorted
		$query = "SELECT `in_pay_id`, `date`, `description`, `amount`, `type` FROM `temp_account_history` WHERE `clientid` = '$clientid' AND `customer_hash` = ? AND `date` >= '$datefrom' AND `date` <= '$dateto' ORDER BY 2 ASC;";
		
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $hashed_customer_number);
		$stmt->execute();
		$stmt->bind_result($id, $dt, $desc, $amnt, $type);
		
		
		while($stmt->fetch()){
		
			echo  '<tr>
				<td data-label="hashid" style="display:none;">'.htmlspecialchars($id).'</td>
				<td data-label="custhash" style="display:none;">'.htmlspecialchars($hashed_customer_number).'</td>
				<td data-label="Date">'.$dt.'</td>
				<td data-label="Invoice Number">';
				
					if(strpos($desc, 'Invoice') !== false){
						echo '<a href="invoice.php?invoice='.htmlspecialchars($id).'">'.htmlspecialchars($desc).'</a>';
					}else{
						echo htmlspecialchars($desc);
					}
						
				echo '</td><td data-label="Amount">'.number_format($amnt, 2).'</td>';
				if($type == 'plus'){
					$running_balance += $amnt;
				}elseif ($type == 'minus'){
					$running_balance -= $amnt;
				}
				
				
				echo '<td data-label="Balance">'.number_format($running_balance, 2).'</td>';
				
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
	$('.customer_select').select2();
	
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
