<?php
$page_title = 'Payments';
$more_script = '<style>#gtable_filter{display:none;}</style><script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>
<script type="text/javascript" src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<?php
$order_type = 'invoice';
$customer_detail_query = '';
$customer_hashid = '';
$datefrom = date('Y-m-d', strtotime('-90 days'));
$dateto = date('Y-m-d');
$method_query = '';
$refno = '%%';
if(isset($_GET['customer']) && !empty($_GET['customer'])){
	$customer_hashid = $_GET['customer'];
	//make sure provided customer exists in database and get sanitized result
	
	$query = "SELECT `customer_hash` FROM `orders` WHERE `clientid` = '$clientid' AND `customer_hash` = ? LIMIT 1";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $customer_hashid);
	$stmt->execute();
	$stmt->bind_result($cuh);
	while ($stmt->fetch()) {
		$customer_detail_query = " AND a.`customer_hashed_id` = '$cuh' ";
	}
}

if(isset($_GET['method'])){
	if($_GET['method'] == 'Cash' || $_GET['method'] == 'Check' || $_GET['method'] == 'Money Order' || $_GET['method'] == 'EFT' || $_GET['method'] == 'Wire Payment' || $_GET['method'] == 'Online Payment'){
		$method_query = "AND a.`payment_method` = '".$_GET['method']."'";
	}	
}

if(isset($_GET['refno'])){
	
		$refno = "%".$_GET['refno']."%";
	
}

if(isset($_GET['datefrom']) && validateDate($_GET['datefrom']) && isset($_GET['dateto']) && validateDate($_GET['dateto'])){
		$datefrom = $_GET['datefrom'];
		$dateto = $_GET['dateto'];
    }
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
 ?>

<ul class="invoice-top-buttons">
	<li id="edit-payment"><i class="fas fa-file-invoice"></i>Edit</li>
	<li id="print-payment-history"><i class="fas fa-print"></i>Print</li>
	<li id="download-payment-history"><i class="fas fa-download"></i>Download</li>
	<li><i class="fas fa-share-square"></i>Send</li>
	<li id="delete-payment"><i class="fas fa-trash-alt"></i>Delete</li>
</ul>

<form method="get">
    <div class="form-row">
      <div class="col-md-3 mb-3">
        <label for="datefrom">From</label>
		
        <input class="form-control" name="datefrom" id="datefrom" type="date" value="<?php echo $datefrom; ?>">
      </div>
      <div class="col-md-3 mb-3">
        <label for="dateto">To</label>
        <input class="form-control" name="dateto" id="dateto" type="date" value="<?php echo $dateto; ?>">
      </div>
      <div class="col-md-6 mb-3">
        <label for="customer_select">Customer</label>
        <select class="customer_select form-control" id="customer_select" name="customer" style="height: 38px !important">
			<option></option>
			<?php
				$query = "SELECT `hashed_id`, `business_name` FROM `customers` WHERE `clientid` = '$clientid' ORDER BY `business_name` ASC";
				$stmt = $link->prepare($query);
				$stmt->execute();
				$stmt->bind_result($hashedid, $busname);
				while($stmt->fetch()){
					$selected = '';
					if($hashedid == $customer_hashid){$selected = 'selected';}
					echo '<option value="'.htmlspecialchars($hashedid).'" '.$selected.'>'.htmlspecialchars($busname).'</option>';
				}
				$stmt->close();
			?>
		</select>
      </div>
	 </div>
	 <div class="form-row">
	 <div class="col-md-4 mb-3">
        <label for="method_select">Method</label>
        <select class="customer_select form-control" id="method_select" name="method" style="height: 38px !important">
			<option></option>
			<option>Cash</option>
			<option>Check</option>
			<option>Money Order</option>
			<option>EFT</option>
			<option>Wire Payment</option>
			<option>Online Payment</option>
		</select>
      </div>
	   <div class="col-md-3 mb-3">
        <label for="refno">Reference Number</label>
		
        <input class="form-control" name="refno" id="refno" type="text" value="">
      </div>
	  <div class="col-md-4 mb-3">
        <label for="" style="visibility:hidden !important;">Search</label>
        <input type="submit" class="btn btn-primary mb-2" value="Search" />
      </div>
    </div>
  </form>

<input type="hidden" id="invoicehash" value="" />
<input type="hidden" id="customerhash" value="" />
<input type="hidden" id="paymentid" value="" />
<input type="hidden" id="pdatefrom" value="<?php echo $datefrom; ?>" />
<input type="hidden" id="pdateto" value="<?php echo $dateto; ?>" />
<input type="hidden" id="customerfilter" value="<?php echo $customer_hashid; ?>" />

<table class="row-border" id="gtable">
<caption>Payments</caption>
	<thead>
		<tr>
			<th style="display:none;">Invoice ID</th>
			<th style="display:none;">Customer ID</th>
			<th style="display:none;">PaymentID</th>
			<th>Date</th>
			<th>Business</th>
			<th>Amount</th>
			<th>Method</th>
			<th>Ref. No.</th>
			<th>Invoice #</th>			
		</tr>
	</thead>
	<tbody>
		<?php
		$query = "SELECT a.`payment_id`, a.`invoice_hash`, a.`pay_date`, a.`pay_amount`, a.`payment_method`, a.`reference_no`, b.`invoice_number`, c.`business_name`, a.`customer_hashed_id` FROM `payments` a LEFT JOIN `orders` b ON a.`invoice_hash` = b.`invoice_number_hash` AND b.`clientid` = '$clientid' LEFT JOIN `customers` c on a.`customer_hashed_id` = c.`hashed_id` AND c.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`pay_date` >= '$datefrom' AND a.`pay_date` <= '$dateto' AND a.`reference_no` = ? $customer_detail_query ORDER BY a.`pay_date` DESC";
		echo $query;
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $refno);
		$stmt->execute();
		$stmt->bind_result($pid, $inha, $pda, $pam, $pme, $rno, $inu, $bna, $chi);
		
		while($stmt->fetch()) { 
			echo '<tr>
			
			<td data-label="invoicehashid" style="display:none;">'.htmlspecialchars($inha).'</td>
			<td data-label="customerid" style="display:none;" >'.htmlspecialchars($chi).'</td>
			<td data-label="paymentid" style="display:none;" >'.htmlspecialchars($pid).'</td>
			<td data-label="Date">'.date('m/d/Y', strtotime($pda)).'</a></td>
			<td data-label="Business">'.htmlspecialchars($bna).'</a></td>
			<td data-label="Amount">'.$pam.'</td>
			<td data-label="Method">'.htmlspecialchars($pme).'</td>
			<td data-label="Ref No">'.htmlspecialchars($rno).'</td>
			<td data-label="Invoice Number"><a href="invoice.php?invoice='.htmlspecialchars($inha).'">'.htmlspecialchars($inu).'</a></td>';
			echo '</tr>'; 
		}
		$stmt->close();
		?>
</tbody>
</table>
<?php require('include/invoice-popups.php'); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.customer_select').select2();
    Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
	});
	$('#payment_date').val(new Date().toDateInputValue());
} );
</script>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>