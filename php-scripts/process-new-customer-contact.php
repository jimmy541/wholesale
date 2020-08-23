<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 
$found = 'false';

if (isset($_POST['token']) && !empty($_POST['token']) && isset($_POST['account_number']) && !empty($_POST['account_number']) && isset($_POST['type_of_contact']) && !empty($_POST['type_of_contact']) && isset($_POST['full_name']) && !empty($_POST['full_name'])){ //condition 1
	$type_of_contact = $_POST['type_of_contact'];
	$full_name = $_POST['full_name'];
	$account_number = $_POST['account_number'];
	$token = $_POST['token'];
	
	$stmt = $link->prepare("SELECT `account_number` FROM `customers` WHERE `account_number` = ? AND `hashed_id` = ?");
	$stmt->bind_param('ss', $account_number, $token);
	$stmt->execute();
	while($stmt->fetch()){
		$found = 'true';
	}
	
if ($found == 'true'){	
		$rand1 = rand(1, 100000);
		$rand2 = rand(1, 100000);
		$rand3 = rand(1, 2000);
		$tokenNew = $rand1.time().$rand2.$rand3.$token;
		
		
$hashed_id = hash("sha256", $tokenNew);
$full_name = ''; 
$phone_number = ''; 
$ext = ''; 
$fax = ''; 
$email = ''; 
$active = 'yes';
if (isset($_POST['full_name']) && !empty($_POST['full_name'])){$full_name = $_POST['full_name'];}
if (isset($_POST['phone_number']) && !empty($_POST['phone_number'])){$phone_number = $_POST['phone_number'];}
if (isset($_POST['ext']) && !empty($_POST['ext'])){$ext = $_POST['ext'];}
if (isset($_POST['fax']) && !empty($_POST['fax'])){$fax = $_POST['fax'];}
if (isset($_POST['email']) && !empty($_POST['email'])){$email = $_POST['email'];}
	
	$stmt = $link->prepare('INSERT INTO `customer_contacts`(`account_number`, `customer_hashed_id`, `hashed_id`, `clientid`, `type_of_contact`, `full_name`, `phone_number`, `ext`, `fax`, `email`, `active`) VALUES (?, ?,?,?,?,?,?,?,?,?,?)');
	$stmt->bind_param('sssssssssss',$account_number, $token , $hashed_id, $clientid, $type_of_contact, $full_name, $phone_number, $ext, $fax, $email, $active);
	$stmt->execute();
	
	header("location: ../new-customer-contact.php?success=1&account=$account_number&token=$token");
}else{
	
}			

}else{ //if condition 1 false
	header('location: ../new-customer-contact.php?error=1');
}


?>