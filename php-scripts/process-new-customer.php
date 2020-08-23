<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

//check if at least item code and desciption is supplied
if (isset($_POST['account_number']) && !empty($_POST['account_number']) && isset($_POST['business_name']) && !empty($_POST['business_name'])){ //condition 1
	$account_number = $_POST['account_number'];
	$business_name = $_POST['business_name'];
	
	
		$rand1 = rand(1, 100000);
		$rand2 = rand(1, 100000);
		$rand3 = rand(1, 2000);
		$token = $rand1.time().$rand2.$rand3.$account_number;
		
		
$hashed_id = hash("sha256", $token);
$website = ''; 
$shipping_address1 = ''; 
$shipping_address2 = ''; 
$shipping_city = ''; 
$shipping_state = ''; 
$shipping_zip_code = ''; 
$shipping_phone_number1 = ''; 
$shipping_phone_number2 = ''; 
$shipping_phone_number1ext = ''; 
$shipping_phone_number2ext = ''; 
$shipping_fax = ''; 
$shipping_email = ''; 
$mailing_address1 = ''; 
$mailing_address2 = ''; 
$mailing_city = ''; 
$mailing_state = ''; 
$mailing_zip_code = ''; 
$mailing_phone_number1 = ''; 
$mailing_phone_number2 = ''; 
$mailing_phone_number1ext = ''; 
$mailing_phone_number2ext = ''; 
$mailing_fax = ''; 
$mailing_email = ''; 
$linked = 'no';
$active = 'yes';
$has_orders = 'no';
if (isset($_POST['website']) && !empty($_POST['website'])){$website = $_POST['website'];}
if (isset($_POST['shipping_address1']) && !empty($_POST['shipping_address1'])){$shipping_address1 = $_POST['shipping_address1'];}
if (isset($_POST['shipping_address2']) && !empty($_POST['shipping_address2'])){$shipping_address2 = $_POST['shipping_address2'];}
if (isset($_POST['shipping_city']) && !empty($_POST['shipping_city'])){$shipping_city = $_POST['shipping_city'];}
if (isset($_POST['shipping_state']) && !empty($_POST['shipping_state'])){$shipping_state = $_POST['shipping_state'];}
if (isset($_POST['shipping_zip_code']) && !empty($_POST['shipping_zip_code'])){$shipping_zip_code = $_POST['shipping_zip_code'];}
if (isset($_POST['shipping_phone_number1']) && !empty($_POST['shipping_phone_number1'])){$shipping_phone_number1 = $_POST['shipping_phone_number1'];}
if (isset($_POST['shipping_phone_number2']) && !empty($_POST['shipping_phone_number2'])){$shipping_phone_number2 = $_POST['shipping_phone_number2'];}
if (isset($_POST['shipping_phone_number1ext']) && !empty($_POST['shipping_phone_number1ext'])){$shipping_phone_number1ext = $_POST['shipping_phone_number1ext'];}
if (isset($_POST['shipping_phone_number2ext']) && !empty($_POST['shipping_phone_number2ext'])){$shipping_phone_number2ext = $_POST['shipping_phone_number2ext'];}
if (isset($_POST['shipping_fax']) && !empty($_POST['shipping_fax'])){$shipping_fax = $_POST['shipping_fax'];}
if (isset($_POST['shipping_email']) && !empty($_POST['shipping_email'])){$shipping_email = $_POST['shipping_email'];}
if (isset($_POST['mailing_address1']) && !empty($_POST['mailing_address1'])){$mailing_address1 = $_POST['mailing_address1'];}
if (isset($_POST['mailing_address2']) && !empty($_POST['mailing_address2'])){$mailing_address2 = $_POST['mailing_address2'];}
if (isset($_POST['mailing_city']) && !empty($_POST['mailing_city'])){$mailing_city = $_POST['mailing_city'];}
if (isset($_POST['mailing_state']) && !empty($_POST['mailing_state'])){$mailing_state = $_POST['mailing_state'];}
if (isset($_POST['mailing_zip_code']) && !empty($_POST['mailing_zip_code'])){$mailing_zip_code = $_POST['mailing_zip_code'];}
if (isset($_POST['mailing_phone_number1']) && !empty($_POST['mailing_phone_number1'])){$mailing_phone_number1 = $_POST['mailing_phone_number1'];}
if (isset($_POST['mailing_phone_number2']) && !empty($_POST['mailing_phone_number2'])){$mailing_phone_number2 = $_POST['mailing_phone_number2'];}
if (isset($_POST['mailing_phone_number1ext']) && !empty($_POST['mailing_phone_number1ext'])){$mailing_phone_number1ext = $_POST['mailing_phone_number1ext'];}
if (isset($_POST['mailing_phone_number2ext']) && !empty($_POST['mailing_phone_number2ext'])){$mailing_phone_number2ext = $_POST['mailing_phone_number2ext'];}
if (isset($_POST['mailing_fax']) && !empty($_POST['mailing_fax'])){$mailing_fax = $_POST['mailing_fax'];}
if (isset($_POST['mailing_email']) && !empty($_POST['mailing_email'])){$mailing_email = $_POST['mailing_email'];}

  
  

	
	
	$stmt = $link->prepare('INSERT INTO `customers`(`account_number`, `hashed_id`, `clientid`, `business_name`, `website`, `shipping_address1`, `shipping_address2`, `shipping_city`, `shipping_state`, `shipping_zip_code`, `shipping_phone_number1`, `shipping_phone_number2`, `shipping_phone_number1ext`, `shipping_phone_number2ext`, `shipping_fax`, `shipping_email`, `mailing_address1`, `mailing_address2`, `mailing_city`, `mailing_state`, `mailing_zip_code`, `mailing_phone_number1`, `mailing_phone_number2`, `mailing_phone_number1ext`, `mailing_phone_number2ext`, `mailing_fax`, `mailing_email`, `linked`, `active`, `has_orders`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
	$stmt->bind_param('ssssssssssssssssssssssssssssss',$account_number, $hashed_id, $clientid, $business_name, $website, $shipping_address1, $shipping_address2, $shipping_city, $shipping_state, $shipping_zip_code, $shipping_phone_number1, $shipping_phone_number2, $shipping_phone_number1ext, $shipping_phone_number2ext, $shipping_fax, $shipping_email, $mailing_address1, $mailing_address2, $mailing_city, $mailing_state, $mailing_zip_code, $mailing_phone_number1, $mailing_phone_number2, $mailing_phone_number1ext, $mailing_phone_number2ext, $mailing_fax, $mailing_email, $linked, $active, $has_orders);
	$stmt->execute();
	
	$stmt = $link->prepare("INSERT INTO `customer_settings`(`account_number`, `view_prices`, `can_place_order`, `can_view_history`, `hashed_id`, `pricing_level`, `clientid`) VALUES (?,'yes','no','yes','$hashed_id','Normal','$clientid')");
	$stmt->bind_param('s',$account_number);
	$stmt->execute();
	
	header('location: ../edit-customer.php?success=1&account='.htmlspecialchars($account_number).'&token='.htmlspecialchars($hashed_id));
			

}else{ //if condition 1 false
	header('location: ../new-customer.php?error=1');
}


?>