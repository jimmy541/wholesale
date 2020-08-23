<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

$errorCode = '';

if (isset($_POST['token']) && !empty($_POST['token'])){ //condition 1
	$token = $_POST['token'];
		
		
		if(isset($_POST['name']) && !empty($_POST['name'])){ // condition 3
		
		
			$name = $_POST['name'];
			$account_number = '';		
			$address1 = ''; 
			$address2 = ''; 
			$city = ''; 
			$state = ''; 
			$zipcode = ''; 
			$phone_number = ''; 
			$ext = ''; 
			$fax = ''; 
			$email = ''; 
			$website = '';  
			$active = 'no';
			if (isset($_POST['active'])){$active = 'yes';}
			if (isset($_POST['account_number']) && !empty($_POST['account_number'])){$account_number = $_POST['account_number'];}
			if (isset($_POST['address1']) && !empty($_POST['address1'])){$address1 = $_POST['address1'];}
			if (isset($_POST['address2']) && !empty($_POST['address2'])){$address2 = $_POST['address2'];}
			if (isset($_POST['city']) && !empty($_POST['city'])){$city = $_POST['city'];}
			if (isset($_POST['state']) && !empty($_POST['state'])){$state = $_POST['state'];}
			if (isset($_POST['zipcode']) && !empty($_POST['zipcode'])){$zipcode = $_POST['zipcode'];}
			if (isset($_POST['phone_number']) && !empty($_POST['phone_number'])){$phone_number = $_POST['phone_number'];}
			if (isset($_POST['ext']) && !empty($_POST['ext'])){$ext = $_POST['ext'];}
			if (isset($_POST['fax']) && !empty($_POST['fax'])){$fax = $_POST['fax'];}
			if (isset($_POST['email']) && !empty($_POST['email'])){$email = $_POST['email'];}
			if (isset($_POST['website']) && !empty($_POST['website'])){$website = $_POST['website'];}
			
			$stmt = $link->prepare('UPDATE `supplier` SET `account_number`=?,`name`=?,`address1`=?,`address2`=?,`city`=?,`state`=?,`zipcode`=?,`phone_number`=?,`ext`=?,`fax`=?,`email`=?,`website`=?,`active`=? WHERE `hashed_id`=? AND `clientid`=?');
			$stmt->bind_param('sssssssssssssss',$account_number,$name,$address1,$address2,$city,$state,$zipcode,$phone_number,$ext,$fax,$email,$website,$active,$token,$clientid);
			$stmt->execute();
			header("location: ../edit-supplier.php?success=1&token=$token");
		}else{ // if condition 3 false
			$errorCode = '1';
			header('location: ../edit-supplier.php?error='.$errorCode);
		}
		
	}else{ //if condition 2 false
		header('location: ../dashboard.php');
	}


?>