<?php $page_title = 'Edit Settings';?>
<?php $more_script = '';?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php

$responseMsg = '';
function getValue($link, $clientid, $vlu){
	$vl = '';
	$query = "SELECT `setting_value` FROM `settings` WHERE `clientid` = '$clientid' AND `setting_name` = '$vlu'";
	$stmt = $link->prepare($query);
	$stmt->execute();
	$stmt->bind_result($vl);
	$stmt->fetch();
	return htmlspecialchars($vl);
}
function getToken($link, $clientid, $vlu){
	$vl = '';
	$query = "SELECT `hashed_id` FROM `settings` WHERE `clientid` = '$clientid' AND `setting_name` = '$vlu'";
	$stmt = $link->prepare($query);
	$stmt->execute();
	$stmt->bind_result($vl);
	$stmt->fetch();
	return htmlspecialchars($vl);
}
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<div class="alert alert-danger" role="alert">Please fill out required items</div>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';}
?>
<br />
<div>
<form class="dataentry" action="php-scripts/process-edit-settings.php" method="post" autocomplete="off">
<input autocomplete="false" name="hidden" type="text" style="display:none;">

	<div class="dataentry-group-left">
	<fieldset>
    <legend>Price Rounding</legend>
		<input type="hidden" name="anf1token" value="<?php echo htmlspecialchars(getToken($link, $clientid, 'round_number_format')); ?>" />
		<input type="radio" name="anf1" value="5" id="anf5" class="form-radio" <?php if(getValue($link, $clientid, 'round_number_format') == '5'){ echo 'checked';} ?>><label class="form-radio-label" for="anf1">Round up to nearest whole number</label><br>
		<input type="radio" name="anf1" value="1" id="anf1" class="form-radio" <?php if(getValue($link, $clientid, 'round_number_format') == '1'){ echo 'checked';} ?>><label class="form-radio-label" for="anf1">Nearest whole number</label><br>
		<input type="radio" name="anf1" value="2" id="anf2" class="form-radio" <?php if(getValue($link, $clientid, 'round_number_format') == '2'){ echo 'checked';}?>><label class="form-radio-label" for="anf2">Nearest x.x9</label><br>
		<input type="radio" name="anf1" value="3" id="anf3" class="form-radio" <?php if(getValue($link, $clientid, 'round_number_format') == '3'){ echo 'checked';}?>><label class="form-radio-label" for="anf3">Nearest x.99</label><br>
		<input type="radio" name="anf1" value="4" id="anf4" class="form-radio" <?php if(getValue($link, $clientid, 'round_number_format') == '4'){ echo 'checked';} ?>><label class="form-radio-label" for="anf1">None</label><br>
		
		<div class="group-fields"><button type="submit">Save</button></div>
		<div class="group-fields"><?php if (isset($_GET['partID']) && $_GET['partID'] == '1'){ echo $responseMsg;} ?></div>
		</fieldset>
	</div>

</form>
</div>
<?php 
function ifchecked($link, $clientid, $account_number, $vlu){
	$checked = getValue($link, $clientid,$account_number, $vlu);
	$nv = "";
	if ($checked == 'yes'){
		return "checked";
		
	}else{
		return "";
	}
}
function optionsV($link, $clientid, $account_number, $vlu){
	$selected = getValue($link, $clientid,$account_number, $vlu);
	$x1 = '';
	$x2 = '';
	$x3 = '';
	if ($selected == 'Normal'){$x1 = 'selected';}
	if ($selected == 'Decrease By %'){$x2 = 'selected';}
	if ($selected == 'Decrease By $'){$x3 = 'selected';}
	$options = '<option '.$x1.'>Normal</option>
			<option '.$x2.'>Decrease By %</option>
			<option '.$x3.'>Decrease By $</option>';
		return $options;
}
function plV($link, $clientid, $account_number, $vlu){
	$selected = getValue($link, $clientid,$account_number, 'pricing_level');
	$vl = getValue($link, $clientid,$account_number, 'pricing_level_value');
	$x = '';
	if ($selected == 'Decrease By %' || $selected == 'Decrease By $'){

	$x = '<label>'.$selected.'</label><input type="text" name="dby" value="'.$vl.'">';
	}
		return $x;
}

?>

<!-- The following div closes the main body div -->
</div>




<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>