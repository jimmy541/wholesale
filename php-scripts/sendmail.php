<?php

/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* If you installed PHPMailer without Composer do this instead: */

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
$subject = 'Invoice';
$msgbody = '';
if(isset($_POST['msgbody']) && !empty($_POST['msgbody'])){
	$msgbody = htmlspecialchars($_POST['msgbody']);
}
$doctype = 'invoice';
if(isset($_POST['doctype']) && !empty($_POST['doctype'])){
	if($_POST['doctype'] == 'invoice'){
		$doctype = 'invoice';
	}elseif($_POST['doctype'] == 'statement'){
		$doctype = 'statement';
	}elseif($_POST['doctype'] == 'ahistory'){
		$doctype = 'ahistory';
	}
}

if($doctype == 'invoice'){
	if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['invoice']) && !empty($_POST['invoice'])){
		$email = $_POST['email'];
		$invoice = $_POST['invoice'];
		$invoiceexist = 'false';
		$invoicenumber = '';
		 
		$stmt = $link->prepare("SELECT `invoice_number` FROM `orders` WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ?");
		$stmt->bind_param('s', $invoice);
		$stmt->execute();
		$stmt->bind_result($innum);
		while($stmt->fetch()){
			$invoiceexist = 'true';
			$invoicenumber = $innum;
			
		}
		if(!empty($_POST['msgsubject'])){
			$subject = htmlspecialchars($_POST['msgsubject']);
		}else{
			$subject = 'Invoice#: '.$invoicenumber;
		}
		if(empty($msgbody)){
			$msgbody = $subject;
		}
	}
}
elseif($doctype == 'statement' || $doctype == 'ahistory'){
	if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['invoice']) && !empty($_POST['invoice'])){
		$email = $_POST['email'];
		$customerid = $_POST['invoice'];
		$invoiceexist = 'false';
		
		 
		$stmt = $link->prepare("SELECT `account_number` FROM `customers` WHERE `clientid` = '$clientid' AND `hashed_id` = ?");
		$stmt->bind_param('s', $customerid);
		$stmt->execute();
		$stmt->bind_result($innum);
		while($stmt->fetch()){
			$invoiceexist = 'true';
		}
		if(!empty($_POST['msgsubject'])){
			$subject = htmlspecialchars($_POST['msgsubject']);
		}else{
			if($doctype == 'statement'){
				$subject = 'Statement';
			}elseif($doctype == 'ahistory'){
				$subject = 'Account history';
			}
		}
		if(empty($msgbody)){
			$msgbody = $subject;
		}
	}
}
if($invoiceexist == 'true'){
	/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
	$mail = new PHPMailer(TRUE);

	/* Open the try/catch block. */
	try {
	   /* Set the mail sender. */
	   $mail->setFrom('darth@empire.com', 'WholeSale');

	   /* Add a recipient. */
	   $mail->addAddress($email, 'Jimmy Daly');

	   /* Set the subject. */
	   $mail->Subject = $subject;

	   /* Set the mail message body. */
	   $mail->Body = $msgbody;
		
		// Attachments
		if($doctype == 'invoice'){
			$mail->addAttachment('../temp_pdf_invoices/'.$invoice.'.pdf', $invoicenumber.'.pdf');
		}elseif($doctype == 'statement'){
			$mail->addAttachment('../temp_pdf_invoices/'.$customerid.'.pdf', 'statement.pdf');
		}elseif($doctype == 'ahistory'){
			$mail->addAttachment('../temp_pdf_invoices/history'.$customerid.'.pdf', 'account history.pdf');
		}
		
	   /* Finally send the mail. */
	   $mail->send();
	   
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
?>