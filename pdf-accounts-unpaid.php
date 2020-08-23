<?php
require('php-scripts/fpdf.php');
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');

$number_of_pages = 1;
$innumber = '0';		
class PDF extends FPDF
{
// Page header
function Header()
{
	global $innumber;
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
		$business_name = '';
		$business_street_address_line1 = '';
		$business_street_address_line2 = '';
		$business_phone = '';
		$business_fax = '';
		
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

    //Company Name
    $this->SetFont('Arial','B',15);
    $this->Cell(0.01);
    $this->Cell(50,5,$business_name,0,0,'L');
	
	//Invoice or Quote title
    $this->SetFont('Arial','B',25);
    $this->Cell(79);
    $this->Cell(30,5,ucwords($order_type),0,0,'L');
    
	$this->Ln(6);
	
	//Company Address Line 1
    $this->SetFont('Arial','',12);
	$this->Cell(0.01);
    $this->Cell(50,5,$business_street_address_line1,0,0,'L');
	
	//Today Date
    $this->Cell(80);
    $this->Cell(30,6,'Date',1,0,'L');
	$this->Cell(30,6,date('m/d/Y'),1,0,'R');
	
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
	
	//Header
	$this->SetFont('Arial','B',16);
	$this->Cell(75);
    $this->Cell(90,5,'Unpaid Accounts',0,0,'L');
	
	
	$this->Ln(15);
	
	
	
	
	$this->Ln(5);
	
}

// Page footer
function Footer()
{
	global $number_of_pages;
	
	require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');
	
    $query = "SELECT SUM(`retail` + `tax` - `paid_total`) bln, SUM(case when `retail` + `tax` - `paid_total` <> 0 and `date_started` < DATE(DATE_ADD(NOW(), INTERVAL -`terms` DAY)) then `retail` + `tax` - `paid_total` else 0 end) as pastdue, SUM(case when `retail` + `tax` - `paid_total` <> 0 and `date_started` >= DATE(DATE_ADD(NOW(), INTERVAL -`terms` DAY)) then `retail` + `tax` - `paid_total` else 0 end) as current  FROM `orders` WHERE `clientid` = '$clientid' AND `order_type` = 'invoice' AND (`retail` + `tax` - `paid_total`) <> 0";
		$stmt = $link->prepare($query);
		$stmt->execute();
		$stmt->bind_result($bln, $pastdue, $current);
		while($stmt->fetch()){
			// Header total width 190
			$w = array(25, 90, 25, 25, 25);
			$this->SetFont('','B','10');
			$header = array('', '', number_format($pastdue, 2), number_format($current, 2), number_format($bln, 2));
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,0,'C');
			$this->Ln();
		}
	
	
	
	
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
	$w = array(25, 90, 25, 25, 25);
	$header = array('Account #', 'Business Name', 'Past Due', 'Current', 'Total');
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	// Color and font restoration
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	// Data
	
	$limit_clause = 'LIMIT '.(($pageNumber - 1) * 28).',28';
	
	$query = "SELECT b.`account_number`, b.`business_name`, b.`hashed_id`, SUM(a.`retail` + a.`tax` - a.`paid_total`) bln, a.`terms`, SUM(case when a.`retail` + a.`tax` - a.`paid_total` <> 0 and a.`date_started` < DATE(DATE_ADD(NOW(), INTERVAL -`terms` DAY)) then a.`retail` + a.`tax` - a.`paid_total` else 0 end) as pastdue, SUM(case when a.`retail` + a.`tax` - a.`paid_total` <> 0 and a.`date_started` >= DATE(DATE_ADD(NOW(), INTERVAL -`terms` DAY)) then a.`retail` + a.`tax` - a.`paid_total` else 0 end) as current  FROM `orders` a LEFT JOIN `customers` b on a.`customer_hash` = b.`hashed_id` WHERE a.`clientid` = '$clientid' AND a.`order_type` = 'invoice' AND (a.`retail` + a.`tax` - a.`paid_total`) <> 0 GROUP BY a.`customer_hash` $limit_clause";
					$stmt = $link->prepare($query);
					$stmt->execute();
					$stmt->bind_result($accnum, $busname, $hashid, $bln, $terms, $pastdue, $currentdue);
					$x = 0;
					while($stmt->fetch()){
						$x++;
						
						$this->Cell($w[0],6,htmlspecialchars($accnum),'LR',0,'L');
						$this->Cell($w[1],6,htmlspecialchars($busname),'LR',0,'L');
						$this->Cell($w[2],6,htmlspecialchars($pastdue),'LR',0,'R');
						$this->Cell($w[3],6,htmlspecialchars($currentdue),'LR',0,'R');
						$this->Cell($w[4],6,htmlspecialchars($bln),'LR',0,'R');
						$this->Ln();
					}
					
					if($x < 28){
						for($n=$x; $n<=28; $n++){
							$this->Cell($w[0],6,'','LR',0,'L');
							$this->Cell($w[1],6,'','LR',0,'L');
							$this->Cell($w[2],6,'','LR',0,'R');
							$this->Cell($w[3],6,'','LR',0,'R');
							$this->Cell($w[4],6,'','LR',0,'R');
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
$query = "SELECT SUM(`retail` + `tax` - `paid_total`) bln  FROM `orders` WHERE `clientid` = '$clientid' AND `order_type` = 'invoice' AND (`retail` + `tax` - `paid_total`) <> 0 GROUP BY `customer_hash`";
$stmt = $link->prepare($query);
$stmt->execute();
$stmt->store_result();
$number_of_rows = $stmt->num_rows;
$stmt->close();
if($number_of_rows == 0){$number_of_rows = 1;}
$number_of_pages = ceil($number_of_rows/28);
for($x=1; $x <= ceil($number_of_rows/28); $x++){ 
	$pdf->AddPage('P', 'Letter', '0');
	$pdf->FancyTable($link, $clientid, $hashed_customer_number, $x);
}
if(isset($_GET['d']) && $_GET['d'] == '1'){
	$pdf->Output('d', $innumber.'.pdf');
}else{
	$pdf->Output();
}


?>
