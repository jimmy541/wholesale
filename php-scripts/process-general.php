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
	if($tb=='cata' || $tb=='catb' || $tb=='bnds' || $tb=='pkg' || $tb=='catc' || $tb=='wn' || $tb=='dp' || $tb=='tt'){ //condition 2
		
		switch ($tb) {
		case 'cata':
			$table = 'acategory';
			$goTo = 'list-products-departments.php';
			break;
		case 'catb':
			$table = 'bcategory';
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
			$table = 'ccategory';
			$goTo = 'list-products-categories.php';
			break;
		case 'wn':
			$table = 'weight_units';
			$goTo = 'list-products-weight-units.php';
			break;
		case 'dp':
			$table = 'department';
			$goTo = 'departments.php';
			break;
		case 'tt':
			$table = 'product_tax_types';
			$goTo = 'list-products-tax-type.php';
			break;
		}
		
		if($table == 'product_tax_types'){
			if(isset($_POST['newDesc']) && !empty($_POST['newDesc']) && isset($_POST['newValue']) && !empty($_POST['newValue'])){ // condition 3
				$stmt = $link->prepare("INSERT INTO `$table` (`description`, `value`, `clientid`) VALUES (?, ?, '$clientid')");
				$stmt->bind_param('ss',$_POST['newDesc'], $_POST['newValue']);
				$stmt->execute();
				header('location: ../'.$goTo.'?as=1');
			}else{ // if condition 3 false
				$errorCode = '1';
				header('location: ../'.$goto.'?error='.$errorCode);
			}
			
			
		}else {
		
			// check if description field not empty
			if(isset($_POST['newDesc']) && !empty($_POST['newDesc'])){ // condition 3
				$stmt = $link->prepare("INSERT INTO `$table` (`description`, `clientid`) VALUES (?, '$clientid')");
				$stmt->bind_param('s',$_POST['newDesc']);
				$stmt->execute();
				header('location: ../'.$goTo.'?as=1');
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