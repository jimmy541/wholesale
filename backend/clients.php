<?php $page_title = 'Backend Clients';
$more_script = '<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="../css/jquery.dataTables.min.css">';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<table class="display compact" id="gtable">
<caption>Clients</caption>
	<thead>
		<tr>
			<th>Client ID</th>
			<th>Name</th>
			<th>City</th>
			<th>State</th>
			<th>Phone</th>
			<th>Created</th>
			
		</tr>
	</thead>
	<tbody>
		<?php
		$query = "SELECT * FROM `clients` ORDER BY `date_created` DESC";
		
		$result = mysqli_query($link, $query); 
		while($row = mysqli_fetch_array($result)) { 
			echo '<tr><td data-label="Client Id">'.htmlspecialchars($row["clientid"]).'</td>
			<td data-label="Company Name">'.htmlspecialchars($row["company_name"]).'</td>
			<td data-label="City">'.htmlspecialchars($row["city"]).'</td>
			<td data-label="State">'.htmlspecialchars($row['state']).'</td>
			<td data-label="Phone">'.htmlspecialchars($row['phone1']).'</td>
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
