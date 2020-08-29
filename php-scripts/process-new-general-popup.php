<?php header("Content-type: application/json"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 
$table = '';

if (isset($_POST['reid']) && !empty($_POST['reid']) && isset($_POST['revl']) && !empty($_POST['revl'])){ //condition 1
	$reid = $_POST['reid'];
	$revl = $_POST['revl'];
	
	
	$accnu = '';
	$phnu = '';
	if (isset($_POST['accnu']) && !empty($_POST['accnu'])){
		$accnu = $_POST['accnu'];
	}
	if (isset($_POST['phnu']) && !empty($_POST['phnu'])){
		$phnu = $_POST['phnu'];
	}
	
	//check if table name is valid
	if($reid=='adae3bad1bca266a568ecbc72e698c9' || $reid=='adae3bad1bca266a568ecbc82e698c5' || $reid=='f146aa9099b551a29e4d4ae56e170c7' || $reid=='trae3bad1bca266a568ecbc82e698c8' || $reid=='trae3bad2dca266a568ecbc82e698c8'){ //condition 2
		
		switch ($reid) {
		case 'adae3bad1bca266a568ecbc72e698c9':
			$table = 'department';
			
			break;
		case 'adae3bad1bca266a568ecbc82e698c5':
			$table = 'sub_department';
		
			break;
		case 'f146aa9099b551a29e4d4ae56e170c7':
			$table = 'brands';
			
			break;
		case 'trae3bad1bca266a568ecbc82e698c8':
			$table = 'category';
		
			break;
		case 'trae3bad2dca266a568ecbc82e698c8':
			$table = 'supplier';
			
			break;
		}
		
			if($table != 'supplier'){
			$stmt = $link->prepare("INSERT INTO `$table` (`description`, `clientid`) VALUES (?, '$clientid')");
			$stmt->bind_param('s',$revl);
			$stmt->execute();
			$stmt->close();
			
			$stmt = $link->prepare("SELECT `id`, `description` FROM `$table` WHERE `clientid` = '$clientid' AND `description` = ?");
			$stmt->bind_param("s", $revl);
			$stmt->execute();
			$stmt->bind_result($id, $desc);
			while($stmt->fetch()){
				$response = array($id,htmlspecialchars($desc));
				echo json_encode($response);
				die();
			}
			}else{
				
			$rand1 = rand(1, 100000);
			$rand2 = rand(1, 100000);
			$rand3 = rand(1, 2000);
			$token = $rand1.time().$rand2.$rand3.$revl;
			$hashed_id = hash("sha256", $token);
			
			$stmt = $link->prepare("INSERT INTO `supplier`(`hashed_id`, `name`, `account_number`, `phone_number`, `clientid`, `active`) VALUES ('$hashed_id',?,?,?,'$clientid','yes')");
			$stmt->bind_param('sss',$revl, $accnu, $phnu);
			$stmt->execute();
			$stmt->close();
			
			$stmt = $link->prepare("SELECT `id`, `name`, `account_number`, `phone_number` FROM `$table` WHERE `clientid` = '$clientid' AND `name` = ?");
			$stmt->bind_param("s", $revl);
			$stmt->execute();
			$stmt->bind_result($id, $desc, $an, $pn);
			while($stmt->fetch()){
				$response = array($id,htmlspecialchars($desc),htmlspecialchars($an),htmlspecialchars($pn));
				echo json_encode($response);
				die();
			}
			}
	}else{ //if condition 2 false
		header('location: ../dashboard.php?code=1');
	}
	
}else{ //if condition 1 false
	header('location: ../dashboard.php?code=2');
}


?>