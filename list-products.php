<?php
$page_title = 'Products';
$more_script = '<style>tfoot {display: table-header-group;}</style><script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<?php
if(isset($_GET['as'])){
	if($_GET['as'] == '1'){
		echo '<span class="gMessage">Successfully Added</span>';
	}
}
if(isset($_GET['es'])){
	if($_GET['es'] == '1'){
		echo '<span class="gMessage">Successfully Updated</span>';
	}
}
if(isset($_GET['rs'])){
	if($_GET['rs'] == '1'){
		echo '<span class="gMessage">Successfully Removed</span>';
	}
}
 ?>
<?php echo $products_links; ?>
<form action="new-product.php"><button type="submit" class="btn btn-primary btn-lg"">New Product</button></form>


<table class="row-border" id="gtable">
<caption>Products New</caption>
	<thead>
		<tr>
			<th>Item</th>
			<th>Brand</th>
			<th>Description</th>
			<th>Size</th>
			<th>Cost</th>
			<th>Retail</th>
			<th>Margin</th>
			<th>Qty</th>
			<th>Action</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Item</th>
			<th>Brand</th>
			<th>Description</th>
			<th>Size</th>
			<th>Cost</th>
			<th>Retail</th>
			<th>Margin</th>
			<th>Qty</th>
			<th>Action</th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		$query = "SELECT a.`uniqueid`, a.`cert_code`, a.`description`, a.`size_amount`, c.`description` brnd, b.`description` wd, a.`case_cost`, a.`case_price`, a.`QtyOnHand` FROM `grocery_products` a LEFT JOIN `weight_units` b ON a.`size_unit` = b.`id` AND b.`clientid` = '$clientid' LEFT JOIN `brands` c ON a.`brand` = c.`id` AND c.`clientid` = '$clientid' WHERE  a.`clientid` = '$clientid'";
		
		$result = mysqli_query($link, $query); 
		while($row = mysqli_fetch_array($result)) { 
			echo '<tr><td data-label="item">'.htmlspecialchars($row["cert_code"]).'</td>
			<td data-label="Brand">'.htmlspecialchars($row["brnd"]).'</td>
			<td data-label="Description">'.htmlspecialchars($row["description"]).'</td>
			<td data-label="Size">'.htmlspecialchars(@number_format($row['size_amount'], 1)).' '.htmlspecialchars($row['wd']).'</td>
			<td data-label="Cost">'.htmlspecialchars($row['case_cost']).'</td>
			<td data-label="Retail">'.htmlspecialchars($row['case_price']).'</td>';
			$mrgn = 'NA';
			if(!empty($row['case_price']) && !empty($row['case_cost'])){
				if($row['case_price'] > 0){
					$mrgn = number_format(((($row['case_price']-$row['case_cost']) / $row['case_price']) * 100),2).'%';
				}
			}
			echo '<td data-label="Case Retail">'.$mrgn.'</td>
			<td data-label="Qty">'.htmlspecialchars($row['QtyOnHand']).'</td>
			<td><span class="action-icons"><a href="edit-product.php?product='.htmlspecialchars($row['uniqueid']).'"><i class="fas fa-edit"></i></a><i id="delete'.htmlspecialchars($row['uniqueid']).'" class="fas fa-trash-alt"></i></span></td></tr>'; 
		}
		?>
</tbody>
</table>
<script type="text/javascript">

$(document).ready(function() {
    $('#gtable').DataTable({
		columnDefs: [
			{
				targets: -1,
				className: 'dt-left'
			}
		]
	});
	
});

</script>
<!-- The following div closes the main body div -->
</div>
<input type="hidden" id="subject" name="subject" value="product" />
<div class="populateDivGenDelete" id="populateDivGenCustDel">
	<div class="container text-center">
		<p class="mb-3">Are you sure you want to delete the selected record?</p>
		<div class="row">
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary btn-lg btn-block" id="yesBtn">Yes</button>
			</div>
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary btn-lg btn-block" id="noBtn">No</button>
			</div>
		</div>
	</div>
</div>






<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>