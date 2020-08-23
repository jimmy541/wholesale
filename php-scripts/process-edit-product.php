<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

$errorCode = '';

if (isset($_POST['cert_code']) && !empty($_POST['cert_code']) && isset($_POST['description']) && !empty($_POST['description'])){ //condition 1
	$uniqueid = $_POST['productid'];
	$cert_code = $_POST['cert_code'];
	$description = $_POST['description'];

	$upc = '';
	$case_barcode = '';
	$size_unit = '';
	$Pack = '';
	$size_amount = '';
	$QtyOnHand = '';
	$package = '';
	$normal_price = '';
	$case_price = '';
	$cost = '';
	$case_cost = '';
	
	$weight_case = '';
	$weight_unit = '';
	$memo = '';
	$supplier = '';
	$supplier_code = '';
	$a_category = '';
	$b_category = '';
	$c_category = '';
	$brand = '';
	$active = 'no';
	$tax_id = '';
	if (isset($_POST['upc']) && !empty($_POST['upc'])){$upc = $_POST['upc'];}
	if (isset($_POST['case-barcode']) && !empty($_POST['case-barcode'])){$case_barcode = $_POST['case-barcode'];}
	if (isset($_POST['cert_code']) && !empty($_POST['cert_code'])){$cert_code = $_POST['cert_code'];}
	if (isset($_POST['size_unit']) && !empty($_POST['size_unit'])){$size_unit = $_POST['size_unit'];}
	if (isset($_POST['Pack']) && !empty($_POST['Pack'])){$Pack = $_POST['Pack'];}
	if (isset($_POST['size_amount']) && !empty($_POST['size_amount'])){$size_amount = $_POST['size_amount'];}
	if (isset($_POST['QtyOnHand']) && !empty($_POST['QtyOnHand'])){$QtyOnHand = $_POST['QtyOnHand'];}
	if (isset($_POST['package']) && !empty($_POST['package'])){$package = $_POST['package'];}
	if (isset($_POST['normal_price']) && !empty($_POST['normal_price'])){$normal_price = $_POST['normal_price'];}
	if (isset($_POST['case_price']) && !empty($_POST['case_price'])){$case_price = $_POST['case_price'];}
	if (isset($_POST['cost']) && !empty($_POST['cost'])){$cost = $_POST['cost'];}
	if (isset($_POST['case_cost']) && !empty($_POST['case_cost'])){$case_cost = $_POST['case_cost'];}
	
	if (isset($_POST['weight_case']) && !empty($_POST['weight_case'])){$weight_case = $_POST['weight_case'];}
	if (isset($_POST['weight_unit']) && !empty($_POST['weight_unit'])){$weight_unit = $_POST['weight_unit'];}
	if (isset($_POST['memo']) && !empty($_POST['memo'])){$memo = $_POST['memo'];}
	if (isset($_POST['supplier']) && !empty($_POST['supplier'])){$supplier = $_POST['supplier'];}
	if (isset($_POST['supplier_code']) && !empty($_POST['supplier_code'])){$supplier_code = $_POST['supplier_code'];}
	if (isset($_POST['a_category']) && !empty($_POST['a_category'])){$a_category = $_POST['a_category'];}
	if (isset($_POST['b_category']) && !empty($_POST['b_category'])){$b_category = $_POST['b_category'];}
	if (isset($_POST['c_category']) && !empty($_POST['c_category'])){$c_category = $_POST['c_category'];}
	if (isset($_POST['brand']) && !empty($_POST['brand'])){$brand = $_POST['brand'];}
	if (isset($_POST['active'])){$active = 'yes';}
	if (isset($_POST['tax_id']) && !empty($_POST['tax_id'])){$tax_id = $_POST['tax_id'];}

		
	//get qty on hand in database
	$qtyinsystem = '';
	$stmt = $link->prepare("SELECT `QtyOnHand` FROM `grocery_products` WHERE `clientid`= ? AND `cert_code`= ?");
	$stmt->bind_param('ss', $clientid, $cert_code);
	$stmt->execute();
	$stmt->bind_result($qt);
	while($stmt->fetch()){
		$qtyinsystem = $qt;
	}
	
	
	$stmt = $link->prepare('UPDATE `grocery_products` SET `cert_code` = ?, `upc`= ?,`case_barcode`= ?,`size_unit`= ?,`description`= ?,`Pack`= ?,`size_amount`= ?,`QtyOnHand`= ?,`package`= ?,`normal_price`= ?,`case_price`= ?,`cost`= ?,`case_cost`= ?,`weight_case`= ?,`weight_unit`= ?,`memo`= ?,`supplier`= ?,`supplier_code`= ?,`a_category`= ?,`b_category`= ?,`c_category`= ?,`brand`= ?,`active`= ?, `tax_id` = ? WHERE `clientid`= ? AND `uniqueid` = ?');
	$stmt->bind_param('ssssssssssssssssssssssssss',$cert_code,$upc,$case_barcode,$size_unit,$description,$Pack,$size_amount,$QtyOnHand,$package,$normal_price,$case_price,$cost,$case_cost,$weight_case,$weight_unit,$memo,$supplier,$supplier_code,$a_category,$b_category,$c_category,$brand,$active, $tax_id, $clientid, $uniqueid);
	$stmt->execute();
	$stmt->close();
	
	
	if($qtyinsystem != $QtyOnHand){
		$newqtvalue = $QtyOnHand - $qtyinsystem ;
		$stmt = $link->prepare("INSERT INTO `inventory_history` (`item`, `clientid`, `entered_by`, `type`, `qty`) VALUES (?,?,?,'adj',?)");
		$stmt->bind_param('ssss',$cert_code,$clientid, $_SESSION['user'],$newqtvalue);
		$stmt->execute();
		$stmt->close();
	}
	
	
	header("location: ../edit-product.php?success=1&product=$uniqueid");
}else{ // if condition 3 false
	$errorCode = '1';
header('location: ../edit-product.php?error='.$errorCode);
}

?>