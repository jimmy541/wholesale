<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

$errorCode = '';
$found = 'false';

if (isset($_POST['batch_id']) && !empty($_POST['batch_id']) && isset($_POST['description']) && !empty($_POST['description'])){ //condition 1
	$batch_id = $_POST['batch_id'];
	$description = $_POST['description'];
	$start_date = date('Y-m-d');
	$end_date = date('Y-m-d');
	$is_active = '0';
	if(isset($_POST['is_active'])){$is_active = '1';}
	if(isset($_POST['start_date']) && !empty($_POST['start_date'])){$start_date = $_POST['start_date'];}
	if(isset($_POST['end_date']) && !empty($_POST['end_date'])){$end_date = $_POST['end_date'];}
	$stmt = $link->prepare('UPDATE `special_batch` SET `description`=?,`start_date`=?,`end_date`=?,`is_active`=? WHERE `id` = ?');
		$stmt->bind_param('sssss',$description, $start_date, $end_date, $is_active, $batch_id);
		$stmt->execute();
		header("location: ../edit-special-batch.php?success=1&id=".htmlspecialchars($batch_id));
		}else{
			header("location: ../edit-special-batch.php?error=1&id=".htmlspecialchars($batch_id));
		}
		
	

?>