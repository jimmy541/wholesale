<?php $page_title = 'New Push Batch';
$more_css = '';
$more_script = '<script type="text/javascript" src="js/form-validation.js"></script>';
?>

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<?php
	

	
$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<div class="alert alert-danger" role="alert">Item code and description fields are required.</div>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<div class="alert alert-success" role="alert">Successfully Added.</div>';}
?>

<div class="container-fluid">
<!-- open row -->
	<div class="row">
	<!-- open col -->
	<div class="col">
<div class="card">
			<div class="card-body">
<?php echo $responseMsg; ?>

<form  id="new-special-batch" action="php-scripts/process-new-push-batch.php" method="post">

	
		
		<div class="row">
			<div class="col-md-6 mb-3">
				<label for="description">Description</label>
				<input class="form-control"  type="text" id="description" name="description" />
			</div>
			
		</div>
		
			<hr class="mb-4">
		
			
		<div class="row">
			<div class="col-md-6 mb-3">
				<label for="start_date">Start Date</label>
				<input class="form-control"  type="date" id="start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>"/>
			</div>
			<div class="col-md-6 mb-3">
				<label for="end_date">End Date</label>
				<input class="form-control" type="date" id="end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>"/>
			</div>
		</div>
		<div class="mb-3">
			<button class="btn btn-primary shadow btn-lg btn-block" type="submit">Create</button>
		</div>
</form>
</div>
</div>
<!-- close col -->
		</div>
<!-- close row -->
	</div>
<!-- close container -->

</div>

<?php
$additional_script = ''; ?>




<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>