<?php
require_once($_SERVER['DOCUMENT_ROOT']."/wholesale/include/connect.php");
$query = "DELETE FROM `logged-in-users` WHERE `user` = ?";
		if ($stmt = $link->prepare($query)) {
			$stmt->bind_param("s", $_SESSION['user']);
			$stmt->execute();
			$stmt->close();
		}

unset($_SESSION['user']);
$clientid = '';
setcookie("userid", "", time() - 3600);
setcookie("tokenid", "", time() - 3600);
header('location: ../login.php');
?>