<?php
$page_title = 'Tax Types';

$more_css = '<style>#gtable_filter{display:none;}</style>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" href="css/populateContainers.css">';


$more_script = '<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/popgeneral.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');
$table = 'product_tax_types';
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
	<label for="newDesc" class="sr-only">Description:</label> <input class="form-control" type="text" id="newDesc" name="newDesc" placeholder="Description" />
	
</div>
<div class="form-group mx-sm-3 mb-2">
	<label for="newValue" class="sr-only">Value:</label> <input class="form-control" type="text" id="newValue" name="newValue" placeholder="Value" />
	
</div>
<button class="btn btn-primary shadow mb-2" type="submit">Add</button>
<input type="hidden" id="subject" name="subject" value="tt" />

</form>
</div>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
<table class="row-border" id="gtable">

	<thead>
		<tr>
			<th>Description</th>
			<th>Value</th>
			<th>Action</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Description</th>
			<th>Value</th>
			<th></th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		$query = "SELECT * FROM `$table` WHERE `clientid` = '$clientid'";
		
		$result = mysqli_query($link, $query); 
		while($row = mysqli_fetch_array($result)) { 
			echo '<tr><td data-label="Description" id="tdid'.$row['id'].'"><span id="desc'.$row['id'].'">'.htmlspecialchars($row["description"]).'</span></td><td data-label="Value" id="tdidV'.$row['id'].'"><span id="value'.$row['id'].'">'.$row['value'].'</span></td><td data-label="Action"> <span class="actionicon" id="edit'.$row['id'].'"><i class="fa fa-edit"></i> </span> - <span class="actionicon" id="del'.$row['id'].'"><i class="fas fa-trash-alt"></i></span></td></tr>';  
		}
		?>
</tbody>
</table>
			</div>
		</div>
	</div>
</div>

<div class="populateDivGenDelete" id="populateDivGen">
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
<div class="populateDivGenEdit" id="populateDivGenEdit">
	<div class="container-fluid">
		<div class="mb-3">
			<input class="form-control" type="text" value="" id="updatedvalue" />
		</div>
		<div class="mb-3">
			<input class="form-control" type="text" value="" id="updatedvalueV" />
		</div>
		<div class="row">
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary shadow btn-lg btn-block" id="saveBtn">Save</button>
			</div>
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary shadow btn-lg btn-block" id="cancelBtn">Cancel</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#gtable tfoot th').each( function () {
        var title = $(this).text();
		if(title == 'Description' || title == 'Value'){
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





<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>