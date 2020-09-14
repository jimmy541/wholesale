<?php $page_title = 'Edit Product';
$more_script = '<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script><script type="text/javascript" src="js/popup-requesting-page.js"></script>
<script type="text/javascript" src="js/form-validation.js"></script>';
include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php");
echo '<h3 class="page-header">'.$page_title.'</h3>';

$roundformat = '4';
	$query = "SELECT `setting_value` FROM `settings` WHERE `clientid` = '$clientid' AND `setting_name` = 'round_number_format'";
	$stmt = $link->prepare($query);
	$stmt->execute();
	$stmt->bind_result($vl);
	$stmt->fetch();
	$stmt->close();
	$roundformat = $vl;

$found = 'false';
if(isset($_GET['product']) && !empty($_GET['product'])){
	$uniqueid = $_GET['product'];
	$cert_code = '';
	$upc = '';
	$case_barcode = ''; 
	$size_unit = ''; 
	$description = ''; 
	$Pack = ''; 
	$size_amount = ''; 
	$QtyOnHand = ''; 
	$package = ''; 
	$normal_price = ''; 
	$case_price = ''; 
	$cost = ''; 
	$case_cost = ''; 
	$weight_case = ''; 
	$weight_unit = ''; 
	$memo = ''; 
	$supplier = ''; 
	$supplier_code = ''; 
	$department = ''; 
	$sub_department = ''; 
	$category = ''; 
	$brand = ''; 
	$active = '';
	$checked = 'no';
	$tax_id = '';
	$lowest_allowed = '';
	$highest_allowed = '';
	$cases_on_pallet = '';
$on_special = '';
$special_start = '';
$special_end = '';
$special_price = '';
$special_batch = '';
$push_item = '';
$push_reason = '';
$push_batch = '';
	$cloneunique = '';
	$clean_uniqueid = '';

	$query="SELECT `cert_code`, `upc`, `case_barcode`, `size_unit`, `description`, `Pack`, `size_amount`, `QtyOnHand`, `package`, `normal_price`, `case_price`, `cost`, `case_cost`, `weight_case`, `weight_unit`, `memo`, `supplier`, `supplier_code`, `department`, `sub_department`, `category`, `brand`, `active`, `tax_id`, `lowest_allowed`, `highest_allowed`,`cases_on_pallet`,`on_special`,`special_start`,`special_end`,`special_price`,`special_batch`,`push_item`,`push_reason`,`push_batch` FROM `grocery_products` WHERE `uniqueid` = ? AND `clientid` = ?";
	
	
	$stmt = $link->prepare($query);
	$stmt->bind_param('ss', $uniqueid, $clientid);
	
	$stmt->execute();
	$stmt->bind_result($certcodeV, $upcV, $case_barcodeV, $size_unitV, $descriptionV, $PackV, $size_amountV, $QtyOnHandV, $packageV, $normal_priceV, $case_priceV, $costV, $case_costV,$weight_caseV, $weight_unitV, $memoV, $supplierV, $supplier_codeV, $departmentV, $sub_departmentV, $categoryV, $brandV, $activeV, $tax_idV, $lowest_allowedV, $highest_allowedV,$cases_on_palletV, $on_specialV, $special_startV, $special_endV, $special_priceV, $special_batchV, $push_itemV, $push_reasonV, $push_batchV);
	 //switch to false when done testing
	while ($stmt->fetch()) {
		$found = 'true';
		$cert_code = $certcodeV;
		$upc = $upcV;
		$case_barcode = $case_barcodeV; 
		$size_unit = $size_unitV; 
		$description = $descriptionV; 
		$Pack = $PackV; 
		$size_amount = $size_amountV; 
		$QtyOnHand = $QtyOnHandV; 
		$package = $packageV; 
		$normal_price = $normal_priceV; 
		$case_price = $case_priceV; 
		$cost = $costV; 
		$case_cost = $case_costV; 
		$weight_case = $weight_caseV; 
		$weight_unit = $weight_unitV; 
		$memo = $memoV; 
		$supplier = $supplierV; 
		$supplier_code = $supplier_codeV; 
		$department = $departmentV; 
		$sub_department = $sub_departmentV; 
		$category = $categoryV; 
		$brand = $brandV; 
		$active = $activeV;
		$tax_id = $tax_idV;
		$lowest_allowed = $lowest_allowedV;
		$highest_allowed = $highest_allowedV;
		$cases_on_pallet = $cases_on_palletV;
	$on_special = $on_specialV;
	$special_start = $special_startV;
	$special_end = $special_endV;
	$special_price = $special_priceV; 
	$special_batch = $special_batchV; 
	$push_item = $push_itemV; 
	$push_reason = $push_reasonV; 
	$push_batch = $push_batchV;
		$cloneunique = $uniqueid;
		$clean_uniqueid = $uniqueid;
		
	}
	if($active == 'yes'){$checked = 'yes';}
}
if ($found == 'true'){?>

<?php 

		$uploaderror = '';
		
		if (isset($_GET['uploaderror']) && !empty($_GET['uploaderror'])){
		$uploaderror = '';
		
			if ($_GET['uploaderror'] == '1'){
			$uploaderror = '<div class="alert alert-danger" role="alert">Invalid image format</div>'; //File is not an image
			}
			if ($_GET['uploaderror'] == '2'){
			$uploaderror = '<div class="alert alert-danger" role="alert">Image size cannot exceed: 1 MB </div>'; //File is too large
			}
			if ($_GET['uploaderror'] == '3'){
			$uploaderror = '<div class="alert alert-danger" role="alert">Image upload failed.</div>'; //error uploading the file
			}
		
		}

?>

<?php
$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<div class="alert alert-danger" role="alert">Item code and description fields are required.</div>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<div class="alert alert-success" role="alert">Successfully Added.</div>';}
?>



<div class="container-fluid">
<!-- open row -->
	<div class="row mb-2">
		<div class="col">
			<?php echo $products_links; ?>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col">
			<form action="new-product.php"><button type="submit" class="btn btn-primary shadow float-right ml-2">New Product</button></form>
			<form action="new-product.php"><input type="hidden" value="<?php echo $cloneunique; ?>" name="clone"><button type="submit" class="btn btn-primary shadow float-right ml-2">Copy</button></form>
			
		</div>
	</div>
	<div class="row mb-2">
	<!-- open col -->
	<div class="col col-md-2">
		<div class="row">
			<div class="col">
			
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
								<a class="nav-link" href="#item-6">Allowance</a>
								<a class="nav-link" href="#item-7">Other</a>
							</nav>
						</nav>
					</div>	
				</div>
			
			</div>
		
		</div>
		<div class="row">
			<div class="col">
				<div class="card" style="cursor:pointer;" id="change-profile-image" style="cursor:pointer">
		<div class="card-body">
		<h4>Image</h4>

		<?php echo $uploaderror; ?>
			<?php
			$row=mysqli_fetch_array(mysqli_query($link, "SELECT `image-id` FROM `grocery_products` WHERE `uniqueid` = '$clean_uniqueid'"));
			if ($row['image-id'] != ''){
				echo '<img class="card-img-top" src="pics/'.$row['image-id'].'" />';
			}?>
			
				<p class="card-text text-center">Click to change</p>
			</div>
		</div>
			</div>
		</div>
	
	</div>
	<div class="col col-md-10">
		<div class="card" scrollable-card" style="max-height: 69vh !important;">
			<div class="card-body">
			<div class="right-scroll" data-spy="scroll" data-target="#products-nav" data-offset="100" style="max-height: 65vh !important;">
				<form  id="newproduct" action="php-scripts/process-edit-product.php" method="post" autocomplete="off">
		<input class="form-control" autocomplete="false" type="hidden" name="productid" value="<?php echo htmlspecialchars($clean_uniqueid); ?>">
		<?php echo $responseMsg; ?>
			
				<h4 id="item-1">About</h4>
				<div class="custom-control custom-switch">
					<input class="custom-control-input" type="checkbox" id="active" name="active" <?php if($checked=='yes'){echo 'checked';} ?>>
					<label class="custom-control-label" for="active">Active</label>
				</div><br>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="">Item Code: *</label><input class="form-control"  type="text" id="cert_code" name="cert_code" value="<?php echo htmlspecialchars($cert_code); ?>" autocomplete="off" required/>
					</div>
					<div class="col-md-6 mb-3">
						<label for="">UPC:</label><input class="form-control"  type="text" id="upc" name="upc" value="<?php echo htmlspecialchars($upc); ?>" autocomplete="off"/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="">Brand:</label>
						<select class="form-control"  id="brand" name="brand"><?php echo getValue($link, $clientid, 'brands', $brand); ?></select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="">Description: *</label><input class="form-control"  type="text" id="description" name="description" value="<?php echo htmlspecialchars($description); ?>"/>
					</div>
				</div>
				
				<hr class="mb-4">
				<h4 id="item-2">Product Info</h4>
				<div class="row">
					<div class="col-md-4 mb-3">
					
						<label for="">Case Code:</label>
						<input class="form-control"  type="text" id="case-barcode" name="case-barcode" value="<?php echo htmlspecialchars($case_barcode); ?>"/>
					</div>
					<div class="col-md-4 mb-3">
						<label for="">Size: <span class="ex55">Number Only</span></label>
						<input class="form-control"  type="number" min="0" step="0.01" id="size_amount" name="size_amount" value="<?php echo htmlspecialchars($size_amount); ?>"/>
					</div>
					<div class="col-md-4 mb-3">
						<label for="" >Size Unit:</label>
						<select class="form-control" id="size_unit" name="size_unit" ><?php echo getValue($link, $clientid, 'weight_units', $size_unit); ?></select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 mb-3">
						<label for="">Pack:</label>
						<input class="form-control" type="number" min="0" id="Pack" name="Pack" value="<?php echo htmlspecialchars($Pack); ?>"/>
					</div>
					<div class="col-md-4 mb-3">
						<label for="" >Cost:</label>
						<input class="form-control" type="number" min="0" step="0.01" id="case_cost" name="case_cost" value="<?php echo htmlspecialchars($case_cost); ?>"/>
					</div>
					<div class="col-md-4 mb-3">
						<label for="">Retail Price:</label>
						<div class="input-group">
							<input class="form-control" type="number" min="0" step="0.01" id="case_price" name="case_price" value="<?php echo htmlspecialchars($case_price); ?>"/>
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
						<label for="">Department:</label>
						<select class="form-control"  id="department" name="department" ><?php echo getValue($link, $clientid, 'department', $department); ?></select>
					</div>
					<div class="col-md-4 mb-3">
						<label for="">Sub Department:</label>
						<select class="form-control"   id="sub_department" name="sub_department"><?php echo getValue($link, $clientid, 'sub_department', $sub_department); ?></select>
					</div>
					<div class="col-md-4 mb-3">
						<label for="">Category:</label>
						<select class="form-control"   id="category" name="category"><?php echo getValue($link, $clientid, 'category', $category); ?></select>
					</div>
				</div>
				
				<hr class="mb-4">
				<h4 id="item-4">Supplier Info</h4>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="">Supplier Item Code:</label>
						<input class="form-control"  type="text" id="supplier_code" name="supplier_code" value="<?php echo htmlspecialchars($supplier_code); ?>"/>
					</div>
					<div class="col-md-6 mb-3">
						<label for="">Supplier Name:</label>
						<select class="form-control" id="supplier" name="supplier"><?php echo getValue($link, $clientid, 'supplier', $supplier); ?></select>
					</div>
				</div>
				<hr class="mb-4">
				<h4 id="item-5">Inventory</h4>
				<div class="mb-3">
					<label for="">Quantity on Hand:</label>
					<input class="form-control" type="number" min="0" id="QtyOnHand" name="QtyOnHand" value="<?php echo htmlspecialchars($QtyOnHand); ?>"/>
				</div>
				
				<hr class="mb-4">
					<h4 id="item-6">Price Allowance</h4>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="lowest_allowed">Lowest Allowed</label>
							<input class="form-control" type="number" step="0.01" min="0" id="lowest_allowed" name="lowest_allowed" value="<?php echo htmlspecialchars($lowest_allowed); ?>"/>
						</div>
						<div class="col-md-6 mb-3">
							<label for="highest_allowed">Highest Allowed</label>
							<input class="form-control" type="number" step="0.01" min="0" id="highest_allowed" name="highest_allowed" value="<?php echo htmlspecialchars($highest_allowed); ?>"/>
						</div>
					</div>
				
				<hr class="mb-4">
				<h4 id="item-7">Other</h4>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="">Package:</label>
						<select class="form-control" id="package" name="package"><?php echo getValue($link, $clientid, 'packages', $package); ?>
						</select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="">Keywords:<span class="ex55">(seperate by space)</span></label>
						<input class="form-control" type="text" id="memo" name="memo" value="<?php echo htmlspecialchars($memo); ?>"/>
					</div>
				</div>
					
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="">Case Weight:</label>
						<input class="form-control" type="number" min="0" step="0.01" id="weight_case" name="weight_case" value="<?php echo htmlspecialchars($weight_case); ?>"/>
					</div>
					<div class="col-md-6 mb-3">
						<label for="" >Weight Unit:</label>
						<select class="form-control" id="weight_unit" name="weight_unit">
							<option></option>
							<option <?php if($weight_unit == 'LB'){echo 'selected';} ?>>LB</option>
							<option <?php if($weight_unit == 'KG'){echo 'selected';} ?>>KG</option>
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="" >Tax:</label>
						<select class="form-control" id="tax_id" name="tax_id"><?php echo getValue($link, $clientid, 'product_tax_types', $tax_id); ?>
						</select>
					</div>
					<div class="col-md-6 mb-3">
					<label for="cases_on_pallet" >Cases on Pallet:</label>
					<input type="number" class="form-control" id="cases_on_pallet" name="cases_on_pallet" value="<?php echo htmlspecialchars($cases_on_pallet); ?>"/>
				</div>
				</div>
				
				
				<hr class="mb-4">
				<div class="mb-4 pb-5">
					<button class="btn btn-primary shadow btn-lg btn-block" type="submit">Save</button>
				</div>
				
		<input type="hidden" id="poprequester" value="" />
		</form>
			</div>
			</div>
		</div>
	<!-- close col -->
	</div>
	<!-- close row -->
	</div>
<!-- close container -->
</div>
<form name= "uploadform" action="upload-product-image.php" id="uploadform" method="post" enctype="multipart/form-data">
			   
			    <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" style="display:none;" onchange="javascript:this.form.submit();">
				<input class="form-control" type="hidden" name="image-id" value="<?php echo htmlspecialchars($clean_uniqueid); ?>" />
			    <input class="form-control" type="submit" value="Upload Image" name="submitbtn" style="display:none;">
				</form>

<div class="populateDiv" id="popBrand"></div>
<?php }else{
	echo 'oops!!! this page does not exist.';
}

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

<input class="form-control" type="hidden" value="<?php echo $roundformat; ?>" id="roundformat" />
<div class="populateDivGen" id="calculateprice"">
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
						<label for="" >Case Cost:</label>
						<input class="form-control" type="number" min="1" step="0.01" id="case_costDP" disabled/>
					</div>
				</div>
				
				<hr class="mb-4">
				<="mb-3">Case Retail</h4>
				
				<div class="mb-3">
					<label for="">Margin Desired:<span class="ex55">Ex.: Enter 35 for 35%</span></label>
					<div class="input-group">
						<input class="form-control"  type="number" min="0.01" step="0.01" id="margindesired" />
						<div class="input-group-append">
							<button type="button" class="btn btn-primary shadow btn-sm" id="applymrgcase">Apply</button>
						</div>
					</div>
				</div>
				<div class="mb-3">
					<label for="">Retail Price</label>
					<input class="form-control" type="number" min="1" step="0.01" id="caseretaildesired" />
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
</div>

<script>
$("#change-profile-image").click(function () {
	
    $("#fileToUpload").trigger('click');
});
</script>


<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>