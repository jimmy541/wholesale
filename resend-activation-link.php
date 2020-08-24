<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
	$query = "SELECT `id` FROM `users` WHERE `activation-code` = ?";
if (isset($_SESSION['user'])){
	$result = mysqli_query($link, "SELECT `activation-code` FROM `users` WHERE `email_address` = '$user' AND `clientid` = '$clientid'");
	
	$activationcode = '';
	
	while($row=mysqli_fetch_array($result)){
		$activationcode = $row['activation-code'];
	}
	
	/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
				$mail = new PHPMailer(TRUE);

				/* Open the try/catch block. */
				try {
				   /* Set the mail sender. */
				   $mail->setFrom('registration@dalysoft.com', 'WholeSale');

				   /* Add a recipient. */
				   $mail->addAddress($email, 'Dalysoft');

				   /* Set the subject. */
				   $mail->Subject = "Account Acivation";
				   
				   /*Enable html */
				   $mail->isHTML(true);

				   /* Set the mail message body. */
				   $mail->Body = '<p>Dear '.$firstName.',</p><p>Welcome to Wholesale.</p><p>To activate the account please <a href="https://dalysoft.com/wholesale/activate-account.php?token='.$activationCode.'">click here</a>.</p>
				   <p>Thanks for joining Wholesale. We know you will enjoy the power and simplicity of Wholesale. </p><p>Sincerely,<br>Wholesale Customer Service</p>
				   <p>If you are unable to activate your account by clicking on the link above, please copy and paste the entire URL below into your web browser:<br> https://dalysoft.com/wholesale/activate-account.php?token='.$activationCode.'</p>';
					
					// Attachments
					
					
				   /* Finally send the mail. */
				   $mail->send();
				   header("location: profile.php?activationlink=sent");
				}
				catch (Exception $e)
				{
				   /* PHPMailer exception. */
				   echo $e->errorMessage();
				}
				catch (\Exception $e)
				{
				   /* PHP exception (note the backslash to select the global namespace Exception class). */
				   echo $e->getMessage();
				}

}else{
	//user not signed in
	header("location: login.php");
}


?>