<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 
$okToProceed = "no";
$table = '';
$goTo = '';
$description = '';
$errorCode = '';
//check if table nickname was sent by form
if (isset($_POST['subject']) && !empty($_POST['subject'])){ //condition 1
	$tb = $_POST['subject'];
	//check if table name is valid
	if($tb=='cata' || $tb=='catb' || $tb=='bnds' || $tb=='pkg' || $tb=='catc' || $tb=='wn' || $tb=='tt'){ //condition 2
		
		switch ($tb) {
		case 'cata':
			$table = 'department';
			$goTo = 'list-products-departments.php';
			break;
		case 'catb':
			$table = 'sub_department';
			$goTo = 'list-products-sub-departments.php';
			break;
		case 'bnds':
			$table = 'brands';
			$goTo = 'list-products-brands.php';
			break;
		case 'pkg':
			$table = 'packages';
			$goTo = 'list-products-packages.php';
			break;
		case 'catc':
			$table = 'category';
			$goTo = 'list-products-categories.php';
			break;
		case 'wn':
			$table = 'weight_units';
			$goTo = 'list-products-weight-units.php';
			break;
		case 'tt':
			$table = 'product_tax_types';
			$goTo = 'list-products-tax-type.php';
			break;
		}
		
		if($table == 'product_tax_types'){
		if(isset($_POST['newDesc']) && !empty($_POST['newDesc']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['newV']) && !empty($_POST['newV'])){ // condition 3
			$stmt = $link->prepare("UPDATE `$table` SET `description` = ?, `value` = ? WHERE `id` = ? AND `clientid` = '$clientid'");
			$stmt->bind_param('sss',$_POST['newDesc'], $_POST['newV'], $_POST['id']);
			$stmt->execute();
			//header('location: ../'.$goTo.'?es=1');
			
			$stmt = $link->prepare("SELECT `id`, `description`, `value` FROM `$table` WHERE `clientid` = '$clientid' AND `description` = ?");
			$stmt->bind_param("s", $_POST['newDesc']);
			$stmt->execute();
			$stmt->bind_result($id, $desc, $txValue);
			while($stmt->fetch()){
				$response = array($id,htmlspecialchars($desc), $txValue);
				echo json_encode($response);
				die();
			}
			
		}else{ // if condition 3 false
			$errorCode = '1';
			header('location: ../'.$goto.'?error='.$errorCode);
		}
		
		}else{
		
			// check if description field not empty
			if(isset($_POST['newDesc']) && !empty($_POST['newDesc']) && isset($_POST['id']) && !empty($_POST['id'])){ // condition 3
				$stmt = $link->prepare("UPDATE `$table` SET `description` = ? WHERE `id` = ? AND `clientid` = '$clientid'");
				$stmt->bind_param('ss',$_POST['newDesc'], $_POST['id']);
				$stmt->execute();
				//header('location: ../'.$goTo.'?es=1');
				
				$stmt = $link->prepare("SELECT `id`, `description` FROM `$table` WHERE `clientid` = '$clientid' AND `description` = ?");
				$stmt->bind_param("s", $_POST['newDesc']);
				$stmt->execute();
				$stmt->bind_result($id, $desc);
				while($stmt->fetch()){
					$response = array($id,htmlspecialchars($desc));
					echo json_encode($response);
					die();
				}
				
			}else{ // if condition 3 false
				$errorCode = '1';
				header('location: ../'.$goto.'?error='.$errorCode);
			}
		}
		}else{ //if condition 2 false
			header('location: ../dashboard.php');
		}
	
}else{ //if condition 1 false
	header('location: ../dashboard.php');
}


?>