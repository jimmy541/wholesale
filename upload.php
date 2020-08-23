<?php
require("include/connect.php");
$target_dir = "uploads/profile-image/";
$temp = explode(".",$_FILES["fileToUpload"]["name"]);
$userHashed = md5($user.rand(1,99999));
$newfilename =  $userHashed. '.' .end($temp);

//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $newfilename;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$imageFileType = strtolower($imageFileType);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        header("location: profile.php?uploaderror=1");
        exit();
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    header("location: profile.php?uploaderror=2");
    exit();
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    header("location: profile.php?uploaderror=1");
    exit();
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
     	header("location: profile.php?uploaderror=1");
    	exit();
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    	mysqli_query($link, "UPDATE `users` SET `profile-picture` = '$newfilename' WHERE `email_address` = '$user'");
       header("location: profile.php?success=1");
    	exit();
        
    } else {
        header("location: profile.php?uploaderror=3");
    	exit();

    }
}
?>