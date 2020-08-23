<?php

if (isset($_POST['changeto']) && isset($_POST['id'])){
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');  
	
	$invoice_hash = $_POST['id'];
	$invoice_status_received = $_POST['changeto'];
	$invoice_status = '';
	
	if($invoice_status_received == 'Processing'){
		$invoice_status = 'Processing';
	}
	if($invoice_status_received == 'Shipped'){
		$invoice_status = 'Shipped';
	}
	if($invoice_status_received == 'Delivered'){
		$invoice_status = 'Delivered';
	}
	
	
	$stmt = $link->prepare('INSERT INTO `order-status-history`(`invoice_number_hash`, `datetime`, `status`, `clientid`) VALUES (?,NOW(),?,?)');
	$stmt->bind_param('sss', $invoice_hash,  $invoice_status, $clientid);
	$stmt->execute();
	$stmt->close();
	
	$stmt = $link->prepare('UPDATE `orders` SET `status` = ? WHERE `clientid` = ? AND `invoice_number_hash` = ?');
	$stmt->bind_param('sss', $invoice_status, $clientid, $invoice_hash );
	$stmt->execute();
	$stmt->close();
	
	
}

?>