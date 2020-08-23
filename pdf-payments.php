<?php
require('php-scripts/fpdf.php');
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
if(isset($_GET['customer'])){
	
		$hashed_customer_number = $_GET['customer'];
}
$number_of_pages = 1;
$innumber = '0';		
class PDF extends FPDF
{
// Page header
function Header()
{
	global $innumber;
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');

if(isset($_GET['customer'])){
	
		$hashed_customer_number = $_GET['customer'];
		
		

		$business_name = '';
		$business_street_address_line1 = '';
		$business_street_address_line2 = '';
		$business_phone = '';
		$business_fax = '';
		
		$customer_acc_number = '';
		$billto_customer = '';
		
		$billto_address_line1 = '';
		$billto_address_line2 = '';
		$billto_phone = '';
		$billto_fax = '';
		
		$shipto_address_line1 = '';
		$shipto_address_line2 = '';
		$shipto_phone = '';
		$shipto_fax = '';
		
		$query = "SELECT `company_name`, `address1`, `address2`, `city`, `state`, `zip_code`, `phone1`, `fax` FROM `clients` WHERE `clientid` = '$clientid'";
		$stmt = $link->prepare($query);
		$stmt->execute();
		$stmt->bind_result($rslt1, $rslt2, $rslt3, $rslt4, $rslt5, $rslt6, $rslt7, $rslt8);
		while($stmt->fetch()){
			$business_name = $rslt1;
			$business_street_address_line1 = htmlspecialchars($rslt2).' '.htmlspecialchars($rslt3);
			$business_street_address_line2 = htmlspecialchars($rslt4).' '.htmlspecialchars($rslt5).' '.htmlspecialchars($rslt6);
			$business_phone = htmlspecialchars($rslt7);
			$business_fax = htmlspecialchars($rslt8);
		}
		$stmt->close();
		$account_number = '';
		$query = "SELECT `account_number` FROM `customers` WHERE `clientid` = '$clientid' AND `hashed_id` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $hashed_customer_number);
		$stmt->execute();
		$stmt->bind_result($rslt1);
		while($stmt->fetch()){
			$account_number = htmlspecialchars($rslt1);
			
		}
		$stmt->close();
		
		$query = "SELECT `account_number`, `business_name`, `shipping_address1`, `shipping_address2`, `shipping_city`, `shipping_state`, `shipping_zip_code`, `shipping_phone_number1`, `shipping_phone_number1ext`, `shipping_fax`, `mailing_address1`, `mailing_address2`, `mailing_city`, `mailing_state`, `mailing_zip_code`, `mailing_phone_number1`, `mailing_phone_number1ext`, `mailing_fax` FROM `customers` WHERE `clientid` = '$clientid' AND `hashed_id` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $hashed_customer_number);
		$stmt->execute();
		$stmt->bind_result($ac_nu, $bu_na, $sh_ad1, $sh_ad2, $sh_ci, $sh_st, $sh_zi, $sh_ph, $sh_ex, $sh_fa, $ma_ad1, $ma_ad2, $ma_ci, $ma_st, $ma_zi, $ma_ph, $ma_ex, $ma_fa);
		while($stmt->fetch()){
			$customer_acc_number = htmlspecialchars($ac_nu);
			$billto_customer = htmlspecialchars($bu_na);
			
			$billto_address_line1 = htmlspecialchars($sh_ad1).' '.htmlspecialchars($sh_ad2);
			$billto_address_line2 = htmlspecialchars($sh_ci). ' '.htmlspecialchars($sh_st).' '.htmlspecialchars($sh_zi);
			$billto_phone = htmlspecialchars($sh_ph).' '.htmlspecialchars($sh_ex);
			$billto_fax = htmlspecialchars($sh_fa);
			
			$shipto_address_line1 = htmlspecialchars($ma_ad1).' '.htmlspecialchars($ma_ad2);
			$shipto_address_line2 = htmlspecialchars($ma_ci). ' '.htmlspecialchars($ma_st).' '.htmlspecialchars($ma_zi);
			$shipto_phone = htmlspecialchars($ma_ph).' '.htmlspecialchars($ma_ex);
			$shipto_fax = htmlspecialchars($ma_fa);
		}
		$stmt->close();
		
		
		
}else{
	die("Sorry, this page doesn't exist");

}
    //Company Name
    $this->SetFont('Arial','B',15);
    $this->Cell(0.01);
    $this->Cell(50,5,$business_name,0,0,'L');
	
	//Today Date
	$this->SetFont('Arial','',12);
    $this->Cell(75);
    $this->Cell(35,6,'Date',1,0,'L');
	$this->Cell(30,6,date('m/d/Y'),1,0,'R');
	
	$this->Ln(6);
	
	//Company Address Line 1
    $this->SetFont('Arial','',12);
	$this->Cell(0.01);
    $this->Cell(50,5,$business_street_address_line1,0,0,'L');
	
	//Today Date
    $this->Cell(75);
    $this->Cell(35,6,'Customer No.',1,0,'L');
	$this->Cell(30,6,$account_number,1,0,'R');
	
	$this->Ln(6);
	
	//Company Address Line 2
	$this->Cell(0.01);
    $this->Cell(50,5,$business_street_address_line2,0,0,'L');
	
	
	$this->Ln(6);
	
	//Company phone number
	$this->Cell(0.01);
    $this->Cell(50,5,$business_phone,0,0,'L');
	
	$this->Ln(6);
	
	
	//Company fax number
	$this->Cell(0.01);
    $this->Cell(50,5,$business_fax,0,1,'L');
	
	$this->Ln(9);
	
	//Bill to header
    $this->Cell(90,5,'Customer:',0,0,'L');
	
	
	
	
	
	$this->Ln(8);
	
	//Bill and ship to customer
	$this->SetFont('Arial','B',10);
	$this->Cell(90,5,$billto_customer,0,0,'L');
	
	$this->Ln(5);
	
	//Bill and ship to customer address line 1
	
	$this->SetFont('Arial','',10);
	$this->Cell(90,5,$billto_address_line1,0,0,'L');
	
	
	$this->Ln(5);
	
	//Bill and ship to customer address line 2
	$this->Cell(90,5,$billto_address_line2,0,0,'L');
	
	
	$this->Ln(5);
	
	//Bill and ship to customer phone number
	$this->Cell(90,5,$billto_phone,0,0,'L');
	
	
	$this->Ln(5);
	
	//Bill and ship to customer fax number
	$this->Cell(90,5,$billto_fax,0,0,'L');
	
	
	$this->Ln(5);
	
	
	//Header
	$this->SetFont('Arial','B',16);
	$this->Cell(75);
    $this->Cell(90,5,'Payment History',0,0,'L');
	
	
	$this->Ln(15);
	
}

// Page footer
function Footer()
{
	$this->Ln(5);
	global $number_of_pages;
	
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}	
	



// Colored table
function FancyTable($link, $clientid, $hashed_customer_number, $pageNumber)
{
	// Colors, line width and bold font
	$this->SetFillColor(255);
	$this->SetTextColor(0);
	$this->SetDrawColor(0);
	$this->SetLineWidth(.1);
	$this->SetFont('','B','10');
	// Header width must be 190
	$w = array(25, 65, 25, 25, 25, 25);
	$header = array('Date', 'Business', 'Amount', 'Method', 'Ref No.', 'Invoice No.');
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	// Color and font restoration
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	// Data
	
	$limit_clause = 'LIMIT '.(($pageNumber - 1) * 20).',20';
	
	if(!empty($_GET['customer'])){
		$customer_hashid = $_GET['customer'];
		$customer_detail_query = '';
		//make sure provided customer exists in database and get sanitized result
		
		$query = "SELECT `customer_hash` FROM `orders` WHERE `clientid` = '$clientid' AND `customer_hash` = ? LIMIT 1";
		
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $customer_hashid);
		$stmt->execute();
		$stmt->bind_result($cuh);
		while ($stmt->fetch()) {
			$customer_detail_query = " AND a.`customer_hashed_id` = '$cuh' ";
		}
	}
	$datefrom = date('Y-m-d', strtotime('-90 days'));
	$dateto = date('Y-m-d');
	if(isset($_GET['dfrom']) && validateDate($_GET['dfrom']) && isset($_GET['dto']) && validateDate($_GET['dto'])){
		$datefrom = $_GET['dfrom'];
		$dateto = $_GET['dto'];
    }
	
	
	$query = "SELECT a.`pay_date`, c.`business_name`, a.`pay_amount`, a.`payment_method`, a.`reference_no`, b.`invoice_number` FROM `payments` a LEFT JOIN `orders` b ON a.`invoice_hash` = b.`invoice_number_hash` AND b.`clientid` = '$clientid' LEFT JOIN `customers` c on a.`customer_hashed_id` = c.`hashed_id` AND c.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`pay_date` >= ? AND a.`pay_date` <= ? $customer_detail_query ORDER BY a.`pay_date` DESC $limit_clause";
	
					$stmt = $link->prepare($query);
					$stmt->bind_param('ss', $datefrom, $dateto);
					$stmt->execute();
					$stmt->bind_result($pdate, $bname, $pamnt, $pmethod, $refno, $invno);
					$x = 0;
					while($stmt->fetch()){
						$x++;
						
						$this->Cell($w[0],6,htmlspecialchars($pdate),'LR',0,'L');
						$this->Cell($w[1],6,htmlspecialchars($bname),'LR',0,'L');
						$this->Cell($w[2],6,$pamnt,'LR',0,'R');
						$this->Cell($w[3],6,$pmethod,'LR',0,'R');
						$this->Cell($w[4],6,$refno,'LR',0,'R');
						$this->Cell($w[5],6,$invno,'LR',0,'R');
						$this->Ln();
					}
					
					if($x < 20){
						for($n=$x; $n<=20; $n++){
							$this->Cell($w[0],6,'','LR',0,'L');
							$this->Cell($w[1],6,'','LR',0,'L');
							$this->Cell($w[2],6,'','LR',0,'R');
							$this->Cell($w[3],6,'','LR',0,'R');
							$this->Cell($w[4],6,'','LR',0,'R');
							$this->Cell($w[5],6,'','LR',0,'R');
							$this->Ln();
						}
					}
	// Closing line
	$this->Cell(array_sum($w),0,'','T');
	$this->Ln();
	
	
	
}
					
}
 function validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
		return $d && $d->format($format) === $date;
	}
$pdf = new PDF();
$pdf->AliasNbPages();
$number_of_rows = '';
if(!empty($_GET['customer'])){
		$customer_hashid = $_GET['customer'];
		$customer_detail_query = '';
		//make sure provided customer exists in database and get sanitized result
		
		$query = "SELECT `customer_hash` FROM `orders` WHERE `clientid` = '$clientid' AND `customer_hash` = ? LIMIT 1";
		
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $customer_hashid);
		$stmt->execute();
		$stmt->bind_result($cuh);
		while ($stmt->fetch()) {
			$customer_detail_query = " AND a.`customer_hashed_id` = '$cuh' ";
		}
	}
	$datefrom = date('Y-m-d', strtotime('-90 days'));
	$dateto = date('Y-m-d');
	if(isset($_GET['dfrom']) && validateDate($_GET['dfrom']) && isset($_GET['dto']) && validateDate($_GET['dto'])){
		$datefrom = $_GET['dfrom'];
		$dateto = $_GET['dto'];
    }
$query = "SELECT a.`pay_date`, c.`business_name`, a.`pay_amount`, a.`payment_method`, a.`reference_no`, b.`invoice_number` FROM `payments` a LEFT JOIN `orders` b ON a.`invoice_hash` = b.`invoice_number_hash` AND b.`clientid` = '$clientid' LEFT JOIN `customers` c on a.`customer_hashed_id` = c.`hashed_id` AND c.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`pay_date` >= ? AND a.`pay_date` <= ? $customer_detail_query ORDER BY a.`pay_date` DESC";
$stmt = $link->prepare($query);
$stmt->bind_param('ss', $datefrom, $dateto);
$stmt->execute();
$stmt->store_result();
$number_of_rows = $stmt->num_rows;
$stmt->close();
if($number_of_rows == 0){$number_of_rows = 1;}
$number_of_pages = ceil($number_of_rows/20);
for($x=1; $x <= ceil($number_of_rows/20); $x++){ 
	$pdf->AddPage('P', 'Letter', '0');
	$pdf->FancyTable($link, $clientid, $hashed_customer_number, $x);
}
if(isset($_GET['d']) && $_GET['d'] == '1'){
	$pdf->Output('d', $innumber.'.pdf');
}else{
	$pdf->Output();
}


?>
