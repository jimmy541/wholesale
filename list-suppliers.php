<?php
$page_title = 'Suppliers';

$more_css = '<style>#list_suppliers_php_table1_filter{display:none;}</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">';
$more_script = '<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');
echo '<h3 class="page-header">'.$page_title.'</h3>';

?>
<br/>

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
			<form action="new-supplier.php"><button type="submit" class="btn btn-primary shadow float-right">New Supplier</button></form>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
<table class="row-border" id="list_suppliers_php_table1">
	<thead>
		<tr>
			<th>Supplier Name</th>
			<th>Account Number</th>
			<th>Phone Number</th>
			<th>Action</th>
		</tr>
	</thead>	
	<tfoot>
		<tr>
			<th>Supplier Name</th>
			<th>Account Number</th>
			<th>Phone Number</th>
			<th></th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		$query = "SELECT * FROM `supplier` WHERE `clientid` = '$clientid'";
		$result = mysqli_query($link, $query); 
		while($row = mysqli_fetch_array($result)) { 
			echo '<tr>
			<td data-label="Supplier Name">'.htmlspecialchars($row["name"]).'</td>
			<td data-label="Account Number">'.htmlspecialchars($row["account_number"]).'</td>
			<td data-label="Phone Number">'.$row['phone_number'].'</td>
			<td><span class="action-icons"><a href="edit-supplier.php?token='.htmlspecialchars($row['hashed_id']).'">
				<i class="fas fa-edit"></i></a>
				<i id="list_suppliers_php_delete'.htmlspecialchars($row['hashed_id']).'" class="fas fa-trash-alt"></i></span></td>
			</tr>'; 
		}
		?>
	</tbody>
</table>
				</div>
			</div>
		</div>
	</div>
<div>
<input type="hidden" id="subject" name="subject" value="supp" />

<!-- Modal -->
<div class="modal fade" id="modal_delete_supplier" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Delete Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
			<div class="row mb-3">
				<div class="col">
					<h6>Are you sure you want to delete the selected supplier?</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">No</button>
				</div>
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-primary btn-block" id="list_suppliers_php_yes_btn">Yes</button>
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