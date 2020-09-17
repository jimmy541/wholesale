<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 
$found = 'false';

if (isset($_POST['batch_id']) && !empty($_POST['batch_id']) && isset($_POST['product_id']) && !empty($_POST['product_id']) && isset($_POST['single_case_price']) && !empty($_POST['single_case_price'])){ //condition 1
	$batch_id = $_POST['batch_id'];
	$product_id = $_POST['product_id'];
	$single_case_price = $_POST['single_case_price'];
	$item_code = '';
	$description = '';
	$size = '';
	$group_qty = '0';
	$group_case_price = '0.00';
	$product_uid = '';

	
	$stmt = $link->prepare("SELECT a.`uniqueid`, a.`cert_code`, a.`description`, a.`size_amount`, b.`description`, c.`description` FROM `grocery_products` a LEFT JOIN `weight_units` b on a.`size_unit` = b.`id` AND b.`clientid` = '$clientid' LEFT JOIN `brands` c on a.`brand` = c.`id` AND c.`clientid` = '$clientid' WHERE `uniqueid` = ? AND a.`clientid` = '$clientid'");
	$stmt->bind_param('s', $product_id);
	$stmt->bind_result($pruid, $cer, $desc, $size_unit, $unit, $brand);
	$stmt->execute();
	while($stmt->fetch()){
		$item_code = $cer;
		$description = $brand.' '.$desc;
		$size = $size_unit.' '.$unit;
		$product_uid = $pruid;
	}
	
	$stmt = $link->prepare('INSERT INTO `special_batch_products`(`id`, `item_code`, `single_case_price`, `group_qty`, `group_case_price`, `clientid`, `description`, `size`, `product_uid`) VALUES (?,?,?,?,?,?,?,?,?)');
	$stmt->bind_param('sssssssss',$batch_id, $item_code , $single_case_price, $group_qty, $group_case_price, $clientid, $description, $size, $product_uid);
	$stmt->execute();
	
	header("location: ../edit-special-batch.php?id=".htmlspecialchars($batch_id));
			

}else{ //if condition 1 false
	header('location: ../edit-special-batch.php?id='.htmlspecialchars($batch_id).'&error=1');
}


?>