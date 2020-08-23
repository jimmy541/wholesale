<html>
<head>

 		<link rel="stylesheet" type="text/css" href="css/view-order.css">
 		</head>
 		<body>
<?php

if (isset($_GET['vendor'])){
	if (!empty($_GET['vendor'])){
	require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');
	$vendor = $_GET['vendor'];
	echo '<center><h1>'.$_GET['vendor'].'</h1></center>';
	echo '<center><div style="width:800px;text-align:left;">Red Tomatoes Farmers Market<br/>
			9950 W Foothill Blvd Unit V<br/>
			Rancho Cucamonga, CA 91730 <br/>
			909-987-8700<br/>
			<br/>
			Date: '.date("m/d/Y").'<br/></div></center>';
	$query = 'SELECT grocery_products.upc, grocery_products.cert_code, grocery_products.description, grocery_products.size, grocery_products.Pack, grocery_products.name, requested_items.qty FROM grocery_products 
	INNER JOIN requested_items 
	ON grocery_products.upc = requested_items.upc
	WHERE grocery_products.name = \''.$vendor.'\' 
	AND requested_items.qty > 0
	ORDER BY grocery_products.upc';
	
	$result = mysqli_query($link, $query);
	echo '<center><div class="CSSTableGenerator"><table><tr><td>UPC</td><td>Item Code</td><td>Description</td><td>Size</td><td>Quantiy</td><td>Pic</td></tr>';
	while ($row = mysqli_fetch_array($result)){
		
		echo '<tr><td>'.$row['upc'].'</td><td>'.$row['cert_code'].'</td><td>'.$row['description'].'</td><td>'.$row['Pack'].' X '.$row['size'].'</td><td>'.$row['qty'].'</td><td><img class="tableImg" src="pics/'.$row['upc'].'.jpg"></td></tr>';
	
	
	}
	echo '</table></div></center>';

	
	
	
	
	
	}
}
?>
</body>
</html>