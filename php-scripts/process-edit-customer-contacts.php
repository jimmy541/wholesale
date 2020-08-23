<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

$errorCode = '';
$found = 'false';

if (isset($_POST['account-number']) && !empty($_POST['account-number']) && isset($_POST['token']) && !empty($_POST['token']) && isset($_POST['hid']) && !empty($_POST['hid'])){ //condition 1
	$account = $_POST['account-number'];
	$token = $_POST['token'];
	$hid = $_POST['hid'];
	
	$stmt = $link->prepare("SELECT `account_number` FROM `customers` WHERE `account_number` = ? AND `hashed_id` = ?");
	$stmt->bind_param('ss', $account, $token);
	$stmt->execute();
	while($stmt->fetch()){
		$found = 'true';
	}
	
	if ($found == 'true'){
		if (isset($_POST['type_of_contact']) && !empty($_POST['type_of_contact']) && isset($_POST['full_name']) && !empty($_POST['full_name'])){
			
		
		$type_of_contact = $_POST['type_of_contact'];
		$full_name = $_POST['full_name'];;
		$phone_number = '';
		$ext = '';
		$fax = '';
		$email = '';
		$active = 'no';
			
		if(isset($_POST['active'])){$active = 'yes';}
		if(isset($_POST['phone_number']) && !empty($_POST['phone_number'])){$phone_number = $_POST['phone_number'];}
		if(isset($_POST['ext']) && !empty($_POST['ext'])){$ext = $_POST['ext'];}
		if(isset($_POST['fax']) && !empty($_POST['fax'])){$fax = $_POST['fax'];}
		if(isset($_POST['email']) && !empty($_POST['email'])){$email = $_POST['email'];}
				
		$stmt = $link->prepare('UPDATE `customer_contacts` SET `type_of_contact`=?,`full_name`=?,`phone_number`=?,`ext`=?,`fax`=?,`email`=?,`active`=? WHERE `hashed_id` = ?');
		$stmt->bind_param('ssssssss',$type_of_contact, $full_name, $phone_number, $ext, $fax, $email, $active, $hid);
		$stmt->execute();
		header("location: ../edit-customer-contact.php?success=1&account=$account&token=$token&hid=$hid");
		}else{
			header("location: ../edit-customer-contact.php?error=1&account=$account&token=$token&hid=$hid");
		}
	}else{
		header('location: ../dashboard.php');
		
	}	
	}else{ //if condition 2 false
		header('location: ../dashboard.php');
	}


?>