<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

if (isset($_POST['customer']) && !empty($_POST['customer'])){
	
	$emails_arr = array();
	$stmt = $link->prepare("SELECT `full_name`, `email` FROM `customer_contacts` WHERE `clientid` = '$clientid' AND `customer_hashed_id` = ?");
	$stmt->bind_param('s', $_POST['customer']);
	$stmt->execute();
	$stmt->bind_result($fullname, $email);
	while($stmt->fetch()){
		$emails_arr[] = array("fullname" => $fullname, "email" => $email);
	}
	echo json_encode($emails_arr);
}




?>