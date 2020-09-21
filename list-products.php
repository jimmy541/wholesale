<?php
$page_title = 'Products';

$more_css = '<style>#gtable_filter{display:none;}</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">';

$more_script = '<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<?php
if(isset($_GET['as'])){
	if($_GET['as'] == '1'){
		echo '<div class="alert alert-success" role="alert">Successfully Added</div>';
	}
}
if(isset($_GET['es'])){
	if($_GET['es'] == '1'){
		echo '<div class="alert alert-success" role="alert">Successfully Updated</div>';
	}
}
if(isset($_GET['rs'])){
	if($_GET['rs'] == '1'){
		echo '<div class="alert alert-success" role="alert">Successfully Removed</div>';
	}
}
$department = '';
$subdepartment = '';
$category = '';

$department_query = '';
$subdepartment_query = '';
$category_query= '';
$supplier_query = '';

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


 

<div class="container-fluid">
	<div class="row mb-2">
		<div class="col">
			<?php if($role != 'Sales Representative') {echo $products_links; }?>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col">
		 <?php if($role != 'Sales Representative') { ?> <a class="btn btn-primary shadow float-right ml-1" href="new-product.php" role="button">New Product</a>  <?php } ?>
		<button type="button" class="btn btn-info shadow float-right ml-1" data-toggle="collapse" data-target="#filter-box"><i class="fas fa-filter"></i></button>
		</div>
		
	</div>
	<div class="row mb-4 collapse" id="filter-box">
	<div class="col">
		<div class="card">
			<div class="card-body">
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
							$query = "SELECT `id`, `description` FROM `category` WHERE `clientid` = '$clientid' ORDER BY `description` ASC";
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
				 <?php if($role != 'Sales Representative') { ?>
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
				 <?php } ?>
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
	</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<table class="row-border" id="list_products_php_table1">
				<thead>
					
					<tr>
						<th>Item</th>
						<th>Brand</th>
						<th>Description</th>
						<th>Size</th>
						<?php if($role != 'Sales Representative') { ?><th>Cost</th><?php } ?>
						<th>Retail</th>
						<th>Margin</th>
						<th>Qty</th>
						<?php if($role != 'Sales Representative') { ?><th>Action</th> <?php } ?>
					</tr>
				</thead>
				<tfoot>
					
					<tr>
						<th>Item</th>
						<th>Brand</th>
						<th>Description</th>
						<th>Size</th>
						<?php if($role != 'Sales Representative') { ?><th></th><?php } ?>
						<th></th>
						<th></th>
						<th></th>
						<?php if($role != 'Sales Representative') { ?><th></th> <?php } ?>
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
						<td data-label="Size">'.htmlspecialchars(@number_format($row['size_amount'], 1)).' '.htmlspecialchars($row['wd']).'</td>';
					if($role != 'Sales Representative') {echo '<td data-label="Cost">'.htmlspecialchars($row['case_cost']).'</td>'; }
						echo '<td data-label="Retail">'.htmlspecialchars($row['case_price']).'</td>';
						$mrgn = 'NA';
						if(!empty($row['case_price']) && !empty($row['case_cost'])){
							if($row['case_price'] > 0){
								$mrgn = number_format(((($row['case_price']-$row['case_cost']) / $row['case_price']) * 100),2).'%';
							}
						}
						echo '<td data-label="Case Retail">'.$mrgn.'</td>
						<td data-label="Qty">'.htmlspecialchars($row['QtyOnHand']).'</td>';
						
						if($role != 'Sales Representative') { echo '<td><span class="action-icons"><a href="edit-product.php?product='.htmlspecialchars($row['uniqueid']).'"><i class="fas fa-edit"></i></a><i id="list_products_php_table1_delete'.htmlspecialchars($row['uniqueid']).'" class="fas fa-trash-alt"></i></span></td>'; }
						echo '</tr>'; 
					}
					?>
			</tbody>
			</table>
				</div>
			</div>
			
		</div>
	</div>
</div>

<input type="hidden" id="subject" name="subject" value="product" />

<!-- Modal -->
<div class="modal fade" id="modal_remove_product" tabindex="-1" role="dialog" aria-labelledby="remove_product_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="remove_product_title">Remove Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
			<div class="row mb-3">
				<div class="col">
					<h6>Are you sure you want to remove the selected product?</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">No</button>
				</div>
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-primary btn-block" id="list_products_php_yes_btn">Yes</button>
				</div>
			</div>		
		  </div>
      </div>
      
    </div>
  </div>
</div>


<?php
$additional_script = ''; ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>