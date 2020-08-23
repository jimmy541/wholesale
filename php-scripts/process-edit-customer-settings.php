<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

$errorCode = '';
$found = 'false';

if (isset($_POST['account']) && !empty($_POST['account']) && isset($_POST['token']) && !empty($_POST['token'])){ //condition 1
	$account = $_POST['account'];
	$token = $_POST['token'];
	
	$stmt = $link->prepare("SELECT `account_number` FROM `customer_settings` WHERE `account_number` = ? AND `hashed_id` = ?");
	$stmt->bind_param('ss', $account, $token);
	$stmt->execute();
	while($stmt->fetch()){
		$found = 'true';
	}
	
	if ($found == 'true'){
		$view_prices = 'no';
		$can_place_order = 'no';
		$can_view_history = 'no';
		$pricing_level = '';
		$dby = '';
		$terms = '0';
			
		if(isset($_POST['view_prices'])){$view_prices = 'yes';}
		if(isset($_POST['can_place_order'])){$can_place_order = 'yes';}
		if(isset($_POST['can_view_history'])){$can_view_history = 'yes';}
		if(isset($_POST['pricing_level']) && !empty($_POST['pricing_level'])){$pricing_level = $_POST['pricing_level'];}
		if(isset($_POST['dby']) && !empty($_POST['dby'])){$dby = $_POST['dby'];}
		if(isset($_POST['terms']) && !empty($_POST['terms'])){$terms = $_POST['terms'];}
				
		$stmt = $link->prepare('UPDATE `customer_settings` SET `view_prices`=?,`can_place_order`=?,`can_view_history`=?, `pricing_level`=?, `pricing_level_value` = ?, `terms` = ? WHERE `clientid`=? AND `account_number`=?');
		$stmt->bind_param('ssssssss',$view_prices, $can_place_order, $can_view_history, $pricing_level, $dby, $terms, $clientid, $account);
		$stmt->execute();
		header("location: ../edit-customer-settings.php?success=1&account=$account&token=$token");
	}else{
		header('location: ../dashboard.php');
		
	}	
	}else{ //if condition 2 false
		header('location: ../dashboard.php');
	}


?>