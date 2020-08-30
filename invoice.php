<?php
$page_title = 'Invoice';
$more_script = '<link rel="stylesheet" href="css/invoice.css">
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>
<script type="text/javascript" src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<?php
if(isset($_GET['invoice']) && !empty($_GET['invoice'])){
	
		$hashed_invoice_number = $_GET['invoice'];
		$invoice_number = '';
		$customer_hash = '';
		$invoice_date = '';
		$entered_by = '';
		$salesperson = '';
		$terms = '';
		$sub_total = '$0.00';
		$order_type = '';
		$tax = 0;
		
		$business_name = '';
		$business_street_address_line1 = '';
		$business_street_address_line2 = '';
		$business_phone = '';
		$business_fax = '';
		
		
		$customer_acc_number = '';
		$billto_customer = '';
		
		$billto_address_line1 = '';
		$billto_address_line2 = '';
		$billto_phone = '';
		$billto_fax = '';
		
		$shipto_address_line1 = '';
		$shipto_address_line2 = '';
		$shipto_phone = '';
		$shipto_fax = '';
		
		$query = "SELECT `invoice_number`, `customer_hash`, `date_started`, `entered_by`, `retail`, `terms`, `order_type`, `tax` FROM `orders` WHERE `invoice_number_hash` = ? AND `clientid` = '$clientid'";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $hashed_invoice_number);
		$stmt->execute();
		$stmt->bind_result($inn, $ch, $ds, $eb, $re, $te, $ot, $tx);
		while($stmt->fetch()){
			$invoice_number = htmlspecialchars($inn);
			$customer_hash = $ch;
			$invoice_date = htmlspecialchars($ds);
			$entered_by = $eb;
			$sub_total = $re;
			$terms = $te;
			$order_type = $ot;
			$tax = $tx;
		}
		if($terms == '0'){
			$terms = 'COD';
		}else{
			$terms = $terms.' Days'; 
		}
		$stmt->close();
		
		$query = "SELECT `company_name`, `address1`, `address2`, `city`, `state`, `zip_code`, `phone1`, `fax` FROM `clients` WHERE `clientid` = '$clientid'";
		$stmt = $link->prepare($query);
		$stmt->execute();
		$stmt->bind_result($rslt1, $rslt2, $rslt3, $rslt4, $rslt5, $rslt6, $rslt7, $rslt8);
		while($stmt->fetch()){
			$business_name = $rslt1;
			$business_street_address_line1 = htmlspecialchars($rslt2).' '.htmlspecialchars($rslt3);
			$business_street_address_line2 = htmlspecialchars($rslt4).' '.htmlspecialchars($rslt5).' '.htmlspecialchars($rslt6);
			$business_phone = htmlspecialchars($rslt7);
			$business_fax = htmlspecialchars($rslt8);
		}
		$stmt->close();
		
		$query = "SELECT `display_code` FROM `users` WHERE `clientid` = '$clientid' AND `email_address` = '$entered_by'";
		$stmt = $link->prepare($query);
		$stmt->execute();
		$stmt->bind_result($rslt1);
		while($stmt->fetch()){
			$salesperson = $rslt1;
			
		}
		$stmt->close();
		
		$query = "SELECT `account_number`, `business_name`, `shipping_address1`, `shipping_address2`, `shipping_city`, `shipping_state`, `shipping_zip_code`, `shipping_phone_number1`, `shipping_phone_number1ext`, `shipping_fax`, `mailing_address1`, `mailing_address2`, `mailing_city`, `mailing_state`, `mailing_zip_code`, `mailing_phone_number1`, `mailing_phone_number1ext`, `mailing_fax` FROM `customers` WHERE `clientid` = '$clientid' AND `hashed_id` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $customer_hash);
		$stmt->execute();
		$stmt->bind_result($ac_nu, $bu_na, $sh_ad1, $sh_ad2, $sh_ci, $sh_st, $sh_zi, $sh_ph, $sh_ex, $sh_fa, $ma_ad1, $ma_ad2, $ma_ci, $ma_st, $ma_zi, $ma_ph, $ma_ex, $ma_fa);
		while($stmt->fetch()){
			$customer_acc_number = htmlspecialchars($ac_nu);
			$billto_customer = htmlspecialchars($bu_na);
			
			$billto_address_line1 = htmlspecialchars($sh_ad1).' '.htmlspecialchars($sh_ad2);
			$billto_address_line2 = htmlspecialchars($sh_ci). ' '.htmlspecialchars($sh_st).' '.htmlspecialchars($sh_zi);
			$billto_phone = htmlspecialchars($sh_ph).' '.htmlspecialchars($sh_ex);
			$billto_fax = htmlspecialchars($sh_fa);
			
			$shipto_address_line1 = htmlspecialchars($ma_ad1).' '.htmlspecialchars($ma_ad2);
			$shipto_address_line2 = htmlspecialchars($ma_ci). ' '.htmlspecialchars($ma_st).' '.htmlspecialchars($ma_zi);
			$shipto_phone = htmlspecialchars($ma_ph).' '.htmlspecialchars($ma_ex);
			$shipto_fax = htmlspecialchars($ma_fa);
		}
		$stmt->close();
		
		$query = "SELECT b.`description` description, a.`department` id FROM `grocery_products` a left join `department` b on a.`department` = b.`id` AND b.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`department` <> '0' GROUP BY a.`department` ORDER BY b.`description` LIMIT 1";
		$result = mysqli_query($link, $query);
		$cat = "uncat";
		while ($row = mysqli_fetch_array($result)){
			$cat = $row['id'];
			
		}
		
}else{
	die("Sorry, this page doesn't exist");

}
 ?>
 <input type="hidden" id="invoicehash" value="<?php echo htmlspecialchars($hashed_invoice_number); ?>" />
<input type="hidden" id="customerhash" value="<?php echo $customer_hash; ?>" />
<input type="hidden" id="invoice-number" value="<?php echo $invoice_number; ?>" />
<input type="hidden" id="doc-type" value="invoice" />
<input type="hidden" id="paymentid" value="" />
<ul class="invoice-top-buttons">
	<a href="order.php?acat=<?php echo $cat; ?>&customer=<?php echo $customer_hash; ?>&order=<?php echo $hashed_invoice_number; ?>"><li id="edit-order"><i class="fas fa-edit" style="text-decoration:none !important;" ></i>Edit</li></a>
	<!--<li id="view-order"><i class="fas fa-file-invoice"></i>View</li>-->
	<li id="print-order"><i class="fas fa-print"></i>Print</li>
	<li id="download-order"><i class="fas fa-download"></i>Download</li>
	<li id="send-order"><i class="fas fa-share-square"></i>Send</li>
	<li id="pull-sheet"><i class="fas fa-list"></i>Pull Sheet</li>
	<li id="delete-order"><i class="fas fa-trash-alt"></i>Delete</li>
	<?php if($order_type == 'invoice'){ ?>
		<li id="pay-invoice"><i class="fas fa-file-invoice-dollar"></i>Pay</li>
		<li id="payment-history"><i class="fas fa-money-check-alt"></i>Payments</li>
		
	<?php } ?>
	
	
</ul>
<span class="info-message-green" style="display:none" id="email-sent-success">E-mail successfully sent.</span>
<div class="invoice-container">
	<div class="company-info">
		<span class="company-info-header"><?php echo $business_name; ?></span>
		<?php echo $business_street_address_line1; ?><br/>
		<?php echo $business_street_address_line2; ?><br/>
		<?php echo $business_phone; ?><br/>
		<?php echo $business_fax; ?><br/>
	</div>
	<div class="invoice-info">
		<span class="invoice-title"><?php echo ucwords($order_type); ?></span><br/>
		<div class="invoice-info-group"><span class="invoice-info-box">Date</span><span class="invoice-info-box"><?php echo date('m/d/Y', strtotime($invoice_date)); ?></span></div>
		<div class="invoice-info-group"><span class="invoice-info-box"><?php echo ucwords($order_type); ?> No.</span><span class="invoice-info-box"><?php echo $invoice_number; ?></span></div>
	</div>
	<div class="bill-to">
		<span class="bill-ship-header">Bill To</span>
		<?php echo $billto_customer; ?><br>
		<?php echo $billto_address_line1; ?><br>
		<?php echo $billto_address_line2; ?><br>
		<?php echo $billto_phone; ?><br>
		<?php echo $billto_fax; ?><br>
	</div>
	<div class="ship-to">
		<span class="bill-ship-header">Ship To</span>
		<?php echo $billto_customer; ?><br>
		<?php echo $shipto_address_line1; ?><br>
		<?php echo $shipto_address_line2; ?><br>
		<?php echo $shipto_phone; ?><br>
		<?php echo $shipto_fax; ?><br>
	</div>
	<div class="add-info">
		<table class="add-info-table">
			<tr>
				<td>Customer No.</td>
				<td>Salesperson</td>
				<td>Terms</td>
				<td>Ship Via</td>
			</tr>
			<tr>
			<td><?php echo $customer_acc_number; ?></td>
			<td><?php echo $salesperson; ?></td>
			<td><?php echo $terms; ?></td>
			<td>Own</td>
			</tr>
		</table>
	</div>
	<div class="invoice-items">
		<table class="invoice-items-table">
			<tr>
				<th>Item No.</th>
				<th>Description</th>
				<th>Qty</th>
				<th>Price</th>
				<th>Total</th>
			</tr>
			<tr>
				<?php 
					$query = "SELECT `cert_code`, `qty`, `description`, `retail`, `total_price`, `Pack`, `size` FROM `requested_items` WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ?";
					$stmt = $link->prepare($query);
					$stmt->bind_param('s', $hashed_invoice_number);
					$stmt->execute();
					$stmt->bind_result($ce_co, $qy, $des, $ret, $to_pr, $pk, $sz);
					$x = 0;
					while($stmt->fetch()){
						$x++;
						echo '<tr>';
						echo '<td>'.htmlspecialchars($ce_co).'</td>';
						echo '<td><input type="text" value="'.htmlspecialchars($des).' '.$pk.'x'.$sz.'" id="desc" /></td>';
						echo '<td><input type="text" value="'.htmlspecialchars($qy).'" id="qty" style="width:75px;"/></td>';
						echo '<td align="right"><input type="text" value="'.htmlspecialchars($ret).'" id="retail" style="width:120px;"/></td>';
						echo '<td align="right">'.htmlspecialchars($to_pr).'</td>';
						echo '</tr>';
					}
					if($x < 20){
						for($n=$x; $n<=20; $n++){
							echo '<tr>';
							echo '<td>&nbsp;</td>';
							echo '<td>&nbsp;</td>';
							echo '<td>&nbsp;</td>';
							echo '<td align="right">&nbsp;</td>';
							echo '<td align="right">&nbsp;</td>';
							echo '</tr>';
						}
					}
				?>
			</tr>
		</table>
	</div>
	<div class="total-box">
		<table class="total-box-table">
			<tr><td>Subtotal</td><td><?php echo "$".number_format($sub_total, 2); ?></td></tr>
			<tr><td>Tax</td><td>$<?php echo number_format($tax, 2); ?></td></tr>
			<tr><td>Shipping</td><td>$0.00</td></tr>
			<tr><td>Total</td><td><?php echo "$".number_format($sub_total + $tax, 2); ?></td></tr>
		</table>

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
	$('#payment_date').val(new Date().toDateInputValue());
} );
</script>




<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>