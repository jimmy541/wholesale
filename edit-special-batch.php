<?php $page_title = 'Edit Specials Batch';

$more_css = '<link rel="stylesheet" href="css/jquery.dataTables.min.css">';

$more_script = '<script type="text/javascript" src="js/form-validation.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/selected-table.js"></script>';

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<?php
$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<div class="alert alert-danger" role="alert">Description fields are required.</div>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<div class="alert alert-success" role="alert">Successfully Added.</div>';}
$description = '';
$start_date = '';
$end_date = '';
$active = '';
$cleanid = '';
if(isset($_GET['id']) && !empty($_GET['id'])){
	$id = $_GET['id'];
}
$query="SELECT `id`, `description`, `start_date`, `end_date`, `is_active` FROM `special_batch` WHERE `id` = ? AND `clientid` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param('ss', $id, $clientid);
$stmt->execute();
$stmt->bind_result($cid, $des, $sd, $ed, $ac);
 //switch to false when done testing
while ($stmt->fetch()) {
	$description = $des;
	$start_date = $sd;
	$end_date = $ed;
	$active = $ac;
	$cleanid = $cid;
}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col">
			<ul class="nav">
				<a class="nav-link" href="list-special-batches.php" title="Special Batches">Special Batches</a>
			</ul>
		</div>
	</div>
	
	
<!-- open row -->
	<div class="row mb-3">
	<!-- open col -->
		<div class="col">
			<div class="card">
				<div class="card-body">
					<?php echo $responseMsg; ?>
					<form  id="new-special-batch" action="php-scripts/process-edit-special-batch.php" method="post">	
							<input type="hidden" name="batch_id" id="batch_id" value="<?php echo $cleanid; ?>" />
							<div class="row">
								<div class="col-md-6 mb-3">
									<div class="custom-control custom-switch">
											<input class="custom-control-input" type="checkbox" id="is_active" name="is_active" <?php if($active=='1'){echo ' checked';} ?>>
											<label class="custom-control-label" for="is_active">Active</label>
									</div>
							</div>
							</div>
							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="description">Description</label>
									<input class="form-control"  type="text" id="description" name="description" value="<?php echo htmlspecialchars($description); ?>"/>
								</div>
							</div>
							<hr class="mb-4">
							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="start_date">Start Date</label>
									<input class="form-control"  type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>"/>
								</div>
								<div class="col-md-6 mb-3">
									<label for="end_date">End Date</label>
									<input class="form-control" type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>"/>
								</div>
							</div>
							<div class="mb-3">
								<button class="btn btn-primary shadow btn-lg btn-block" type="submit">Save</button>
							</div>
					</form>
				</div>
			</div>
	<!-- close col -->
		</div>
<!-- close row -->
	</div>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
				<div class="row">
				<div class="col">
					<button class="btn btn-primary shadow btn-sm" type="button" data-toggle="modal" data-target="#search_products"><i class="fas fa-plus mr-2" ></i>New</button>
				</div>
				</div>
				<div class="row">
				<div class="col">
					<table class="row-border" id="special_products">
						<thead>
							<tr>
								
								
								<th>Item Code</th>
								<th>Description</th>
								<th>Size</th>
								<th>Special Price</th>
								<th>Min Qty</th>
								<th>Free Case/s</th>
								<th>Action</th>
								<th style="display:none;"></th>
								<th style="display:none;"></th>
								<th style="display:none;"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = "SELECT a.`item_code`, a.`description`, a.`size`, a.`single_case_price`, a.`minimum_qty`, a.`free_cases`, a.`uid`, b.`case_cost`, b.`case_price`, b.`cases_on_pallet`  FROM `special_batch_products` a left join `grocery_products` b on a.`item_code` = b.`cert_code` AND a.`clientid` = '$clientid' WHERE a.`clientid` = '$clientid' AND a.`id` = '$cleanid' ORDER BY a.`uid` DESC";
							$result = mysqli_query($link, $query); 
							while($row = mysqli_fetch_array($result)) { 
								echo '<tr>
								
								
								<td data-label="Item Code">'.htmlspecialchars($row["item_code"]).'</a></td>
								<td data-label="Description">'.htmlspecialchars($row["description"]).'</td>
								<td data-label="Size">'.$row['size'].'</td>
								<td data-label="Case Price">'.$row['single_case_price'].'</td>
								<td data-label="Min Qty">'.$row['minimum_qty'].'</td>
								<td data-label="Free Case">'.$row['free_cases'].'</td>
								<td><span class="action-icons"><i class="fas fa-edit" id="update_batch_product'.$row['uid'].'"></i><i class="fas fa-trash-alt" id="remove_item_from_batch'.$row['uid'].'"></i></span></td>
								<td style="display:none;">'.$row['case_cost'].'</td>
								<td style="display:none;">'.$row['case_price'].'</td>
								<td style="display:none;">'.$row['cases_on_pallet'].'</td>
								</tr>'; 
							}
							?>
						</tbody>
					</table>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
<!-- close container -->
</div>

<!-- Modal -->
<div class="modal fade" id="search_products" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Search Products</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
<div class="modal-body" >
  <div class="container-fluid">
    <div class="row">
      <div class="col">
		<table class="row-border" id="products_modal_gtable">
			<thead>
				<tr>
					<th style="display:none;">uniqueid</th>
					<th>Item</th>
					<th>Brand</th>
					<th>Description</th>
					<th>Size</th>
					<th>Retail</th>
					<th>Qty</th>
					<th style="display:none;">Cost</th>
					<th style="display:none;">Cases in Pallet</th>
					
				</tr>
			</thead>
			
			<tbody>
				<?php 
				$query="SELECT a.`uniqueid`, a.`cert_code`, a.`description`, a.`size_amount`, c.`description` brnd, b.`description` wd, a.`case_cost`, a.`case_price`, a.`QtyOnHand`, a.`cost`, a.`cases_on_pallet` FROM `grocery_products` a LEFT JOIN `weight_units` b ON a.`size_unit` = b.`id` AND b.`clientid` = '$clientid' LEFT JOIN `brands` c ON a.`brand` = c.`id` AND c.`clientid` = '$clientid' LEFT OUTER JOIN `special_batch_products` d ON a.`uniqueid` = d.`product_uid` AND d.`clientid` = '$clientid'  WHERE  a.`clientid` = '$clientid' AND d.`product_uid` IS NULL" ;
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_array($result)) {
					echo '<tr>';
						echo '<td data-label="uniqueid" style="display:none;">'.$row['uniqueid'].'</td>';
						echo '<td data-label="item">' .htmlspecialchars($row["cert_code" ]).'</td>';
						echo '<td data-label="Brand">' .htmlspecialchars($row["brnd" ]).'</td>';
						echo '<td data-label="Description">' .htmlspecialchars($row["description" ]).'</td>';
						echo '<td data-label="Size">' .htmlspecialchars(@number_format($row['size_amount' ], 1)).' ' .htmlspecialchars($row['wd' ]).'</td>' ;
						echo '<td data-label="Retail">' .htmlspecialchars($row['case_price' ]).'</td>';
						echo '<td data-label="Qty">'.htmlspecialchars($row['QtyOnHand']).'</td>';
						echo '<td data-label="cost" style="display:none;">'.htmlspecialchars($row['cost']).'</td>';
						echo '<td data-label="cases on pallet" style="display:none;">'.htmlspecialchars($row['cases_on_pallet']).'</td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	  
	  </div>
    </div>
  </div>
</div>
 <div class="modal-footer">
       
        <button type="button" class="btn btn-primary" id="add_product_button" data-toggle="modal" data-target="#add_products_push_specials" disabled>Add Special Price</button>
      </div>
    </div>
  </div>
</div>
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
					<button type="button" class="btn btn-primary btn-block" id="delete_product_special_batch">Yes</button>
				</div>
			</div>		
		  </div>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add_products_push_specials" tabindex="-1" role="dialog" aria-labelledby="modal_add_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg bg-light">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_add_title">Special Price</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="special_batch_product_price_form" method="post" action="php-scripts/process-add-product-to-special-batch.php">
		<input type="hidden" name="batch_id" value="<?php echo $cleanid; ?>" />
		<input type="hidden" value="" id="product_id_form_1" name="product_id"/>
			<div class="form-row">
				<div class="form-group col-8">
					<label for="product_description">Description</label>
					<input type="text" class="form-control form-control-sm" name="product_description" id="product_description" readonly>
				</div>
				<div class="form-group col-4">
					<label for="regular_price">Regular Price</label>
					<input type="number" class="form-control form-control-sm" name="regular_price" id="regular_price" min="0" step="0.01" readonly>
				</div>
				
			</div>
			<div class="form-row">
				<div class="form-group col-6">
					<label for="cost">Cost</label>
					<input type="number" class="form-control form-control-sm" name="cost" min="0" step="0.01" id="cost" readonly>
				</div>
				<div class="form-group col-6">
					<label for="cases_in_pallet">Cases in Pallet</label>
					<input type="number" class="form-control form-control-sm" name="cases_in_pallet" id="cases_in_pallet" min="0" readonly>
				</div>
				
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label for="single_case_price">Special Price</label>
					<input type="number" class="form-control form-control-sm" name="single_case_price" id="single_case_price" min="0" step="0.01">
				</div>
				
			</div>
			
			<div class="form-row">
			<div class="form-group col-6">
					<label for="minimum_qty">Minimum Quantity</label>
					<input type="number" class="form-control form-control-sm" name="minimum_qty" id="minimum_qty"  min="0">
					<small class="form-text text-muted">Leave blank or 0 if no minimum quantity is required.</small>
				</div>
				<div class="form-group col-6">
					<label for="free_cases">Free Case/s</label>
					<input type="number" class="form-control form-control-sm" name="free_cases" id="free_cases"  min="0">
					<small class="form-text text-muted">Leave blank or 0 if no free case/s offered.</small>
				</div>
				
			</div>
		</form>
      </div>
      <div class="modal-footer">
        
        <button type="submit" form="special_batch_product_price_form" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
<?php
$additional_script = '<script type="text/javascript">
$(document).ready(function() {
    $("#special_products").DataTable();
	$("#special_products").parent().addClass("table-responsive");
	$("#products_modal_gtable").DataTable();
	$("#products_modal_gtable").parent().addClass("table-responsive");
} );
</script>'; ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>