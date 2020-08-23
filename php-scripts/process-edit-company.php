<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

$errorCode = '';


		
		
		if(isset($_POST['company_name']) && !empty($_POST['company_name'])){ // condition 3
		
		
			$company_name = $_POST['company_name'];
			 
			$address1 = ''; 
			$address2 = ''; 
			$city = ''; 
			$state = ''; 
			$zip_code = ''; 
			$phone_number1 = ''; 
			$phone_number2 = ''; 
			$fax = ''; 
			$email = ''; 
			$website = '';
			
			
			
			if (isset($_POST['address1']) && !empty($_POST['address1'])){$address1 = $_POST['address1'];}
			if (isset($_POST['address2']) && !empty($_POST['address2'])){$address2 = $_POST['address2'];}
			if (isset($_POST['city']) && !empty($_POST['city'])){$city = $_POST['city'];}
			if (isset($_POST['state']) && !empty($_POST['state'])){$state = $_POST['state'];}
			if (isset($_POST['zip_code']) && !empty($_POST['zip_code'])){$zip_code = $_POST['zip_code'];}
			if (isset($_POST['phone_number1']) && !empty($_POST['phone_number1'])){$phone_number1 = $_POST['phone_number1'];}
			if (isset($_POST['phone_number2']) && !empty($_POST['phone_number2'])){$phone_number2 = $_POST['phone_number2'];}
			if (isset($_POST['fax']) && !empty($_POST['fax'])){$fax = $_POST['fax'];}
			if (isset($_POST['email']) && !empty($_POST['email'])){$email = $_POST['email'];}
			if (isset($_POST['website']) && !empty($_POST['website'])){$website = $_POST['website'];}
			
			$stmt = $link->prepare('UPDATE `clients` SET `company_name`=?,`address1`=?,`address2`=?,`city`=?,`state`=?,`zip_code`=?,`phone1`=?,`phone2`=?,`fax`=?,`email`=?,`website`=? WHERE `clientid`= ?');
			$stmt->bind_param('ssssssssssss',$company_name,$address1,$address2,$city,$state,$zip_code,$phone_number1,$phone_number2,$fax,$email,$website,$clientid);
			$stmt->execute();
			header("location: ../edit-company.php?success=1");
		}else{ // if condition 3 false
			$errorCode = '1';
			header('location: ../edit-company.php?error='.$errorCode);
		}
		
	


?>