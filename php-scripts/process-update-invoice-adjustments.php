<?php header("Content-type: application/json"); ?>
<?php
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
//quantity changed
if (isset($_POST['id']) && isset($_POST['invoice']) && isset($_POST['qty']) && isset($_POST['total']) && !empty($_POST['id']) && !empty($_POST['invoice']) && !empty($_POST['qty']) && !empty($_POST['total']) && $_POST['update'] == 'qty'){
  
	if(is_numeric($_POST['id'])){
		$id = $_POST['id'];
	}else{
		$id = '0';
	}
	
	if(is_numeric($_POST['qty'])){
		$qty = $_POST['qty'];
	}else{
		$qty = 1;
	}
	
	if(is_numeric($_POST['total'])){
		$total = $_POST['total'];
	}else{
		$total = 1;
	}
	
	$invoice = $_POST['invoice'];
	
	
	
	$query = "SELECT `tax` / `total_price` tax FROM `requested_items` WHERE `clientid` = '$clientid' AND `id` = '$id' AND `invoice_number_hash` = ?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $invoice);
	$stmt->execute();
	$stmt->bind_result($tax);
	while($stmt->fetch()){
		$tax_rate = $tax;
	}
	$stmt->close();
	
	$total_tax = $tax_rate * $total;
		
		$query = "UPDATE `requested_items` SET `qty` = '$qty', `total_price` = '$total', `total_cost` = `cost` * $qty, `tax` = '$total_tax' WHERE `id` = '$id' AND `clientid` = '$clientid' AND `invoice_number_hash` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $invoice);
		$stmt->execute();
		$stmt->close();
	
	$query = "SELECT SUM(`total_cost`) cost, SUM(`total_price`) price, SUM(`tax`) tax FROM `requested_items` WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $invoice);
	$stmt->execute();
	$stmt->bind_result($rcost, $rprice, $rtax);
	while($stmt->fetch()){
		$invcost = $rcost;
		$invprice = $rprice;
		$invtax = $rtax;
	}
	
	
	$query = "UPDATE `orders` SET `cost` = '$invcost', `retail` = '$invprice', `tax` = '$invtax' WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $invoice);
		$stmt->execute();
		$stmt->close();
		
		$response = array('1',$invprice,$invtax, number_format($invprice + $invtax, 2));
				echo json_encode($response);
				die();
	
}
//price changed
//make sure current user is allowed to change price

if($allow_free_override == '1' || $allow_limited_override == '1'){							
	if (isset($_POST['id']) && isset($_POST['invoice']) && isset($_POST['retail']) && isset($_POST['total']) && !empty($_POST['id']) && !empty($_POST['invoice']) && !empty($_POST['retail']) && !empty($_POST['total']) && $_POST['update'] == 'retail'){
	
		if(is_numeric($_POST['id'])){
			$id = $_POST['id'];
		}else{
			$id = '0';
		}
		
		if(is_numeric($_POST['retail'])){
			$retail = $_POST['retail'];
		}else{
			$retail = 1;
		}
		
		if(is_numeric($_POST['total'])){
			$total = $_POST['total'];
		}else{
			$total = 1;
		}
		
		$invoice = $_POST['invoice'];
		
		
		
		$query = "SELECT `tax` / `total_price` tax FROM `requested_items` WHERE `clientid` = '$clientid' AND `id` = '$id' AND `invoice_number_hash` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $invoice);
		$stmt->execute();
		$stmt->bind_result($tax);
		while($stmt->fetch()){
			$tax_rate = $tax;
		}
		$stmt->close();
		
		$total_tax = $tax_rate * $total;
			
			$query = "UPDATE `requested_items` SET `retail` = '$retail', `total_price` = '$total', `total_cost` = `cost` * `qty`, `tax` = '$total_tax' WHERE `id` = '$id' AND `clientid` = '$clientid' AND `invoice_number_hash` = ?";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $invoice);
			$stmt->execute();
			$stmt->close();
		
		$query = "SELECT SUM(`total_cost`) cost, SUM(`total_price`) price, SUM(`tax`) tax FROM `requested_items` WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $invoice);
		$stmt->execute();
		$stmt->bind_result($rcost, $rprice, $rtax);
		while($stmt->fetch()){
			$invcost = $rcost;
			$invprice = $rprice;
			$invtax = $rtax;
		}
		
		
		$query = "UPDATE `orders` SET `cost` = '$invcost', `retail` = '$invprice', `tax` = '$invtax' WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ?";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $invoice);
			$stmt->execute();
			$stmt->close();
			
			$response = array('1',$invprice,$invtax, number_format($invprice + $invtax, 2));
					echo json_encode($response);
					die();
		
	}
}

if(isset($_POST['invoice']) && isset($_POST['txt']) && !empty($_POST['invoice'])){
			$query = "UPDATE `orders` SET `note` = ? WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ?";
			$stmt = $link->prepare($query);
			$stmt->bind_param('ss', $_POST['txt'], $_POST['invoice']);
			$stmt->execute();
			$stmt->close();
}
?>