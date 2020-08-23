<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 

$errorCode = '';
$found = 'false';

//process (account_num_format) setting
if (isset($_POST['anf1token']) && !empty($_POST['anf1token']) && isset($_POST['anf1']) && !empty($_POST['anf1'])){ //condition 1
	$anf1token = $_POST['anf1token'];
	$anf1 = $_POST['anf1'];
	if ($anf1 == '1' || $anf1 == '2' || $anf1 == '3' || $anf1 == '4' || $anf1 == '5'){
		updateSetting($link, $clientid, $anf1token, $anf1);
		header("location: ../edit-settings.php?success=1&partID=1");
	}else{
		header("location: ../edit-settings.php?error=1");
	}
	
	
}
function updateSetting($link, $clientid, $token, $value){
	$stmt = $link->prepare("UPDATE `settings` SET `setting_value` = ? WHERE `clientid` = ? AND `hashed_id` = ?");
	$stmt->bind_param('sss', $value, $clientid, $token);
	$stmt->execute();
	$stmt->close();
}

?>