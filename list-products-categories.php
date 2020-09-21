<?php
$page_title = 'Categories';
$more_css = '<style>#list_products_categories_php_table1_filter{display:none;}</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="css/populateContainers.css">';


$more_script = '<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');
$table = 'category';
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
 ?>
<div class="container-fluid">
	<div class="row mb-2">
		<div class="col">
			<?php echo $products_links; ?>
		</div>
	</div>
<div class="row">
	<div class="col">
<form class="form-inline" action="php-scripts/process-general.php" method="POST" autocomplete="off">
<div class="form-group mx-sm-3 mb-2">
	<label for="newDesc" class="sr-only">Add New:</label> <input class="form-control" type="text" id="newDesc" name="newDesc" placeholder="Add New" />
	
</div>
<button class="btn btn-primary shadow mb-2" type="submit">Add</button>
<input type="hidden" id="subject" name="subject" value="catc" />
</form>
</div>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
<table class="row-border" id="list_products_categories_php_table1">

	<thead>
		<tr>
			<th>Description</th>
			<th>Action</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Description</th>
			<th></th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		$query = "SELECT * FROM `$table` WHERE `clientid` = '$clientid'";
		$result = mysqli_query($link, $query); 
		while($row = mysqli_fetch_array($result)) { 
			echo '<tr><td data-label="Description" id="tdid'.$row['id'].'"><span id="desc'.$row['id'].'">'.htmlspecialchars($row["description"]).'</span></td><td data-label="Action"> <span class="actionicon" ><i class="fa fa-edit" id="list_products_categories_php_table1_edit'.$row['id'].'"></i> </span> - <span class="actionicon" ><i class="fas fa-trash-alt" id="list_products_categories_php_table1_delete'.$row['id'].'"></i></span></td></tr>';  
		}
		?>
</tbody>
</table>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_remove_product_categories" tabindex="-1" role="dialog" aria-labelledby="remove_product_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="remove_product_title">Remove Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
			<div class="row mb-3">
				<div class="col">
					<h6>Are you sure you want to remove the selected brand?</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">No</button>
				</div>
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-primary btn-block" id="list_products_categories_php_yes_btn">Yes</button>
				</div>
			</div>		
		  </div>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_edit_product_category" tabindex="-1" role="dialog" aria-labelledby="edit_product_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit_product_title">Edit Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
			<div class="row mb-3">
				<div class="col">
					<input class="form-control" type="text" value="" id="updatedvalue" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancel</button>
				</div>
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-primary btn-block" id="list_products_categories_php_save_btn">Save</button>
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