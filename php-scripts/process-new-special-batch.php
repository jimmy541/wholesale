<?php
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');

if (isset($_POST['description'])){
	if (!empty($_POST['description'])){
		
			$description = $_POST['description'];
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d');
			
			if(isset($_POST['start_date']) && !empty($_POST['start_date'])){
				$start_date = $_POST['start_date'];
			}
			if(isset($_POST['end_date']) && !empty($_POST['end_date'])){
				$end_date = $_POST['end_date'];
			}
			
			
			$todayDate = date('Y-m-d');
			
			
			
				
				$uid = '';
				$query = 'SELECT UUID() uid';
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_array($result);
				$uid = $row['uid'];
				
				
				$query = "INSERT INTO `special_batch`(`id`, `description`, `start_date`, `end_date`, `clientid`, `created_date`, `created_by`, `is_active`) VALUES ('$uid',?,?,?,?,NOW(),?,'1')";
				if ($stmt = $link->prepare($query)) {
					$stmt->bind_param("sssss", $description,$start_date,$end_date,$clientid,$_SESSION['user']);
					

					$stmt->execute();
					$stmt->close();
				}
				header('location: ../edit-special-batch.php?id='.$uid);
			
		
	}
}
?>