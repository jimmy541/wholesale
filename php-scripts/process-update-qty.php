<?php
if (isset($_POST['cert_code']) && isset($_POST['customer'])){
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');  
	$cert_code = $_POST['cert_code'];
	if(is_numeric($_POST['qty'])){
		$qty = $_POST['qty'];
	}else{
		$qty = 1;
	}
	$customer = $_POST['customer'];
	$order = $_POST['order'];
	$ordertype = $_POST['ordertype'];
	$pricing_level = '';
	$pricing_value = '';
	
	$query = "SELECT `pricing_level`, `pricing_level_value` FROM `customer_settings` WHERE `clientid` = '$clientid' AND `hashed_id` = ? LIMIT 1";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $customer);
	$stmt->execute();
	$stmt->bind_result($pr_le, $pr_va);
	while($stmt->fetch()){
		$pricing_level = $pr_le;
		$pricing_value = $pr_va;
	}
	$stmt->close();
	
	
	$query = "SELECT a.`case_cost`, a.`case_price`, a.`description`, a.`Pack`, a.`size_amount`, c.`description` su, b.`description` brnd, d.`value` tx FROM `grocery_products` a LEFT JOIN `brands` b ON a.`brand` = b.`id` AND b.`clientid` = '$clientid' LEFT JOIN `weight_units` c ON a.`size_unit` = c.`id` AND c.`clientid` = '$clientid' LEFT JOIN `product_tax_types` d ON a.`tax_id` = d.`id` AND d.`clientid` = '$clientid' WHERE a.`cert_code` = ? AND a.`clientid` = '$clientid' LIMIT 1";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $cert_code);
	$stmt->execute();
	$stmt->bind_result($ccost, $cprice, $desc, $pk, $sz, $su, $brnd, $tx);
	$caseCost = 0;
	$casePrice = 0;
	$totalCost = 0;
	$totalPrice = 0;
	$caseTax = 0;
	$totalTax = 0;
	$item_description = '';
	$brand = '';
	$pack = '1';
	$size = '';
	while($stmt->fetch()){
		$caseCost = $ccost;
		$casePrice = $cprice;
		$brand = $brnd;
		$pack = $pk;
		$caseTax = $tx;
		$size = $sz.' '.$su;
		if(!empty($brand)){$item_description = $brnd.' '.$desc;}else{
			$item_description = $desc;
		}
	}
	
	if($pricing_level == 'Normal'){
		
	}elseif ($pricing_level == 'Decrease By %'){
		$casePrice = number_format($casePrice - ($casePrice * ($pricing_value / 100)), 2); 
	}elseif ($pricing_level == 'Decrease By $'){
		$casePrice = number_format($casePrice - $pricing_value, 2);
	}
	
	if($caseCost > 0){
		$totalCost = $caseCost * $qty;
	}
	if($casePrice > 0){
		$totalPrice = $casePrice * $qty;
	}
	if($caseTax > 0 && $casePrice > 0){
		$totalTax = $casePrice * $qty * $caseTax * 0.01 ;
	}
	$stmt->close();

	$found = 'false';
	$query = "SELECT `cert_code` FROM `requested_items` WHERE `cert_code` = ? AND `clientid` = '$clientid' AND `customer_account_number` = ? AND `invoice_number_hash` = ? LIMIT 1";
	$stmt = $link->prepare($query);
	$stmt->bind_param('sss', $cert_code, $customer, $order);
	$stmt->execute();
	$stmt->bind_result($fnd);
	$stmt->fetch();
	if($fnd){
		$found = 'true';
	}
	$stmt->close();
	
	if ($found == 'true'){
		$query = "UPDATE `requested_items` SET `description` = ?, `qty` = '$qty', `cost` = '$caseCost', `retail` = '$casePrice', `total_cost` = '$totalCost', `total_price` = '$totalPrice', `Pack` = '$pack', `size` = '$size', `tax` = '$totalTax' WHERE `cert_code` = ? AND `clientid` = '$clientid' AND `customer_account_number` = ? AND `invoice_number_hash` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssss', $item_description, $cert_code, $customer, $order);
		$stmt->execute();
		$stmt->close();
	
	}
	elseif ($found == 'false') {
		$query = "INSERT INTO `requested_items` (`cert_code`, `description`, `qty`, `clientid`, `customer_account_number`, `invoice_number_hash`, `cost`, `retail`, `total_cost`, `total_price`, `Pack`, `size`, `tax`) VALUES (?,?, '$qty', '$clientid', ?, ?, '$caseCost', '$casePrice', '$totalCost', '$totalPrice', '$pack', '$size', '$totalTax')";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssss', $cert_code, $item_description, $customer,$order);
		$stmt->execute();
		$stmt->close();
		$ec = 'Inserted';
	}
	$invcost = 0;
	$invprice = 0;
	$invtax = 0;
	
	$query = "SELECT SUM(`total_cost`) cost, SUM(`total_price`) price, SUM(`tax`) tax FROM `requested_items` WHERE `clientid` = '$clientid' AND `customer_account_number` = ? AND `invoice_number_hash` = ?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('ss', $customer, $order);
	$stmt->execute();
	$stmt->bind_result($rcost, $rprice, $rtax);
	while($stmt->fetch()){
		$invcost = $rcost;
		$invprice = $rprice;
		$invtax = $rtax;
	}
	$query = "UPDATE `orders` SET `cost` = '$invcost', `retail` = '$invprice', `tax` = '$invtax' WHERE `clientid` = '$clientid' AND `customer_hash` = ? AND `invoice_number_hash` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ss', $customer, $order);
		$stmt->execute();
		$stmt->close();
	
	if($ordertype == 'invoice'){
		$query = "UPDATE `grocery_products` SET `QtyOnHand` = (`QtyOnHand` - 1) WHERE `cert_code` = ? AND `clientid` = '$clientid'";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $cert_code);
		$stmt->execute();
		$stmt->close();
	}
}
?>