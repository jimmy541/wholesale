<?php
$more_script = '<style>.dataTables_wrapper table thead{display:none;}</style>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
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
<div class="container-fluid">
	<div class="row">
		<div class="col">
			<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#add-form" aria-expanded="false" aria-controls="add-form">Add New</button>
			<button  class="btn btn-link" id="removecurrent">Remove</button>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="collapse" id="add-form">
				<div class="row mb-1">
					<div class="col">
						<label for="newDesc" class="sr-only">Add New:</label>
						<input type="text" class="form-control form-control-sm" <?php if($table=='supplier'){ echo 'placeholder="Add supplier"'; }else echo 'placeholder="New '.$title.'"'?> id="newDesc" name="newDesc" />
					</div>
				</div>
				<?php if($table=='supplier'){?>
				<div class="row mb-1">
					<div class="col">
						<label for="" class="sr-only">Account:</label>
						<input type="text" class="form-control form-control-sm" placeholder="Account Number" id="newaccnum" name="newaccnum" />
					</div>
				</div>
				<div class="row mb-1">
					<div class="col">
						<label for="" class="sr-only">Contact:</label>
						<input type="text" class="form-control form-control-sm" placeholder="Phone Number" id="newphnu" name="newphnu" />
					</div>
				</div>
				<?php } ?>					
				<div class="row mb-2">
					<div class="col">
					<button type="button" class="btn btn-primary shadow mb-1 btn-sm mr-1" id="submitbtngen">Add</button>
					</div>
				</div>
			</div>
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
				echo '<tr><td data-label="Supplier Name"><span class="descPopValue" id="descPopValue'.$row['id'].'">'.htmlspecialchars($row["name"]).'</span></td></tr>'; 
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
    $("#gtable").dataTable( {
		paging: false,
		scrollY:        "32vh",
		"bInfo" : false,
        scrollCollapse: true,
        paging:         false,
		deferRender:    true,
		scroller:       true,
		 "pageLength": 50,
		 columnDefs: [
    {
        targets: -1,
        className: "dt[-head|-body]-center"
    }
  ]
	} );
	$("#gtable").parent().addClass("table-responsive");
} );
</script>'