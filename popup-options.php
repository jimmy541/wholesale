<?php

$more_script = '<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/popup-form-header.php');
if(isset($_GET['reid']) && $_GET['reid']=='f146aa9099b551a29e4d4ae56e170c7'){
	$table = 'brands';
	$title = "Brands";
}
if(isset($_GET['reid']) && $_GET['reid']=='adae3bad1bca266a568ecbc72e698c9'){
	$table = 'department';
	$title = "Departments";
}
if(isset($_GET['reid']) && $_GET['reid']=='adae3bad1bca266a568ecbc82e698c5'){
	$table = 'sub_department';
	$title = "Sub Departments";
}
if(isset($_GET['reid']) && $_GET['reid']=='trae3bad1bca266a568ecbc82e698c8'){
	$table = 'category';
	$title = "Categories";
}
if(isset($_GET['reid']) && $_GET['reid']=='trae3bad2dca266a568ecbc82e698c8'){
	$table = 'supplier';
	$title = "Suppliers";
}
?>
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

<button type="button" class="close" aria-label="Close" id="closeBtn">
  <span aria-hidden="true">&times;</span>
</button>
<div class="container-fluid">
	<div class="row mb-2">
		<div class="col">
			<form class="form-inline">
				<div class="form-group mb-2">
					<label for="newDesc" class="sr-only">Add New:</label>
					<input type="text" class="form-control form-control-sm" <?php if($table=='supplier'){ echo 'placeholder="Add supplier"'; }else echo 'placeholder="New '.$title.'"'?> id="newDesc" name="newDesc" />
				</div>
				
				<?php if($table=='supplier'){?>
				<div class="form-group mb-2">
					<label for="" class="sr-only">Account:</label>
					<input type="text" class="form-control form-control-sm" placeholder="Account Number" id="newaccnum" name="newaccnum" />
				</div>
				<div class="form-group mb-2">
					<label for="" class="sr-only">Contact:</label>
					<input type="text" class="form-control form-control-sm" placeholder="Phone Number" id="newphnu" name="newphnu" />
				</div>
				<?php } ?>	
				<button type="button" class="btn btn-primary shadow mb-1 btn-sm" id="submitbtngen">Add</button>
				<button type="button" class="btn btn-danger mb-1 btn-sm" id="removecurrent">Remove</button>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<table class="row-border compact " id="gtable">
<!--<caption><?php echo $title; ?></caption>-->
	<thead>
		<tr>
		<?php if($table != 'supplier'){?>
			<th><?php echo $title; ?></th>
			
		<?php }else{ ?>
			<th>Supplier Name</th>
			<th>Account Number</th>
			<th>Phone Number</th>
		<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php
		if($table != 'supplier'){
			$query = "SELECT * FROM `$table` WHERE `clientid` = '$clientid'";
			$result = mysqli_query($link, $query); 
			while($row = mysqli_fetch_array($result)) { 
				echo '<tr><td data-label="Description"><span class="descPopValue" id="descPopValue'.$row['id'].'">'.htmlspecialchars($row["description"]).'</span></td></tr>'; 
			}
		}else{
			$query = "SELECT * FROM `supplier` WHERE `clientid` = '$clientid'";
			$result = mysqli_query($link, $query); 
			while($row = mysqli_fetch_array($result)) { 
				echo '<tr><td data-label="Supplier Name"><span class="descPopValue" id="descPopValue'.$row['id'].'">'.htmlspecialchars($row["name"]).'</span></td><td data-label="Account Number">'.htmlspecialchars($row["account_number"]).'</td><td data-label="Phone Number">'.$row['phone_number'].'</td></tr>'; 
			}
		}
		?>
</tbody>
</table>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#gtable').dataTable( {
		paging: false,
		scrollY:        400,
		deferRender:    true,
		scroller:       true,
		 "pageLength": 50,
		 columnDefs: [
    {
        targets: -1,
        className: 'dt[-head|-body]-center'
    }
  ]
	} );
	$('#gtable').parent().addClass('table-responsive');
} );

</script>

</div>
