<?php
$page_title = 'Products';
$more_script = '<style>#gtable_filter{display:none;}</style><script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
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
$department = '';
$subdepartment = '';
$category = '';

$department_query = '';
$subdepartment_query = '';
$category_query= '';

if(isset($_GET['department']) && !empty($_GET['department'])){
	if(is_numeric($_GET['department'])){
		$department = $_GET['department'];
		$department_query = " AND a.`department` = '$department'";
	}
	
}
if(isset($_GET['subdepartment']) && !empty($_GET['subdepartment'])){
	if(is_numeric($_GET['subdepartment'])){
		$subdepartment = $_GET['subdepartment'];
		$subdepartment_query = " AND a.`sub_department` = '$subdepartment'";
	}
}
if(isset($_GET['category']) && !empty($_GET['category'])){
	if(is_numeric($_GET['category'])){
		$category = $_GET['category'];
		$category_query = " AND a.`category` = '$category'";
	}
}
if(isset($_GET['supplier']) && !empty($_GET['supplier'])){
	if(is_numeric($_GET['supplier'])){
		$supplier = $_GET['supplier'];
		$supplier_query = " AND a.`supplier` = '$supplier'";
	}
}
 ?>
<?php echo $products_links; ?>
<p>
  <a class="btn btn-primary shadow" href="new-product.php" role="button">
    New Product
  </a>
  
 <button type="button" class="btn btn-info shadow float-right" data-toggle="collapse" data-target="#filter-box"><i class="fas fa-filter"></i></button>


 </p>
<div class="container-fluid">
<div class="row collapse" id="filter-box">
<div class="col">
	<h4>Filter</h4>
	<form method="get">
		<div class="form-row">
			<div class="col-md-3 mb-3">
				 <label for="department">Department</label>
				<select class="form-control" id="department" name="department" style="height: 38px !important">
					<option></option>
					<?php
						$query = "SELECT `id`, `description` FROM `department` WHERE `clientid` = '$clientid' ORDER BY `description` ASC";
						$stmt = $link->prepare($query);
						$stmt->execute();
						$stmt->bind_result($id, $description);
						while($stmt->fetch()){
							$selected = '';
							if($id == $department){$selected = 'selected';}
							echo '<option value="'.htmlspecialchars($id).'" '.$selected.'>'.htmlspecialchars($description).'</option>';
						}
						$stmt->close();
					?>
				</select>
			</div>
			<div class="col-md-3 mb-3">
				<label for="subdepartment">Sub Department</label>
				<select class="form-control" id="subdepartment" name="subdepartment" style="height: 38px !important">
					<option></option>
					<?php
						$query = "SELECT `id`, `description` FROM `sub_department` WHERE `clientid` = '$clientid' ORDER BY `description` ASC";
						$stmt = $link->prepare($query);
						$stmt->execute();
						$stmt->bind_result($id, $description);
						while($stmt->fetch()){
							$selected = '';
							if($id == $subdepartment){$selected = 'selected';}
							echo '<option value="'.htmlspecialchars($id).'" '.$selected.'>'.htmlspecialchars($description).'</option>';
						}
						$stmt->close();
					?>
				</select>
			</div>
			<div class="col-md-3 mb-3">
				<label for="category">Category</label>
				<select class="form-control" id="category" name="category" style="height: 38px !important">
					<option></option>
					<?php
						$query = "SELECT `id`, `description` FROM `sub_department` WHERE `clientid` = '$clientid' ORDER BY `description` ASC";
						$stmt = $link->prepare($query);
						$stmt->execute();
						$stmt->bind_result($id, $description);
						while($stmt->fetch()){
							$selected = '';
							if($id == $category){$selected = 'selected';}
							echo '<option value="'.htmlspecialchars($id).'" '.$selected.'>'.htmlspecialchars($description).'</option>';
						}
						$stmt->close();
					?>
				</select>
			</div>
			<div class="col-md-3 mb-3">
				<label for="supplier">Supplier</label>
				<select class="form-control" id="supplier" name="supplier" style="height: 38px !important">
					<option></option>
					<?php
						$query = "SELECT `id`, `name` FROM `supplier` WHERE `clientid` = '$clientid' ORDER BY `name` ASC";
						$stmt = $link->prepare($query);
						$stmt->execute();
						$stmt->bind_result($id, $name);
						while($stmt->fetch()){
							$selected = '';
							if($id == $supplier){$selected = 'selected';}
							echo '<option value="'.htmlspecialchars($id).'" '.$selected.'>'.htmlspecialchars($name).'</option>';
						}
						$stmt->close();
					?>
				</select>
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-4 mb-3">
			
			</div>
			<div class="col-md-4 mb-3">
			
			</div>
			<div class="col-md-4 mb-3">
			
			</div>
		</div>
		 <input type="submit" class="btn btn-primary shadow mb-2" id="sbbtn" value="Search" />
    
	</form>
</div>
</div>
<div class="row">
<div class="col">

<table class="row-border" id="gtable">
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
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		$query = "SELECT a.`uniqueid`, a.`cert_code`, a.`description`, a.`size_amount`, c.`description` brnd, b.`description` wd, a.`case_cost`, a.`case_price`, a.`QtyOnHand` FROM `grocery_products` a LEFT JOIN `weight_units` b ON a.`size_unit` = b.`id` AND b.`clientid` = '$clientid' LEFT JOIN `brands` c ON a.`brand` = c.`id` AND c.`clientid` = '$clientid' WHERE  a.`clientid` = '$clientid' $department_query $subdepartment_query $category_query $supplier_query";
		
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
</div>
</div>
</div>
<script type="text/javascript">
/*
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
*/
$(document).ready(function() {
	
    // Setup - add a text input to each footer cell
    $('#gtable tfoot th').each( function () {
        var title = $(this).text();
		if(title == 'Brand' || title == 'Item' || title == 'Description' || title == 'Size'){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
 
    // DataTable
    var table = $('#gtable').DataTable({
		
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	
} );

</script>
<!-- The following div closes the main body div -->
</div>
<input type="hidden" id="subject" name="subject" value="product" />
<div class="populateDivGenDelete" id="populateDivGenCustDel">
	<div class="container text-center">
		<p class="mb-3">Are you sure you want to delete the selected record?</p>
		<div class="row">
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary shadow btn-lg btn-block" id="yesBtn">Yes</button>
			</div>
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary shadow btn-lg btn-block" id="noBtn">No</button>
			</div>
		</div>
	</div>
</div>






<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>