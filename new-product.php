<?php $page_title = 'Add New Product';
$more_script = '<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script><script type="text/javascript" src="js/popup-requesting-page.js"></script>
<script type="text/javascript" src="js/form-validation.js"></script>';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<h3 class="page-header"><?php echo $page_title; ?></h3>
<?php
function getSelectItemsSimple($link, $tbl, $clientid){
	$options = '<option></option>';
	$descCol = 'description';
	if($tbl == 'supplier'){$descCol = 'name';}
	$result = mysqli_query($link, "SELECT `id`, `$descCol` FROM `$tbl` WHERE `clientid` = '$clientid' ORDER BY `$descCol` ASC");
	
	while($row=mysqli_fetch_array($result)){
		$options .= '<option value="'.$row['id'].'">'.htmlspecialchars($row[$descCol]).'</option>';
	}
	return $options;
}

$code_return = '1000';
$stmt = $link->prepare("SELECT MAX(`cert_code`)as mx FROM `grocery_products` WHERE `clientid` = '$clientid'");
$stmt->execute();
$stmt->bind_result($sv);
while ($stmt->fetch()) {$settingvalue = $sv;}
$stmt->close();
if(!empty($settingvalue)){
	if (is_numeric($settingvalue)){
		$code_return = $settingvalue + 1;
	}
	
}
	$roundformat = '4';
	$query = "SELECT `setting_value` FROM `settings` WHERE `clientid` = '$clientid' AND `setting_name` = 'round_number_format'";
	$stmt = $link->prepare($query);
	$stmt->execute();
	$stmt->bind_result($vl);
	$stmt->fetch();
	$stmt->close();
	$roundformat = $vl;

	
$found = 'false';
$size_unit = ''; 
	$description = ''; 
	$Pack = ''; 
	$size_amount = ''; 
	$package = ''; 
	$normal_price = ''; 
	$case_price = ''; 
	$cost = ''; 
	$case_cost = ''; 
	$weight_case = ''; 
	$weight_unit = ''; 
	$memo = ''; 
	$supplier = ''; 
	$department = ''; 
	$sub_department = ''; 
	$category = ''; 
	$brand = '';
	$tax_id = '';
if(isset($_GET['clone']) && !empty($_GET['clone'])){
	$uniqueid = $_GET['clone'];
	
	

	$query="SELECT `size_unit`, `description`, `Pack`, `size_amount`, `package`, `normal_price`, `case_price`, `cost`, `case_cost`, `weight_case`, `weight_unit`, `memo`, `supplier`, `department`, `sub_department`, `category`, `brand`, `tax_id` FROM `grocery_products` WHERE `uniqueid` = ? AND `clientid` = ?";
	
	
	$stmt = $link->prepare($query);
	$stmt->bind_param('ss', $uniqueid, $clientid);
	
	$stmt->execute();
	$stmt->bind_result($size_unitV, $descriptionV, $PackV, $size_amountV, $packageV, $normal_priceV, $case_priceV, $costV, $case_costV,$weight_caseV, $weight_unitV, $memoV, $supplierV, $departmentV, $sub_departmentV, $categoryV, $brandV, $tax_idV);
	 //switch to false when done testing
	while ($stmt->fetch()) {
		$found = 'true';
		$size_unit = $size_unitV; 
		$description = $descriptionV; 
		$Pack = $PackV; 
		$size_amount = $size_amountV; 
		$package = $packageV; 
		$normal_price = $normal_priceV; 
		$case_price = $case_priceV; 
		$cost = $costV; 
		$case_cost = $case_costV; 
		$weight_case = $weight_caseV; 
		$weight_unit = $weight_unitV; 
		$memo = $memoV; 
		$supplier = $supplierV; 
		$department = $departmentV; 
		$sub_department = $sub_departmentV; 
		$category = $categoryV; 
		$brand = $brandV; 
		$tax_id = $tax_idV;
		
	}
	
}	
	
	
	
	
$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<div class="alert alert-danger" role="alert">Item code and description fields are required.</div>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<div class="alert alert-success" role="alert">Successfully Added.</div>';}
?>


<!-- open container -->
<div class="container-fluid">
<div class="row mb-2">
		<div class="col">
			<?php echo $products_links; ?>
		</div>
	</div>
<!-- open row -->
	<div class="row">
	<!-- open col -->
	<div class="col-12 col-md-2">
		<div class="card">
			<div class="card-body">
				<nav id="products-nav" class="navbar navbar-light bg-light">
					<nav class="nav nav-pills flex-column">
						<a class="navbar-brand" href="#">Jumb to</a>
						<a class="nav-link" href="#item-1">About</a>
						<a class="nav-link" href="#item-2">Info</a>
						<a class="nav-link" href="#item-3">Section</a>
						<a class="nav-link" href="#item-4">Supplier</a>
						<a class="nav-link" href="#item-5">Inventory</a>
						<a class="nav-link" href="#item-4-a">Promotion</a>
						<a class="nav-link" href="#item-6">Allowance</a>
						<a class="nav-link" href="#item-7">Other</a>
					</nav>
				</nav>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-10">
	
		<div class="card scrollable-card" style="max-height: 81vh !important;">
		
			<div class="card-body">
				<div class="right-scroll" data-spy="scroll" data-target="#products-nav" data-offset="100" style="max-height: 76vh !important;">
				<?php echo $responseMsg; ?>
				<form  id="productform" action="php-scripts/process-new-product.php" method="post" autocomplete="off">
					<input autocomplete="false" name="hidden" type="text" style="display:none;">
			
				<h4 id="item-1">About</h4>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="cert_code">Item Code: *</label>
						<input class="form-control" type="text" id="cert_code" value="<?php echo $code_return; ?>" name="cert_code" autocomplete="off"/>
					</div>
					<div class="col-md-6 mb-3">
						<label for="cert_code">UPC: </label>
						<input class="form-control" type="text" id="upc"  name="upc" autocomplete="off"/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="brand">Brand:</label>
						<select class="form-control" id="brand" name="brand"><?php if ($found=='true'){echo getValue($link, $clientid, 'brands', $brand);} ?></select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="description">Description: *</label>
						<input class="form-control"  type="text" id="description" name="description" value="<?php if ($found=='true'){echo htmlspecialchars($description);} ?>"/>
					</div>
				</div>
				
				<hr class="mb-4">
				<h4 id="item-2">Product Info</h4>
				<div class="row">
					<div class="col-md-4 mb-3">
						<label for="case-barcode">Case Code:</label>
						<input class="form-control"  type="text" id="case-barcode" name="case-barcode"/>
					</div>
					<div class="col-md-4 mb-3">
						<label for="size_amount">Size: <span class="ex55">Number Only</span></label>
						<input class="form-control" type="number" min="0" step="0.01" id="size_amount" name="size_amount" value="<?php if($found=='true'){echo htmlspecialchars($size_amount);} ?>"/>
					</div>
					<div class="col-md-4 mb-3">
						<label for="size_unit">Size Unit:</label>
						<select class="form-control" id="size_unit" name="size_unit"><?php if($found=='true'){echo getValue($link, $clientid, 'weight_units', $size_unit);}else{echo getSelectItemsSimple($link, 'weight_units', $clientid);} ?></select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 mb-3">
						<label for="Pack">Pack:</label>
						<input class="form-control" type="number" min="0" id="Pack" name="Pack" value="<?php if($found=='true'){echo htmlspecialchars($Pack);} ?>"/>
					</div>
					<div class="col-md-4 mb-3">
						<label for="case_cost">Cost:</label>
						<input class="form-control" type="number" min="0" step="0.01" id="case_cost" name="case_cost" value="<?php if($found=='true'){ echo htmlspecialchars($case_cost);} ?>"/>
					</div>
					<div class="col-md-4 mb-3">
						<label for="case_price">Retail Price:</label>
						<div class="input-group">
							<input class="form-control" type="number" min="0" step="0.01" id="case_price" name="case_price" value="<?php if($found=='true') {echo htmlspecialchars($case_price); }?>"/>
							<div class="input-group-append">
								<button type="button" class="btn btn-primary shadow btn-sm" id="calccaseprice">Calculate</button>
							</div>
						</div>
					</div>
				</div>
				
				
				
				<hr class="mb-4">
				<h4 id="item-3">Section</h4>
				<div class="row">
					<div class="col-md-4 mb-3">
						<label for="department">Department:</label>
						<select class="form-control" id="department" name="department"><?php if($found=='true'){echo getValue($link, $clientid, 'department', $department);} ?></select>
					</div>
					<div class="col-md-4 mb-3">
						<label for="sub_department">Sub Department:</label>
						<select class="form-control"  id="sub_department" name="sub_department"><?php if($found=='true'){echo getValue($link, $clientid, 'sub_department', $sub_department);} ?></select>
					</div>
					<div class="col-md-4 mb-3">
						<label for="category">Category:</label>
						<select class="form-control"  id="category" name="category"><?php if($found=='true'){echo getValue($link, $clientid, 'category', $category);} ?></select>
					</div>
				</div>
				
				<hr class="mb-4">
				<h4 id="item-4">Supplier Info</h4>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="supplier_code">Supplier Item Code:</label>
						<input class="form-control" type="text" id="supplier_code" name="supplier_code" />
					</div>
					<div class="col-md-6 mb-3">
						<label for="supplier">Supplier Name:</label>
						<select class="form-control" id="supplier" name="supplier"><?php  if($found=='true'){ echo getValue($link, $clientid, 'supplier', $supplier); } ?></select>
					</div>
				</div>
				
				<hr class="mb-4">
				<h4 id="item-5">Inventory</h4>
				<div class="mb-3">
					<label for="QtyOnHand">Quantity on Hand:<span class="ex55">(cases)</span></label>
					<input class="form-control" type="number" min="0" id="QtyOnHand" name="QtyOnHand"/>
				</div>
				<hr class="mb-4">
				<h4 id="item-4-a">Promotion</h4>
				<div class="row">
					<div class="col-md-6 mb-3 pl-4">
						<div class="custom-control custom-switch">
							<input class="custom-control-input" type="checkbox" id="on_special" name="on_special">
							<label class="custom-control-label" for="on_special">On Special</label>
						</div>
					</div>
				</div>
				<div class="row" id="on_special_row" style="display:none">
					<div class="col-md-2 mb-3">
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="special_option" id="on_going_special" value="option1" checked>
						  <label class="form-check-label" for="on_going_special">Ongoing </label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="special_option" id="dated_special" value="option2">
							<label class="form-check-label" for="dated_special">Custom Date</label>
						</div>
					</div>
					<div class="col-md-5 mb-3">
						<div class="mb-3" id="special_start_div" style="display:none">
							<label for="special_start">Start Date</label>
							<input class="form-control" type="date" id="special_start" name="special_start" value="<?php echo date('Y-m-d') ?>"/>
						</div>
					</div>
					<div class="col-md-5 mb-3">
						<div class="mb-3" id="special_end_div" style="display:none">
							<label for="special_end">Start End</label>
							<input class="form-control" type="date" id="special_end" name="special_end" value="<?php echo date('Y-m-d') ?>"/>
						</div>
					</div>
				</div>
				<div class="row" id="row_special_price" style="display:none">
					<div class="col-md-6 mb-3">
						<label for="special_price">Special Price:</label>
						<input class="form-control" type="number" min="0" step="0.01" id="special_price" name="special_price"/>
						</div>
				</div>	
				<div class="row">
					<div class="col-md-6 mb-3 pl-4">
						<div class="custom-control custom-switch">
							<input class="custom-control-input" type="checkbox" id="push_item" name="push_item">
							<label class="custom-control-label" for="push_item">Push Product</label>
						</div>
					</div>
				</div>
				<div class="row" id="row_push_reason" style="display:none">
					<div class="col-md-6 mb-3">
						<label for="push_reason">Push Reason</label>
						<input class="form-control" type="text"  id="push_reason" name="push_reason"/>
						</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="special_batch">Special Batch:</label>
						<select class="form-control select2" id="special_batch" name="special_batch"><?php if($found=='true'){echo getValue($link, $clientid, 'special_batch', $special_batch);} ?></select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="push_batch">Push Batch</label>
						<select class="form-control select2"  id="push_batch" name="push_batch"><?php if($found=='true'){echo getValue($link, $clientid, 'push_batch', $push_batch);} ?></select>
					</div>
					
				</div>
				
				<hr class="mb-4">
				<h4 id="item-6">Price Allowance</h4>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="lowest_allowed">Lowest Allowed</label>
						<input class="form-control" type="number" step="0.01" min="0" id="lowest_allowed" name="lowest_allowed" />
					</div>
					<div class="col-md-6 mb-3">
						<label for="highest_allowed">Highest Allowed</label>
						<input class="form-control" type="number" step="0.01" min="0" id="highest_allowed" name="highest_allowed" />
					</div>
				</div>
				
							
				
				<hr class="mb-4">
				<h4 id="item-7">Other</h4>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="package">Package:</label>
						<select class="form-control" id="package" name="package"><?php  if($found=='true'){echo getValue($link, $clientid, 'packages', $package);} ?></select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="memo">Keywords:<span class="ex55">(seperate by space)</span></label>
						<input class="form-control" type="text" id="memo" name="memo" value="<?php if($found=='true'){echo htmlspecialchars($memo);} ?>"/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="weight_case">Case Weight:</label>
						<input class="form-control" type="number" min="0" step="0.01" id="weight_case" name="weight_case" value="<?php if($found=='true'){ echo htmlspecialchars($weight_case);} ?>"/>
					</div>
					<div class="col-md-6 mb-3">
						<label for="weight_unit">Weight Unit:</label>
						<select class="form-control" id="weight_unit" name="weight_unit">
							<option></option>
							<option <?php if($weight_unit == 'LB'){echo 'selected';} ?>>LB</option>
							<option <?php if($weight_unit == 'KG'){echo 'selected';} ?>>KG</option>
						</select>
					</div>
				</div>
				
				<div class="row">
				<div class="col-md-6 mb-3">
					<label for="tax_id" >Tax:</label>
					<select class="form-control" id="tax_id" name="tax_id"><?php echo getValue($link, $clientid, 'product_tax_types', $tax_id); ?>
					</select>
				</div>
				<div class="col-md-6 mb-3">
					<label for="cases_on_pallet" >Cases on Pallet:</label>
					<input type="number" class="form-control" id="cases_on_pallet" name="cases_on_pallet" />
				</div>
			</div>
				
				<hr class="mb-4">
				<div class="row">
					<div class="col-md-6 mb-3">
						<button class="btn btn-primary shadow btn-lg btn-block" type="submit"> Save</button>
					</div>
					<div class="col-md-6 mb-3">
						<button class="btn btn-primary shadow btn-lg btn-block"  name="sac" type="submit">Save and Copy</button>
					</div>
				</div>
		<input type="hidden" id="poprequester" value="" />
		</form>
			</div>
			
			<!-- card body ends here -->
			</div>
		</div>
		</div>
		<!-- close col -->
		</div>
	<!-- close row -->
	</div>
<!-- close container -->
</div>
<div class="populateDiv" id="popBrand"></div>
<input type="hidden" value="<?php echo $roundformat; ?>" id="roundformat" />
<div class="populateDivGen" id="calculateprice">
	<div class="container-fluid">
		<div class="row">
			<!-- open col -->
			<div class="col">
				<div class="row">
					<div class="col-md-6 mb-3">
						<label>Pack:</label>
						<input class="form-control" type="number" min="1" id="PackDP" disabled/>
					</div>
					<div class="col-md-6 mb-3">
						<label>Case Cost:</label>
						<input class="form-control" type="number" min="1" step="0.01" id="case_costDP" disabled/>
					</div>
				</div>
				<hr class="mb-4">
				<h4>Case Retail</h4>
				<div class="mb-3">
						<label>Margin Desired:<span class="ex55">Ex.: Enter 35 for 35%</span></label>
						<div class="input-group">
							<input class="form-control"  type="number" min="0.01" step="0.01" id="margindesired" />
							<div class="input-group-append">
								<button type="button" class="btn btn-primary shadow btn-sm" id="applymrgcase">Apply</button>
							</div>
						</div>
					</div>
					
					<div class="mb-3">
						<label>Retail Price</label>
						<input class="form-control"  type="number" min="1" step="0.01" id="caseretaildesired" />
					</div>
				
				
				<hr class="mb-4">
				<div class="row">
					<div class="col-md-6 mb-3">
						<button class="btn btn-primary shadow btn-lg btn-block" id="cancelcalcprice" type="button">Cancel</button>
					</div>
					<div class="col-md-6 mb-3">
						<button class="btn btn-primary shadow btn-lg btn-block" id="donecalcprice" type="button">Done</button>
					</div>
				</div>
				
			<!-- close col -->
			</div>
		<!-- close row -->
		</div>
	<!-- close container -->
	</div>
<!-- close Popup div -->
</div>
<script>
$( document ).ready(function() {

$("#on_special").on('change', function() {
    if ($(this).is(':checked')) {
        $('#on_special_row').show();
        $('#row_special_price').show();
		
    }
    else {
       $('#on_special_row').hide();
       $('#row_special_price').hide();
    }
});
$("#push_item").on('change', function() {
    if ($(this).is(':checked')) {
        $('#row_push_reason').show();
        
		
    }
    else {
       $('#row_push_reason').hide();
      
    }
});
$(document).on('change', '[type="radio"]', function() {
    var checked_option = $(this).val();

    if(checked_option == 'option2'){
		$('#special_start_div').show();
		$('#special_end_div').show();
	}
	 if(checked_option == 'option1'){
		$('#special_start_div').hide();
		$('#special_end_div').hide();
	}
});
	
	
	
});


</script>
<?php 
function getValue($link, $clientid, $table, $id){
	$vl = '';
	$options = '<option></option>';
	$descColumn = 'description';
	if ($table == 'supplier'){$descColumn = 'name';}
	$query = "SELECT `id`, `$descColumn` FROM `$table` WHERE `clientid` = ?";
	
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $clientid);
	$stmt->execute();
	$stmt->bind_result($idd, $vl);
	while($stmt->fetch()){
		$selected = '';
		if ($idd == $id){$selected = ' selected';}
		$options .= '<option value="'.$idd.'" '.$selected.'>'.htmlspecialchars($vl).'</option>';
	}
	
	return $options;
}
?>





<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>