<?php $page_title = 'Place an order';?>
<?php $more_script = '<link rel="stylesheet" type="text/css" href="css/orderpage.css">
<script type="text/javascript" src="js/order-page.js"></script>
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/thickbox.js"></script>'; ?>

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<h3 class="page-header"><?php echo $page_title; ?></h3>

<?php
$customer = '';
$customer_name = '';
$account_number = '';
$order = '';
$invoicenumber = '';
$ordertype = '';
if(isset($_GET['customer']) && !empty($_GET['customer'])){
	$customer = htmlspecialchars($_GET['customer']);
	$stmt = $link->prepare("SELECT `account_number`, `business_name` FROM `customers` WHERE `clientid` = '$clientid' AND `hashed_id` = ?");
	$stmt->bind_param('s', $customer);
	$stmt->execute();
	$stmt->bind_result($an, $bn);
	while($stmt->fetch()){
		$customer_name = $bn;
		$account_number = $an;
	}
	if(empty($account_number)){
		die("No customer is selected.");
	}else{
		if(isset($_GET['order']) && !empty($_GET['order'])){
			$order = htmlspecialchars($_GET['order']);
			$escaped_order = mysqli_real_escape_string($link, $_GET['order']);
			$stmt = $link->prepare("SELECT `invoice_number`, `order_type` FROM `orders` WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ?");
			$stmt->bind_param('s', $order);
			$stmt->execute();
			$stmt->bind_result($innum, $or_ty);
			while($stmt->fetch()){
				$invoicenumber = $innum;
				$ordertype = $or_ty;
			}
			
		}
	}

}else{
	die("No customer is selected.");
}
?>


<input type="hidden" id="current_customer" value="<?php echo $customer; ?>"/>
<input type="hidden" id="current_order" value="<?php echo $order; ?>"/>
<input type="hidden" id="order_type" value="<?php echo $ordertype; ?>"/>



<div class="container-fluid">
	<div class="row">
		<div class="col">
			<h5>Customer: <?php echo $account_number.', '.$customer_name; ?><span style="float:right; display:block;">Order #<?php echo $invoicenumber; ?></span></h5>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<form action="invoice.php"><input type="hidden" name="invoice" value="<?php echo $order; ?>"><button type="submit" class="genbtns btn btn-primary shadow btn-sm float-right">Preview</button></form>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-md-3">
			<div class="card">
				<div class="card-body">
				<div class="p-3 bg-light text-dark font-weight-bold">Departments</div>
				<nav class="nav flex-column">
					<?php	
							$style = 'MainCatLinks';
							if (isset($_GET['acat'])){
									if ($_GET['acat'] == 'uncat'){
										$style = 'MainCatLinksSelected';
									}
							}
							$result = mysqli_query($link, "SELECT `uniqueid` FROM `grocery_products` WHERE `clientid` = '$clientid' AND `department` = '0' AND `active` = 'yes' LIMIT 1");
							while($row=mysqli_fetch_array($result)){
								echo '<a class="'.$style.'" href="?acat=uncat&customer='.$customer.'&order='.$order.'"/>Uncategorized</a>';
							}
							$query = "SELECT b.`description` description, a.`department` id FROM `grocery_products` a left join `department` b on a.`department` = b.`id` AND b.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`department` <> '0' AND a.`active` = 'yes' GROUP BY a.`department` ORDER BY b.`description`";
							$result = mysqli_query($link, $query);
							while ($row = mysqli_fetch_array($result)){
								$style = 'MainCatLinks';
								if (isset($_GET['acat'])){
									if ($_GET['acat'] == $row['id']){
										$style = 'MainCatLinksSelected';
									}
								}
								echo '<a class="'.$style.'" href="?acat='.$row['id'].'&customer='.$customer.'&order='.$order.'"/>'.htmlspecialchars($row['description']).'</a>';
							}
						?>
				</nav>
				</div>
			</div>
			</div>
	
		<div class="col-12 col-md-9">
		<div class="card">
				<div class="card-body">
	<?php
	if (isset($_GET['acat'])){
		 
		
		if ($_GET['acat'] == 'uncat'){
			echo '<div class="p-3 mb-2 bg-light text-dark font-weight-bold">Uncategorized</div>';
		}else{
			echo '<div class="p-3 mb-2 bg-light text-dark font-weight-bold">'.getDescription($link, 'department', $clientid, $_GET['acat']).'</div>';
		}
		$getid = '';
		$stmt = $link->prepare("SELECT `id` FROM `department` WHERE `id` = ? AND `clientid` = '$clientid'");
		$stmt->bind_param('s', $_GET['acat']);
				$stmt->execute();
				$stmt->bind_result($dd);
				while($stmt->fetch()){
					$getid=htmlspecialchars($dd);
				}
				$stmt->close();

		$query = "SELECT DISTINCT `sub_department` FROM `grocery_products` WHERE `department` = '".$getid."' AND `active` = 'yes'";
		$result = mysqli_query($link, $query);
		while ($row = mysqli_fetch_array($result)){
			//List B Categories
			
			echo '<h1>'.getDescription($link, 'sub_department', $clientid, $row['sub_department']).'</h1>';
			
					echo '<div class="cCatDiv">';
					//Listing C Categories

						//get quantity inside requested_items table
						
						echo '<div class="itemsMainBox">';
							$query2 = "SELECT a.*, b.`description` brnd, c.`description` wu, d.`qty` FROM `grocery_products` a LEFT JOIN `brands` b ON a.`brand` = b.`id` AND b.`clientid` = '$clientid' LEFT JOIN `weight_units` c ON a.`size_unit` = c.`id` AND c.`clientid` = '$clientid' LEFT JOIN `requested_items` d ON a.`cert_code` = d.`cert_code` AND d.`invoice_number_hash` = '$escaped_order' AND d.`clientid` = '$clientid' WHERE a.`department` = '".$getid."' AND a.`sub_department` = '".$row['sub_department']."' AND a.`clientid` = '$clientid' AND a.`active` = 'yes'";
							
							$result2 = mysqli_query($link, $query2);
									$cnt = 0;
									$currentSize = 0;
									$newCat = 'true';
									$cert_code = '';

								while($row2 = mysqli_fetch_array($result2)){
									$cnt += 1;
									echo '<div class="SingleItemBox" id="SingleItemBox'.htmlspecialchars($row2['cert_code']).'">'.htmlspecialchars($row2['brnd']).' '.htmlspecialchars($row2['description']).'
										<br/>'.htmlspecialchars($row2['cert_code']).' <b>'.htmlspecialchars($row2['upc']).'</b><br/>
										Retail: <span style="color:green;">'.number_format($row2['case_price'], 2, '.', ',').'</span>
										Pack: '.@number_format($row2['Pack'], 0).'
										<div class="Size">'.number_format($row2['size_amount'], 1, '.', ',').' '.htmlspecialchars($row2['wu']).'</div>';
										$colorStyle = '';
										
										if($row2['QtyOnHand'] > 0){
											$colorStyle = 'background-color:#e5ffe6;';
										}else{
											$colorStyle = 'background-color:#ffe5e5;';
										}
										echo '<div class="Qty" style="'.$colorStyle.'">'.($row2['QtyOnHand']+$row2['qty']).'</div>';
										//<div class="MonAvg"></div>
										echo '<div class="editIcon"><a href="edit-product.php?product='.$row2['uniqueid'].'" target="blank"><img src="images/edit.png"/></a></div>';
										if (file_exists('pics/'.htmlspecialchars($row2['image-id']))) {
											echo '<a href="pics/'.htmlspecialchars($row2['image-id']).'" title="" class="thickbox"><img class="tableImg" src="pics/'.htmlspecialchars($row2['image-id']).'"></a>';
											}
										
											echo '<div class="orderNumbersMain" id="OrderDiv'.htmlspecialchars($row2['cert_code']).'"><center><input class="orderButtons" type="button" value="-" id="minus'.$row2['cert_code'].'"/><input class="orderInput" value="'.checkIfOrderPlaced($link, $row2['cert_code'], $clientid, $customer, $order).'" type="hidden" id="qty'.$row2['cert_code'].'"/><input id="plus'.$row2['cert_code'].'" class="orderButtons" type="button" value="+"/></center></div>
											<div class="greenOrderStatus" id="greenCircle'.$row2['cert_code'].'" '.checkForGreenCircle($link, $row2['cert_code'], $clientid, $customer, $order).'" >'.checkIfOrderPlaced($link, $row2['cert_code'], $clientid, $customer, $order).'</div>
										</div>&nbsp;';
										$newCat = 'false';
										$cert_code = $row2['cert_code'];

									if ($cnt == 4){
									
										$cnt = 0;
										echo '<br/>';
										
									}
									$currentSize = number_format($row2['size_amount'] * 1, 0);
									
								}

							echo '</div>';

					echo '</div>';
		}

	}

	?>

	
	</div>
	</div>
		

		
		
		</div>

	</div>
	<!-- close container-fluid -->
</div>






<?php 
function getDescription($link, $table, $clientid, $id){
			$rslt = '';
			$stmt = $link->prepare("SELECT `description` FROM `$table` WHERE `clientid` = '$clientid' AND `id` = ?");
			$stmt->bind_param('s', $id);
			$stmt->execute();
			$stmt->bind_result($ds);
			while($stmt->fetch()){
				$rslt=htmlspecialchars($ds);
			}
			$stmt->close();
			return $rslt;
}
function checkIfOrderPlaced($link, $cert_code, $clientid, $customer, $order){
			$qty = '0';
			$stmt = $link->prepare("SELECT `qty` FROM `requested_items` WHERE `cert_code` = ? AND `clientid` = '$clientid' AND `customer_account_number` = ? AND `invoice_number_hash` = ?");
			$stmt->bind_param('sss', $cert_code, $customer, $order);
			$stmt->execute();
			$stmt->bind_result($qt);
			while($stmt->fetch()){
				$qty = $qt;
			}
			return $qty;
}
function checkForGreenCircle($link, $cert_code, $clientid, $customer, $order){
			$result = '';
			if (checkIfOrderPlaced($link, $cert_code, $clientid, $customer, $order) > 0){
			
			$result = 'style="display:block;"';
			}
			return $result;
}

?>

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>