<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 


	$query = "SELECT b.`description` description, a.`department` id FROM `grocery_products` a left join `department` b on a.`department` = b.`id` AND b.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`department` <> '0' GROUP BY a.`department` ORDER BY b.`description` LIMIT 1";
		$result = mysqli_query($link, $query);
		$cat = "uncat";
		while ($row = mysqli_fetch_array($result)){
			$cat = $row['id'];
			
		}
		echo $cat;
?>