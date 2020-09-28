<?php
$page_title = 'Users';

$more_css = '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">';

$more_script = '<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="js/selected-table.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

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
			<form action="new-user.php"><button type="submit" class="btn btn-primary shadow btn-sm float-right">New User</button></form>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<table class="row-border" id="list_users_php_table1">
						<thead>
							<tr>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Code</th>
								<th>Role</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = "SELECT * FROM `users` WHERE `clientid` = '$clientid' AND `role` <> 'Owner' ";
							$result = mysqli_query($link, $query); 
							while($row = mysqli_fetch_array($result)) { 
								echo '<tr>
								<td data-label="First Name">'.htmlspecialchars($row["first_name"]).'</a></td>
								<td data-label="Last Name">'.htmlspecialchars($row["last_name"]).'</td>
								<td data-label="Display Code">'.$row['display_code'].'</td>
								<td data-label="Role">'.$row['role'].'</td>
								<td><span class="action-icons"><a href="edit-user.php?user='.$row['uid'].'"><i class="fas fa-edit"></i></a><i id="list_users_php_delete'.$row['uid'].'" class="fas fa-trash-alt"></i></span></td>
								</tr>'; 
							}
							?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	

</div>

<input type="hidden" id="subject" name="subject" value="users" />

<!-- Modal -->
<div class="modal fade" id="modal_remove_users" tabindex="-1" role="dialog" aria-labelledby="remove_product_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="remove_product_title">Delete User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
			<div class="row mb-3">
				<div class="col">
					<h6>Are you sure you want to delete the selected user account?</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">No</button>
				</div>
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-primary btn-block" id="list_users_php_yes_btn">Yes</button>
				</div>
			</div>		
		  </div>
      </div>
      
    </div>
  </div>
</div>

<?php
$additional_script = ''; ?>



<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>