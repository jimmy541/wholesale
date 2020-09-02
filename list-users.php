<?php
$page_title = 'Users';
$more_script = '<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/populateContainers.css">
<script type="text/javascript" src="js/general-list-popup.js"></script>';
require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/header.php');

?>
<br/>

<?php
if(isset($_GET['as'])){
	if($_GET['as'] == '1'){
		echo '<span class="gMessage">Successfully Added</span>';
	}
}
if(isset($_GET['es'])){
	if($_GET['es'] == '1'){
		echo '<span class="gMessage">Successfully Updated</span>';
	}
}
if(isset($_GET['rs'])){
	if($_GET['rs'] == '1'){
		echo '<span class="gMessage">Successfully Removed</span>';
	}
}
 ?>

<br/>
<form action="new-user.php"><button type="submit" class="btn btn-primary shadow btn-lg"">New User</button></form>
<table class="row-border" id="gtable">
<caption>Users</caption>
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
			<td><span class="action-icons"><a href="edit-user.php?user='.$row['uid'].'"><i class="fas fa-edit"></i></a><i id="delete'.$row['uid'].'" class="fas fa-trash-alt"></i></span></td>
			</tr>'; 
		}
		?>
</tbody>
</table>
<script type="text/javascript">
$(document).ready(function() {
    $('#gtable').DataTable();
} );
</script>
<!-- The following div closes the main body div -->
</div>
<input type="hidden" id="subject" name="subject" value="users" />
<div class="populateDivGenDelete" id="populateDivGenCustDel">
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





<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>