<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 
$okToProceed = "no";
$table = '';
$goTo = '';
$description = '';
$errorCode = '';
//check if table nickname was sent by form
if (isset($_POST['subject']) && !empty($_POST['subject'])){ //condition 1
	$tb = $_POST['subject'];
	//check if table name is valid
	if($tb=='cata' || $tb=='catb' || $tb=='bnds' || $tb=='pkg' || $tb=='catc' || $tb=='wn' || $tb=='tt'){ //condition 2
		
		switch ($tb) {
		case 'cata':
			$table = 'department';
			break;
		case 'catb':
			$table = 'sub_department';
			break;
		case 'bnds':
			$table = 'brands';
			break;
		case 'pkg':
			$table = 'packages';
			break;
		case 'catc':
			$table = 'category';
			break;
		case 'wn':
			$table = 'weight_units';
			break;
		case 'tt':
			$table = 'product_tax_types';
			break;
		}
		
		
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$stmt = $link->prepare("DELETE FROM `$table` WHERE `id` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
		}
		
	}
	if($tb=='cust'){
		
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$stmt = $link->prepare("DELETE FROM `customers` WHERE `hashed_id` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
			$stmt = $link->prepare("DELETE FROM `customer_settings` WHERE `hashed_id` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
			$stmt = $link->prepare("DELETE FROM `customer_contacts` WHERE `customer_hashed_id` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
		}
	}
	
	if($tb=='custContact'){
		
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$stmt = $link->prepare("DELETE FROM `customer_contacts` WHERE `hashed_id` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
		}
	}
	
	
	if($tb=='product'){
		
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$stmt = $link->prepare("DELETE FROM `grocery_products` WHERE `uniqueid` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
		}
	}
	
	if($tb=='supp'){
		
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$stmt = $link->prepare("DELETE FROM `supplier` WHERE `hashed_id` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
		}
	}
	
	if($tb=='users'){
		
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$stmt = $link->prepare("DELETE FROM `users` WHERE `uid` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
		}
	}
	
	if($tb=='inactivecustomer'){
		
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$stmt = $link->prepare("UPDATE `customers` SET `active` = 'no' WHERE `hashed_id` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
		}
	}
	
	if($tb=='invoice'){
		
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$cust = '';
			$stmt = $link->prepare("SELECT `customer_hash`  FROM `orders` WHERE `invoice_number_hash` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->bind_result($cu);
			while($stmt->fetch()){
				$cust = $cu;
			}
			$stmt->close();
			
			
			$stmt = $link->prepare("DELETE FROM `orders` WHERE `invoice_number_hash` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
		
			$stmt = $link->prepare("DELETE FROM `requested_items` WHERE `invoice_number_hash` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
			$found = 'false';
			$stmt = $link->prepare("SELECT `invoice_number`  FROM `orders` WHERE `customer_hash` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $cust);
			$stmt->execute();
			$stmt->bind_result($cu);
			while($stmt->fetch()){
				$found = 'true';
			}
			$stmt->close();
			
			if($found=='false'){
				$query = "UPDATE `customers` SET `has_orders`= 'no' WHERE `hashed_id` = ? AND `clientid` = '$clientid'";
				$stmt = $link->prepare($query);
				$stmt->bind_param('s', $cust);
				$stmt->execute();
				$stmt->close();
			}
			
		}	
		
	}
	if($tb == 'invoice-single-item'){
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$id = '';
			$invoice_hash = '';
			
			$arr = explode('-',$_POST['id'],2);
			$id = $arr[0];
			$invoice = $arr[1];
			
			
			
			$query = "DELETE FROM `requested_items`  WHERE `id` = ? AND `clientid` = '$clientid' AND `invoice_number_hash` = ?";
			$stmt = $link->prepare($query);
			$stmt->bind_param('ss', $id, $invoice);
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
			$stmt->close();
			
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
	
	
	if($tb=='payment'){
		if(isset($_POST['id']) && !empty($_POST['id'])){
			
			$invoiceid = '';
			$amount = '0.00';
			$stmt = $link->prepare("SELECT `invoice_hash`, `pay_amount` FROM `payments` WHERE `payment_id` = ?");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->bind_result($in_ha, $pa_am);
			while($stmt->fetch()){
				$invoiceid = $in_ha;
				$amount = $pa_am;
			}
			$stmt->close();
			
			$stmt = $link->prepare("UPDATE `orders` SET `paid_total` = `paid_total` - $amount WHERE `invoice_number_hash` = ?");
			$stmt->bind_param('s', $invoiceid);
			$stmt->execute();
			$stmt->close();
			
			
			$stmt = $link->prepare("DELETE FROM `payments` WHERE `payment_id` = ?");
			$stmt->bind_param('s', $_POST['id']);
			$stmt->execute();
			$stmt->close();
			
			$stmt = $link->prepare("SELECT `retail` + `tax` - `paid_total` bln FROM `orders` WHERE  `invoice_number_hash` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param("s", $invoiceid);
			$stmt->execute();
			$stmt->bind_result($total);
			while($stmt->fetch()){
				$response = array(number_format($total, 2));
				echo json_encode($response);
				die();
			}
			
		}
	}
	
	
	
}else{ //if condition 1 false
	header('location: ../dashboard.php?cond=2');
}


?>