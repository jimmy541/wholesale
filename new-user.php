<?php $page_title = 'Add User';
$more_script = '<script type="text/javascript" src="js/form-validation.js"></script>';
//?>

<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<?php
	

	
$responseMsg = '';
if(isset($_GET['error']) && $_GET['error'] == 1){$responseMsg = '<span class="info-message-red">Item code and description fields are required.</span>';}
if(isset($_GET['success']) && $_GET['success'] == 1){$responseMsg = '<span class="info-message-green">Successfully Added.</span>';}
?>
<br />
<div class="container-fluid">
<!-- open row -->
	<div class="row">
	<!-- open col -->
	<div class="col">
<h1>Add new user</h1>
<?php echo $responseMsg; ?>

<form  id="newuserform" action="php-scripts/process-new-user.php" method="post">

	
		<h4 class="mb-3">Login Info</h4>
		<div class="row">
			<div class="col-md-6 mb-3">
				<label for="">Email:*</label>
				<input class="form-control"  type="email" id="email" name="email" readonly onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly'); this.blur();  this.focus();  }" />
			</div>
			<div class="col-md-6 mb-3">
				<label for="">Password:*</label>
				<input class="form-control"  type="password" id="password" name="password" readonly onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly'); this.blur();  this.focus();  }" />
			</div>
		</div>
		
			<hr class="mb-4">
			<h4 class="mb-3">About</h4>
			
		<div class="row">
			<div class="col-md-6 mb-3">
				<label for="">First Name:*</label>
				<input class="form-control"  type="text" id="first_name" name="first_name"/>
			</div>
			<div class="col-md-6 mb-3">
				<label for="">Last Name:*</label>
				<input class="form-control" type="text" id="last_name" name="last_name" />
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 mb-3">
				<label for="">Display Code:*</label>
				<input class="form-control" type="text"  id="display_code" name="display_code" />
			</div>
			<div class="col-md-6 mb-3">
				<label for="">Role:*</label>
				<select class="form-control"   id="user_role" name="user_role">
					<option value="Administrator">Administrator</option>
					<option value="Backend Operator">Backend Operator</option>
					<option value="Sales Representative">Sales Representative</option>
				</select>
			</div>
		</div>
		<hr class="mb-4">
		<h4 class="mb-3">Settings</h4>
	<div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="allow_limited_override" name="allow_limited_override" disabled>
      <label class="form-check-label" for="allow_limited_override">
        Allow Limited Price Override
      </label>
     
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="allow_free_override" name="allow_free_override" disabled>
      <label class="form-check-label" for="allow_free_override">
        Allow Free Price Override
      </label>
     
    </div>
  </div>
		
		<hr class="mb-4">
		<div class="mb-3">
			<button class="btn btn-primary shadow btn-lg btn-block" type="submit">Save</button>
		</div>
	
	

<span style="color:red; font-size:20px;"><?php /*echo $errorMessage;*/ ?></span>
</form>
<!-- close col -->
		</div>
<!-- close row -->
	</div>
<!-- close container -->

</div>


<!-- The following div closes the main body div -->
</div>




<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>