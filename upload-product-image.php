<?php
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
$target_dir = "pics/";
$temp = explode(".",$_FILES["fileToUpload"]["name"]);
$userHashed = md5($user.rand(1,99999));
$newfilename =  $userHashed. '.' .end($temp);
$productid = '';
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $newfilename;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$imageFileType = strtolower($imageFileType);
// Check if image file is a actual image or fake image
if(isset($_POST['image-id']) && !empty($_POST['image-id'])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	$productid = $_POST['image-id'];
	if($check !== false) {
        $uploadOk = 1;
    } else {
        header("location: edit-product.php?product=".htmlspecialchars($productid)."&uploaderror=1");
        exit();
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    header("location: edit-product.php?product=".htmlspecialchars($productid)."&uploaderror=2");
    exit();
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    header("location: edit-product.php?product=".htmlspecialchars($productid)."&uploaderror=1");
    exit();
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
     	header("location: edit-product.php?product=".htmlspecialchars($productid)."&uploaderror=1");
    	exit();
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$oldimage = '';
		$query = "SELECT `image-id` FROM `grocery_products` WHERE `uniqueid` = ?";
		$stmt=$link->prepare($query);
		$stmt->bind_param('s', $productid);
		$stmt->execute();
		$stmt->bind_result($oi);
		while($stmt->fetch()){
			$oldimage = $oi;
		}
		$stmt->close;
		
		if(!empty($oldimage)){
			unlink($target_dir.$oldimage);
		}
		
		$query = "UPDATE `grocery_products` SET `image-id` = '$newfilename' WHERE `uniqueid` = ?";
		$stmt=$link->prepare($query);
		$stmt->bind_param('s', $productid);
		$stmt->execute();
		$stmt->close;
    	
       header("location: edit-product.php?product=".htmlspecialchars($productid)."&imgsuccess=1");
    	exit();
        
    } else {
        header("location: edit-product.php?product=".htmlspecialchars($productid)."&uploaderror=3");
    	exit();

    }
}
?>