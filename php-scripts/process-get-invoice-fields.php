<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 
		if(isset($_POST['id']) && !empty($_POST['id'])){ // condition 3
			$id = $_POST['id'];
			
			$stmt = $link->prepare("SELECT `pay_date`, `pay_amount`, `payment_method`, `reference_no` FROM `payments` WHERE `payment_id` = ?");
			
			$stmt->bind_param('s',$id);
			$stmt->execute();
			$stmt->bind_result($pa_da, $pa_am, $pa_me, $re_no);
			
			while($stmt->fetch()){
				$response = array($pa_da, number_format($pa_am, 2), $pa_me, $re_no);
					echo json_encode($response);
					die();
			
			}
			$stmt->close();
			
			
		}
?>