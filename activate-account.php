<?php 
if (isset($_GET['token']) && !empty($_GET['token'])){
	require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
	$query = "SELECT `id` FROM `users` WHERE `activation-code` = ?";
		if ($stmt = $link->prepare($query)) {
			
			$stmt->bind_param("s", $_GET['token']);
			
			$stmt->execute();
			
			$stmt->bind_result($saltV);
			$found = 'false';
			while ($stmt->fetch()) {
				$found = 'true';
			}
			$stmt->close();
			if($found == 'true'){
				$query = "UPDATE `users` SET `email_verified` = '1' WHERE `activation-code` = ?";
					if ($stmt = $link->prepare($query)) {
						$stmt->bind_param("s", $_GET['token']);
						
						$stmt->execute();
						$stmt->close();
					}
					header("location: profile.php?accountactivated=success");
				
			}else{
				//if token does not exist
				header("location: profile.php");
			}
			
		}
	
	
	
	
}else{
	
	//if token not provided
header("location: profile.php");

}
?>