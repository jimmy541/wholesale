<?php
require('php-scripts/fpdf.php');
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
if(isset($_GET['invoice']) && !empty($_GET['invoice'])){
	
		$hashed_invoice_number = $_GET['invoice'];
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

if(isset($_GET['invoice']) && !empty($_GET['invoice'])){
	
		$hashed_invoice_number = $_GET['invoice'];
		$invoice_number = '';
		$customer_hash = '';
		$invoice_date = '';
		$entered_by = '';
		$salesperson = '';
		$terms = '';
		$sub_total = '$0.00';
		$order_type = '';
		
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
		
		$query = "SELECT `invoice_number`, `customer_hash`, `date_started`, `entered_by`, `terms`, `order_type` FROM `orders` WHERE `invoice_number_hash` = ? AND `clientid` = '$clientid'";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $hashed_invoice_number);
		$stmt->execute();
		$stmt->bind_result($inn, $ch, $ds, $eb, $te, $ot);
		while($stmt->fetch()){
			$invoice_number = htmlspecialchars($inn);
			$innumber = htmlspecialchars($inn);
			$customer_hash = $ch;
			$invoice_date = htmlspecialchars($ds);
			$entered_by = $eb;
			$terms = $te;
			$order_type = $ot;
		}
		if($terms == '0'){
			$terms = 'COD';
		}else{
			$terms = $terms.' Days'; 
		}
		$stmt->close();
		
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
		
		$query = "SELECT `display_code` FROM `users` WHERE `clientid` = '$clientid' AND `email_address` = '$entered_by'";
		$stmt = $link->prepare($query);
		$stmt->execute();
		$stmt->bind_result($rslt1);
		while($stmt->fetch()){
			$salesperson = $rslt1;
			
		}
		$stmt->close();
		
		$query = "SELECT `account_number`, `business_name`, `shipping_address1`, `shipping_address2`, `shipping_city`, `shipping_state`, `shipping_zip_code`, `shipping_phone_number1`, `shipping_phone_number1ext`, `shipping_fax`, `mailing_address1`, `mailing_address2`, `mailing_city`, `mailing_state`, `mailing_zip_code`, `mailing_phone_number1`, `mailing_phone_number1ext`, `mailing_fax` FROM `customers` WHERE `clientid` = '$clientid' AND `hashed_id` = ?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $customer_hash);
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
		
		$query = "SELECT b.`description` description, a.`a_category` id FROM `grocery_products` a left join `acategory` b on a.`a_category` = b.`id` AND b.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`a_category` <> '0' GROUP BY a.`a_category` ORDER BY b.`description` LIMIT 1";
		$result = mysqli_query($link, $query);
		$cat = "uncat";
		while ($row = mysqli_fetch_array($result)){
			$cat = $row['id'];
			
		}
		
}else{
	die("Sorry, this page doesn't exist");

}
    //Company Name
    $this->SetFont('Arial','B',15);
    $this->Cell(0.01);
    $this->Cell(50,5,$business_name,0,0,'L');
	
	//Invoice or Quote title
    $this->SetFont('Arial','B',25);
    $this->Cell(79);
    $this->Cell(30,5,'Pull Sheet',0,0,'L');
    
	$this->Ln(6);
	
	//Company Address Line 1
    $this->SetFont('Arial','',12);
	$this->Cell(0.01);
    $this->Cell(50,5,$business_street_address_line1,0,0,'L');
	
	//Invoice Date
    $this->Cell(80);
    $this->Cell(30,6,'Date',1,0,'L');
	$this->Cell(30,6,date('m/d/Y', strtotime($invoice_date)),1,0,'R');
	
	$this->Ln(6);
	
	//Company Address Line 2
	$this->Cell(0.01);
    $this->Cell(50,5,$business_street_address_line2,0,0,'L');
	
	
	//Invoice or Quote Number
	// $this->Cell(80);
    // $this->Cell(30,6,ucwords($order_type).' No.',1,0,'L');
	// $this->Cell(30,6,$invoice_number,1,0,'R');
	
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
    $this->Cell(90,5,'Customer',0,0,'L');
	
		
	$this->Rect(10, 47, 90, 40);
	
	
	$this->Line(10, 54, 100, 54);
	
	
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
	
	
	$this->Ln(15);
	
	
	
	$this->Ln(5);
	
}

// Page footer
function Footer()
{
	global $number_of_pages;
		
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}	
	



// Colored table
function FancyTable($link, $clientid, $hashed_invoice_number, $pageNumber)
{
	// Colors, line width and bold font
	$this->SetFillColor(255);
	$this->SetTextColor(0);
	$this->SetDrawColor(0);
	$this->SetLineWidth(.1);
	$this->SetFont('','B','10');
	// Header width must be 190
	$w = array(40, 110, 40);
	$header = array('Item No.', 'Description', 'Qty');
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	// Color and font restoration
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	// Data
	
	$limit_clause = 'LIMIT '.(($pageNumber - 1) * 20).',20';
	
	$query = "SELECT `cert_code`, `qty`, `description`, `retail`, `total_price`, `Pack`, `size` FROM `requested_items` WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ? ORDER BY `cert_code` ASC $limit_clause";
					$stmt = $link->prepare($query);
					$stmt->bind_param('s', $hashed_invoice_number);
					$stmt->execute();
					$stmt->bind_result($ce_co, $qy, $des, $ret, $to_pr, $pk, $sz);
					$x = 0;
					while($stmt->fetch()){
						$x++;
						
						$this->Cell($w[0],6,htmlspecialchars($ce_co),'LR',0,'L');
						$this->Cell($w[1],6,htmlspecialchars($des).' '.$pk.'x'.$sz,'LR',0,'L');
						$this->Cell($w[2],6,htmlspecialchars($qy),'LR',0,'R');
						
						$this->Ln();
					}
					if($x < 25){
						for($n=$x; $n<=25; $n++){
							$this->Cell($w[0],6,'','LR',0,'L');
							$this->Cell($w[1],6,'','LR',0,'L');
							$this->Cell($w[2],6,'','LR',0,'R');
							
							$this->Ln();
						}
					}
	// Closing line
	$this->Cell(array_sum($w),0,'','T');
	$this->Ln();
	
	
	
}
}
 
$pdf = new PDF();
$pdf->AliasNbPages();
$number_of_rows = '';
$query = "SELECT `invoice_number_hash` FROM `requested_items` WHERE `clientid` = '$clientid' AND `invoice_number_hash` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('s', $hashed_invoice_number);
$stmt->execute();
$stmt->store_result();
$number_of_rows = $stmt->num_rows;
$stmt->close();
if($number_of_rows == 0){$number_of_rows = 1;}
$number_of_pages = ceil($number_of_rows/20);
for($x=1; $x <= ceil($number_of_rows/20); $x++){ 
	$pdf->AddPage('P', 'Letter', '0');
	$pdf->FancyTable($link, $clientid, $hashed_invoice_number, $x);
}
if(isset($_GET['d']) && $_GET['d'] == '1'){
	$pdf->Output('d', $innumber.'.pdf');
}else{
	$pdf->Output();
}


?>
