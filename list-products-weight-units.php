<?php
$page_title = 'Weight Units';
$more_script = '<style>#gtable_filter{display:none;}</style><script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" href="css/populateContainers.css">
<script type="text/javascript" src="js/popgeneral.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');
$table = 'weight_units';
?>
<?php echo $products_links; ?>
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
<form class="form-inline" action="php-scripts/process-general.php" method="POST" autocomplete="off">
<div class="form-group mx-sm-3 mb-2">
	<label for="newDesc" class="sr-only">Add New:</label> <input class="form-control" type="text" id="newDesc" name="newDesc" placeholder="Add New" />
	
</div>
<button class="btn btn-primary shadow mb-2" type="submit">Add</button>
<input type="hidden" id="subject" name="subject" value="wn" />

</form>
<table class="row-border" id="gtable">
<caption>Weight Units</caption>
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
			echo '<tr><td data-label="Description" id="tdid'.$row['id'].'"><span id="desc'.$row['id'].'">'.htmlspecialchars($row["description"]).'</span></td><td data-label="Action"> <span class="actionicon" id="edit'.$row['id'].'"><i class="fa fa-edit"></i> </span> - <span class="actionicon" id="del'.$row['id'].'"><i class="fas fa-trash-alt"></i></span></td></tr>';  
		}
		?>
</tbody>
</table>
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
		if(title == 'Description'){
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