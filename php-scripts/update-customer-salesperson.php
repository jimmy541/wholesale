<?php
if (isset($_POST['customerid']) && isset($_POST['saleseperson_id'])){
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');  
	
	$customerid = $_POST['customerid'];
	$saleseperson_id = $_POST['saleseperson_id'];
	
	
	
	
	
	
	$stmt = $link->prepare('UPDATE `customers` SET `salesperson_id` = ? WHERE `clientid` = ? AND `hashed_id` = ?');
	$stmt->bind_param('sss', $saleseperson_id, $clientid, $customerid );
	$stmt->execute();
	$stmt->close();
	
	
}

?>