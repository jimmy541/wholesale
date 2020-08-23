<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

if (isset($_POST['customer']) && !empty($_POST['customer'])){
	$otype="invoice";
	if(isset($_POST['otype'])){
		if($_POST['otype'] == 'invoice' || $_POST['otype'] == 'quote'){
			$otype = $_POST['otype'];
		}
	}
	$orders_arr = array();
	$stmt = $link->prepare("SELECT `invoice_number_hash`, `date_started` FROM `orders` WHERE `status` = 'open' AND `clientid` = '$clientid' AND `customer_hash` = ? AND `order_type` = '$otype'");
	$stmt->bind_param('s', $_POST['customer']);
	$stmt->execute();
	$stmt->bind_result($inn, $ds);
	while($stmt->fetch()){
		$orders_arr[] = array("innum" => $inn, "dstarted" => $ds);
	}
	echo json_encode($orders_arr);
}




?>