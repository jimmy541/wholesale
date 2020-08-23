<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 


	$query = "SELECT b.`description` description, a.`a_category` id FROM `grocery_products` a left join `acategory` b on a.`a_category` = b.`id` AND b.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`a_category` <> '0' GROUP BY a.`a_category` ORDER BY b.`description` LIMIT 1";
		$result = mysqli_query($link, $query);
		$cat = "uncat";
		while ($row = mysqli_fetch_array($result)){
			$cat = $row['id'];
			
		}
		echo $cat;
?>