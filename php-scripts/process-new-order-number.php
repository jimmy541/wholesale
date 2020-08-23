<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 
		$otype="invoice";
		$odate = date('Y-m-d');
		if(isset($_POST['otype'])){
			if($_POST['otype'] == 'invoice' || $_POST['otype'] == 'quote'){
				$otype = $_POST['otype'];
			}
		}
		if(isset($_POST['odate']) && validateDate($_POST['odate'])){
			$odate = $_POST['odate'];
		}
		function validateDate($date, $format = 'Y-m-d')
		{
			$d = DateTime::createFromFormat($format, $date);
			// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
			return $d && $d->format($format) === $date;
		}
			$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
			shuffle($seed);
			$value1 = '';
			foreach (array_rand($seed, 60) as $k) 
			$value1 .= $seed[$k];
			$order = hash("sha256", time().$value1);
			$terms = '0';
			
			$invoicenumber = 100;
			$stmt = $link->prepare("SELECT MAX(`invoice_number`) FROM `orders` WHERE `clientid` = '$clientid'");
			$stmt->execute();
			$stmt->bind_result($innum);
			while($stmt->fetch()){
				if ($innum > 0){
					$invoicenumber = $innum + 1;
				}
				
			}
			
			$stmt = $link->prepare("SELECT `terms` FROM `customer_settings` WHERE `hashed_id` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('s', $_POST['customer']);
			$stmt->execute();
			$stmt->bind_result($te);
			while($stmt->fetch()){
				
					$terms = $te;
				
				
			}
			
			$query = ("INSERT INTO `orders`(`invoice_number_hash`, `invoice_number`, `customer_hash`, `clientid`, `date_started`, `entered_by`, `status`, `terms`, `order_type`, `date_created`) VALUES ('$order','$invoicenumber',?,'$clientid','$odate','$user', 'Processing', '$terms', '$otype', NOW())");
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $_POST['customer']);
			$stmt->execute();
			$stmt->close();
	
	
			$query = "UPDATE `customers` SET `has_orders`= 'yes' WHERE `hashed_id` = ? AND `clientid` = '$clientid'";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $_POST['customer']);
			$stmt->execute();
			$stmt->close();
			
			echo $order;
		
?>