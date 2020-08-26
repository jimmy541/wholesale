<?php $page_title = 'Backend Clients';
$more_script = '<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="../css/jquery.dataTables.min.css">';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<table class="display compact" id="gtable">
<caption>Clients</caption>
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Email Address</th>
			<th>Role</th>
			<th>Created</th>
			
		</tr>
	</thead>
	<tbody>
		<?php
		$query = "SELECT * FROM `users`";
		
		$result = mysqli_query($link, $query); 
		while($row = mysqli_fetch_array($result)) { 
			echo '<tr><td data-label="ID">'.htmlspecialchars($row["id"]).'</td>
			<td data-label="Name">'.htmlspecialchars($row["first_name"]).' '.htmlspecialchars($row["last_name"]).'</td>
			<td data-label="Email">'.htmlspecialchars($row["email_address"]).'</td>
			<td data-label="Role">'.htmlspecialchars($row['role']).'</td>
			<td data-label="Created">'.htmlspecialchars($row['date_created']).'</td>';
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








<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>
