<?php $page_title = 'New Specials Batch';
$more_script = '<script type="text/javascript" src="js/form-validation.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">';
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
<!-- open row -->
	<div class="row mb-3">
	<!-- open col -->
		<div class="col">
			<div class="card">
				<div class="card-body">
					<?php echo $responseMsg; ?>
					<form  id="new-special-batch" action="php-scripts/process-edit-special-batch.php" method="post">
							<div class="row">
								<div class="col-md-6 mb-3">
							<div class="custom-control custom-switch">
										<input class="custom-control-input" type="checkbox" id="is_active" name="is_active" <?php if($active=='1'){echo 'checked';} ?>>
										<label class="custom-control-label" for="active">Active</label>
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
					<table class="row-border" id="gtable">
						<thead>
							<tr>
								<th>Item Code</th>
								<th>Description</th>
								<th>Size</th>
								<th>Case Price</th>
								<th>Group Quantity</th>
								<th>Group Price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = "SELECT * FROM `special_batch_products` WHERE `clientid` = '$clientid' AND `id` = '$cleanid' ";
							$result = mysqli_query($link, $query); 
							while($row = mysqli_fetch_array($result)) { 
								echo '<tr>
								<td data-label="Item Code">'.htmlspecialchars($row["item_code"]).'</a></td>
								<td data-label="Description">'.htmlspecialchars($row["description"]).'</td>
								<td data-label="Size">'.$row['size'].'</td>
								<td data-label="Case Price">'.$row['single_case_price'].'</td>
								<td data-label="Group Qty">'.$row['group_qty'].'</td>
								<td data-label="Group Price">'.$row['group_case_price'].'</td>
								<td><span class="action-icons"><i class="fas fa-edit"></i><i class="fas fa-trash-alt"></i></span></td>
								</tr>'; 
							}
							?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<!-- close container -->

</div>


<!-- The following div closes the main body div -->
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#gtable').DataTable();
	$('#gtable').parent().addClass('table-responsive');
} );
</script>


<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>