<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
	
if (isset($_POST['email']) && !empty($_POST['email'])){
	
	$email = trim($_POST['email']);
	$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
	$emailaddress = $email;
	
	if (preg_match($pattern, $emailaddress) === 1) {
		
		$stmt = $link->prepare("SELECT `id` FROM `users` WHERE `email_address` = ?");
			
			$stmt->bind_param('s',$emailaddress);
			$stmt->execute();
			$stmt->bind_result($id);
			$found = 'false';
			while($stmt->fetch()){	
				$found = 'true';
			}
			$stmt->close();
			if($found == 'true'){
				$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
				shuffle($seed);
				$rand = '';
				foreach (array_rand($seed, 20) as $k) 
				$rand .= $seed[$k];
				$token = hash('sha512', $rand);
				$token2 = md5($rand);
				$date = date('Y-m-d');
				
				mysqli_query($link, "UPDATE `password_resets` SET `reseted` = '1' WHERE `email` = '$email'");
				mysqli_query($link, "INSERT INTO `password_resets`(`email`, `token`, `token2`, `date_requested`, `reseted`) VALUES ('$email','$token', '$token2', '$date','0')");
				
				$messagelink = '<a href="https://dalysoft.com/wholesale/replace-lost-password?email='.$email.'&id='.$token2.'&token='.$token.'">Click Here</a>';
				/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
				$mail = new PHPMailer(TRUE);

				/* Open the try/catch block. */
				try {
				   /* Set the mail sender. */
				   $mail->setFrom('registration@dalysoft.com', 'WholeSale');

				   /* Add a recipient. */
				   $mail->addAddress($email, 'Dalysoft');

				   /* Set the subject. */
				   $mail->Subject = "Reset password at Wholesale";
				   
				   /*Enable html */
				   $mail->isHTML(true);

				   /* Set the mail message body. */
				   $mail->Body = '<p>Dear Client,</p><p>Welcome to Wholesale.</p><p>To reset your password please  '.$messagelink.'.</p>
				   <p>If you are unable to reset your password by clicking on the link above, please copy and paste the entire URL below into your web browser:<br>"https://dalysoft.com/wholesale/replace-lost-password?email='.$email.'&id='.$token2.'&token='.$token.'</p>';
					
					// Attachments
					
					
				   /* Finally send the mail. */
				   $mail->send();
				   header("location: ../reset-password.php?status=sent");
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
				
			}
		
		
	}else{
		header("location: ../reset-password.php?status=2");
	}
	
	
	
	

}else{
	//user not signed in
	header("location: ../reset-password.php?status=1");
}


?>