<?php
$page_title = 'Payments';

$more_css = '<style>#list_payments_php_table1_filter{display:none;}</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">';

$more_script = '<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<?php
$order_type = 'invoice';
$customer_detail_query = '';
$customer_hashid = '';
$datefrom = date('Y-m-d', strtotime('-90 days'));
$dateto = date('Y-m-d');
$method_query = '';
$method = '';
$refno = '%%';
$invno = '%%';
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
		$method = $_GET['method'];
	}	
}

if(isset($_GET['refno']) ){
	
		$refno = "%".$_GET['refno']."%";
	
}

if(isset($_GET['invno']) && !empty($_GET['invno'])){
	
		$invno = $_GET['invno'];
	
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
<input type="hidden" id="invoicehash" value="" />
<input type="hidden" id="customerhash" value="" />
<input type="hidden" id="paymentid" value="" />
<input type="hidden" id="pdatefrom" value="<?php echo $datefrom; ?>" />
<input type="hidden" id="pdateto" value="<?php echo $dateto; ?>" />
<input type="hidden" id="customerfilter" value="<?php echo $customer_hashid; ?>" />
<input type="hidden" id="page-requesting" value="payments-page" />

<div class="container-fluid">
	<div class="row">
		<div class="col">
			<li class="btn btn-light mb-2 mr-1 float-right" id="print-payment-history"><i class="fas fa-print mr-1"></i>Print</li>
			<li class="btn btn-light mb-2 mr-1 float-right" id="download-payment-history"><i class="fas fa-download mr-1"></i>Download</li>
			<li class="btn btn-light mb-2 mr-1 float-right"><i  class="fas fa-share-square mr-1"></i>Send</li>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col">
			<div class="card">
				<div class="card-body">
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
			<option <?php if($method == 'Cash'){ echo 'selected'; } ?>>Cash</option>
			<option <?php if($method == 'Check'){ echo 'selected'; } ?>>Check</option>
			<option <?php if($method == 'Money Order'){ echo 'selected'; } ?>>Money Order</option>
			<option <?php if($method == 'EFT'){ echo 'selected'; } ?>>EFT</option>
			<option <?php if($method == 'Wire Payment'){ echo 'selected'; } ?>>Wire Payment</option>
			<option <?php if($method == 'Online Payment'){ echo 'selected'; } ?>>Online Payment</option>
		</select>
      </div>
	   <div class="col-md-4 mb-3">
        <label for="refno">Reference Number</label>
		
        <input class="form-control" name="refno" id="refno" type="text" value="<?php if(isset($_GET['refno']) && !empty($_GET['refno'])){echo htmlspecialchars($_GET['refno']);} ?>">
      </div>
	   <div class="col-md-4 mb-3">
        <label for="invno">Invoice Number</label>
		
        <input class="form-control" name="invno" id="invno" type="text" value="<?php if(isset($_GET['invno']) && !empty($_GET['invno'])){echo htmlspecialchars($_GET['invno']);} ?>">
      </div>
	 </div>
	   <input type="submit" class="btn btn-primary shadow mb-2" id="sbbtn" value="Search" />
      
  </form>

				
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
			<li id="edit-payment"><i class="fas fa-file-invoice"></i>Edit</li>
			
			<li id="delete-payment"><i class="fas fa-trash-alt"></i>Delete</li>
		</ul>
		</div>
	</div>
			<div class="row">
				<div class="col">
				
					
				
				
<table class="row-border" id="list_payments_php_table1">


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
	<tfoot>
		<tr>
			<th style="display:none;"></th>
			<th style="display:none;"></th>
			<th style="display:none;"></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>			
		</tr>
	</tfoot>
	<tbody>
		<?php
		$query = "SELECT a.`payment_id`, a.`invoice_hash`, a.`pay_date`, a.`pay_amount`, a.`payment_method`, a.`reference_no`, b.`invoice_number`, c.`business_name`, a.`customer_hashed_id` FROM `payments` a LEFT JOIN `orders` b ON a.`invoice_hash` = b.`invoice_number_hash` AND b.`clientid` = '$clientid' LEFT JOIN `customers` c on a.`customer_hashed_id` = c.`hashed_id` AND c.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`pay_date` >= '$datefrom' AND a.`pay_date` <= '$dateto' AND a.`reference_no` LIKE ? AND b.`invoice_number` LIKE ? $customer_detail_query $method_query ORDER BY a.`pay_date` DESC";
		
		$stmt = $link->prepare($query);
		$stmt->bind_param('ss', $refno, $invno);
		$stmt->execute();
		$stmt->bind_result($pid, $inha, $pda, $pam, $pme, $rno, $inu, $bna, $chi);
		
		while($stmt->fetch()) { 
			echo '<tr>
			
			<td data-label="invoicehashid" style="display:none;">'.htmlspecialchars($inha).'</td>
			<td data-label="customerid" style="display:none;" >'.htmlspecialchars($chi).'</td>
			<td data-label="paymentid"  style="display:none;" >'.htmlspecialchars($pid).'</td>
			<td data-label="Date" id="'.htmlspecialchars($pid).'">'.date('m/d/Y', strtotime($pda)).'</a></td>
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

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?php require('include/invoice-popups.php'); ?>


<?php
$additional_script = '<script type="text/javascript">
$(document).ready(function() {
	$(".customer_select").select2();
   
} );
</script>'; ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>