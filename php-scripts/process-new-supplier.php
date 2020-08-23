<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

//check if at least item code and desciption is supplied
if (isset($_POST['name']) && !empty($_POST['name'])){ //condition 1
	
$name = $_POST['name'];

		$rand1 = rand(1, 100000);
		$rand2 = rand(1, 100000);
		$rand3 = rand(1, 2000);
		$token = $rand1.time().$rand2.$rand3.$name;
		
$hashed_id = hash("sha256", $token);
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
$active = 'yes';

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


  
  

	
	
	$stmt = $link->prepare('INSERT INTO `supplier`(`hashed_id`, `account_number`, `name`, `address1`, `address2`, `city`, `state`, `zipcode`, `phone_number`, `ext`, `fax`, `email`, `website`, `clientid`, `active`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
	$stmt->bind_param('sssssssssssssss',$hashed_id, $account_number, $name, $address1, $address2, $city, $state, $zipcode, $phone_number, $ext, $fax, $email, $website, $clientid, $active);
	$stmt->execute();
	
	
	header('location: ../edit-supplier.php?success=1&token='.htmlspecialchars($hashed_id));
			

}else{ //if condition 1 false
	header('location: ../new-supplier.php?error=1');
}


?>