<div id="gray-background"></div>
<?php
if(!empty($clientid)){
	$only_assigned_query = '';
							if($role == 'Sales Representative' || $role == 'Backend Operator'){
								if($show_assigned_customers_only == '1'){
									$only_assigned_query = " AND `salesperson_id` = '$user_id'";
								}
							}
$customer_options = '<option></option>';
$stmt = $link->prepare("SELECT `hashed_id`, `business_name` FROM `customers` WHERE `clientid` = '$clientid' AND `active` = 'yes' $only_assigned_query ORDER BY `business_name` ASC");
$stmt->execute();
$stmt->bind_result($hid, $bn);
while($stmt->fetch()){
	$customer_options .= '<option value="'.$hid.'">'.$bn.'</option>';
}
?>
<div class="populateDivOrderCustomer">
	<div class="container-fluid">
		<!-- open row -->
		<div class="row">
			<!-- open col -->
			<div class="col">
				<div class="mb-3">
					<label for="order-date">Order Date:</label>
					<input type="date" class="form-control" id="order-date" name="order-date" value="<?php echo date('Y-m-d'); ?>" required="required"/>
				</div>
				<div class="mb-3">
					<label for="select-customer">Customer:</label>
					<select class="select-customer form-control" id="select-customer" name="select-customer"><?php echo $customer_options; ?></select>
				</div>
				<div class="mb-3">
					<label>Order Type</label>
					<select class="form-control"  id="select-order-type" name="select-order-type"><option value="invoice">Invoice</option><option value="quote">Quote</option></select>
				</div>
				<div class="mb-3">
					<label>Open orders:</label>
					<select class="form-control" id="select-order" name="select-order"><option>New</option></select>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<button class="btn btn-primary shadow btn-lg btn-block" id="start-order">Start</button>
					</div>
					<div class="col-md-6 mb-3">
						<button class="btn btn-primary shadow btn-lg btn-block" id="cancel-order">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $site_address; ?>js/dashboard-page.js"></script>
<?php
if (isset($more_script)) {
    echo $more_script;
} 
if (isset($additional_script)) {
    echo $additional_script;
} 
?>

<script>
$(document).ready(function() {
	$('.select-customer').css('width', '100%');
    $('.select-customer').select2();
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
</body>
</html>