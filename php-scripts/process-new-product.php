<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

//check if at least item code and desciption is supplied
if (isset($_POST['cert_code']) && !empty($_POST['cert_code']) && isset($_POST['description']) && !empty($_POST['description'])){ //condition 1
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
 $department = '';
 $sub_department = '';
 $category = '';
 $brand = '';
 $active = '';
 $tax_id = '';
 $lowest_allowed = '';
 $highest_allowed = '';
 $cases_on_pallet = '';
$on_special = '';
$special_start = '';
$special_end = '';
$special_price = '';
$special_batch = '';
$push_item = '';
$push_reason = '';
$push_batch = '';
 
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
 if (isset($_POST['cost']) && !empty($_POST['cost'])){$case_cost = $_POST['cost'];}
 if (isset($_POST['case_cost']) && !empty($_POST['case_cost'])){$case_cost = $_POST['case_cost'];}
  if (isset($_POST['weight_case']) && !empty($_POST['weight_case'])){$weight_case = $_POST['weight_case'];}
  if (isset($_POST['weight_unit']) && !empty($_POST['weight_unit'])){$weight_unit = $_POST['weight_unit'];}
  if (isset($_POST['memo']) && !empty($_POST['memo'])){$memo = $_POST['memo'];}
  if (isset($_POST['supplier']) && !empty($_POST['supplier'])){$supplier = $_POST['supplier'];}
  if (isset($_POST['supplier_code']) && !empty($_POST['supplier_code'])){$supplier_code = $_POST['supplier_code'];}
  if (isset($_POST['department']) && !empty($_POST['department'])){$department = $_POST['department'];}
  if (isset($_POST['sub_department']) && !empty($_POST['sub_department'])){$sub_department = $_POST['sub_department'];}
  if (isset($_POST['category']) && !empty($_POST['category'])){$category = $_POST['category'];}
  if (isset($_POST['brand']) && !empty($_POST['brand'])){$brand = $_POST['brand'];}
  if (isset($_POST['tax_id']) && !empty($_POST['tax_id'])){$tax_id = $_POST['tax_id'];}
  if (isset($_POST['lowest_allowed']) && !empty($_POST['lowest_allowed'])){$lowest_allowed = $_POST['lowest_allowed'];}
  if (isset($_POST['highest_allowed']) && !empty($_POST['highest_allowed'])){$highest_allowed = $_POST['highest_allowed'];}
  if (isset($_POST['cases_on_pallet']) && !empty($_POST['cases_on_pallet'])){$cases_on_pallet= $_POST['cases_on_pallet'];}
if (isset($_POST['on_special']) && !empty($_POST['on_special'])){$on_special= $_POST['on_special'];}
if (isset($_POST['special_start']) && !empty($_POST['special_start'])){$special_start= $_POST['special_start'];}
if (isset($_POST['special_end']) && !empty($_POST['special_end'])){$special_end= $_POST['special_end'];}
if (isset($_POST['special_price']) && !empty($_POST['special_price'])){$special_price= $_POST['special_price'];}
if (isset($_POST['special_batch']) && !empty($_POST['special_batch'])){$special_batch= $_POST['special_batch'];}
if (isset($_POST['push_item']) && !empty($_POST['push_item'])){$push_item= $_POST['push_item'];}
if (isset($_POST['push_reason']) && !empty($_POST['push_reason'])){$push_reason= $_POST['push_reason'];}
if (isset($_POST['push_batch']) && !empty($_POST['push_batch'])){$push_batch= $_POST['push_batch'];}
  
  
  

	
	
	$stmt = $link->prepare("INSERT INTO `grocery_products` (`uniqueid`, `upc`, `case_barcode`, `cert_code`, `size_unit`, `description`, `Pack`, `size_amount`, `QtyOnHand`, `package`, `normal_price`, `case_price`, `cost`, `case_cost`, `weight_case`, `weight_unit`, `memo`, `supplier`, `supplier_code`, `department`, `sub_department`, `category`, `brand`, `active`, `tax_id`, `lowest_allowed`, `highest_allowed`,`cases_on_pallet`,`on_special`,`special_start`,`special_end`,`special_price`,`special_batch`, `push_item`, `push_reason`, `push_batch`, `clientid`,`created_by`) VALUES (UUID(),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'yes',?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param('ssssssssssssssssssssssssssssssssssss',$upc,$case_barcode,$cert_code,$size_unit,$description,$Pack,$size_amount,$QtyOnHand,$package,$normal_price,$case_price,$cost,$case_cost,$weight_case,$weight_unit,$memo,$supplier,$supplier_code,$department,$sub_department,$category,$brand, $tax_id, $lowest_allowed, $highest_allowed,$cases_on_pallet, $on_special, $special_start, $special_end, $special_price, $special_batch, $push_item, $push_reason, $push_batch, $clientid, $_SESSION['user']);
	$stmt->execute();
	
	$stmt->close();
	
	$stmt = $link->prepare("INSERT INTO `inventory_history` (`item`, `clientid`, `entered_by`, `type`, `qty`) VALUES (?,?,?,'rec',?)");
	$stmt->bind_param('ssss',$cert_code,$clientid, $_SESSION['user'],$QtyOnHand);
	$stmt->execute();
	$stmt->close();
	
	$stmt = $link->prepare("SELECT `uniqueid` FROM `grocery_products` WHERE `cert_code` = ? AND `clientid` = ?");
	$stmt->bind_param('ss', $cert_code, $clientid);
	$stmt->execute();
	$stmt->bind_result($cd);
	while($stmt->fetch()){
		$uid = $cd;
	}
	$stmt->close();
	
	if(isset($_POST['sac'])){
		header('location: ../new-product.php?clone='.$uid);
	}else{
		header('location: ../edit-product.php?success=1&product='.$uid);
	}
	
			

}else{ //if condition 1 false
	header('location: ../new-product.php?error=1');
}


?>