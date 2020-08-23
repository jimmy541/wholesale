<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 


		if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['customerid']) && !empty($_POST['customerid']) && isset($_POST['paydate']) && !empty($_POST['paydate'])  && isset($_POST['amount']) && !empty($_POST['amount'])   && isset($_POST['mop']) && !empty($_POST['mop']) && isset($_POST['savingmode']) && !empty($_POST['savingmode'])){ // condition 3
			
			$id = $_POST['id'];
			$customerid = $_POST['customerid'];
			$paydate = $_POST['paydate'];
			$amount = $_POST['amount'];
			$mop = $_POST['mop'];
			$savingmode = $_POST['savingmode'];
			$ref = '';
			if(isset($_POST['refnum']) && !empty($_POST['refnum'])){
				$ref = $_POST['refnum'];
			}
			
			if($savingmode=='new'){
				$stmt = $link->prepare("INSERT INTO `payments`(`payment_id`,`customer_hashed_id`, `clientid`, `invoice_hash`, `pay_date`, `pay_amount`, `payment_method`, `reference_no`) VALUES (UUID(),?,'$clientid',?,?,?,?,?)");
				$stmt->bind_param('ssssss',$customerid, $id, $paydate, $amount, $mop, $ref);
				$stmt->execute();
				$stmt->close();
				
				
				$stmt = $link->prepare("UPDATE `orders` SET `paid_total` = (`paid_total` + $amount) WHERE  `invoice_number_hash` = ? AND `customer_hash` = ? AND `clientid` = '$clientid'");
				$stmt->bind_param("ss", $id, $customerid);
				$stmt->execute();
				$stmt->close();
				
				$stmt = $link->prepare("SELECT `retail` + `tax` - `paid_total` bln FROM `orders` WHERE  `invoice_number_hash` = ? AND `customer_hash` = ? AND `clientid` = '$clientid'");
				$stmt->bind_param("ss", $id, $customerid);
				$stmt->execute();
				$stmt->bind_result($total);
				while($stmt->fetch()){
					$response = array(number_format($total, 2));
					echo json_encode($response);
					die();
				}
			}
			
			if($savingmode=='edit'){
				
				$paymentid = $_POST['paymentid'];
				$oldAmount = '';
				$amountDifference = 0;
				
				
				
				
				$stmt = $link->prepare("SELECT `pay_amount` FROM `payments` WHERE `payment_id` = ?");
				$stmt->bind_param('s',$paymentid);
				$stmt->execute();
				$stmt->bind_result($oa);
				while($stmt->fetch()){
					$oldAmount = $oa;
				}
				$stmt->close();
				$amountDifference = $amount - $oldAmount;
				
				
				$stmt = $link->prepare("UPDATE `payments` SET `pay_date`=?,`pay_amount`=?,`payment_method`=?,`reference_no`=? WHERE `payment_id` = ?");
				$stmt->bind_param('sssss',$paydate,$amount,$mop,$ref,$paymentid);
				$stmt->execute();
				$stmt->close();
				
				
				$stmt = $link->prepare("UPDATE `orders` SET `paid_total` = (`paid_total` + $amountDifference) WHERE  `invoice_number_hash` = ? AND `customer_hash` = ? AND `clientid` = '$clientid'");
				$stmt->bind_param("ss", $id, $customerid);
				$stmt->execute();
				$stmt->close();
				
				$stmt = $link->prepare("SELECT `retail` + `tax` - `paid_total` bln FROM `orders` WHERE  `invoice_number_hash` = ? AND `customer_hash` = ? AND `clientid` = '$clientid'");
				$stmt->bind_param("ss", $id, $customerid);
				$stmt->execute();
				$stmt->bind_result($total);
				while($stmt->fetch()){
					$response = array(number_format($total, 2), number_format($amount, 2), date('m/d/Y', strtotime($paydate)), htmlspecialchars($ref), htmlspecialchars($mop));
					echo json_encode($response);
					die();
				}
			}
			
			
			
		}


?>