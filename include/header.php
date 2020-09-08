<?php require_once($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php');?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/variables.php'); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


<link rel="shortcut icon" href="favicon.ico"/>
<?php/* echo $page_meta; */?>
<title><?php echo $page_title; ?></title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.25/css/uikit.min.css" /> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.25/js/uikit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.25/js/uikit-icons.min.js"></script>-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="https://dalysoft.com/wholesale/css/sidebar-themes.css">
<script type="text/javascript" src="https://dalysoft.com/wholesale/js/dashboard-page.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://dalysoft.com/wholesale/css/populateContainers.css">
<link rel="stylesheet" type="text/css" href="https://dalysoft.com/wholesale/css/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<?php
if (isset($more_script)) {
    echo $more_script;
} 
 ?>

</head>

<body>

<noscript>
	<div class="no-javascript">This site needs Javascript to work</div>
	<style>
	.result, .time-info-container, .question-container, .your-score, .parent-body, .main-menu, .top-header{
	display:none;
	}
	</style>
</noscript>

<?php
if(isset($_SESSION['user'])){
$userFullName = '';
$userLastName = '';
$userrole = '';
$profile_image = '';
$result = mysqli_query($link, "SELECT `first_name`, `last_name`, `role`, `profile-picture` FROM `users` WHERE `email_address` = '$user'");
				
				$userFullName = '';
				while ($row=mysqli_fetch_array($result)){
					$userFullName = htmlspecialchars($row['first_name']);
					$userLastName = htmlspecialchars($row['last_name']);
					$userrole = htmlspecialchars($row['role']);
					$profile_image = $row['profile-picture'];
				}
	}
?>

       



<?php
$pushLeftStyle = '';
if(isset($_SESSION['user'])){
	if(getcwd() != '/home/dalysoft/public_html/wholesale/backend'){
	require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/sidebar.php');
	}
}else{
	$pushLeftStyle = 'style="margin-left:10px !important; width: calc(100% - 10px) !important;"';
}
 
 
 ?>
<div class="main-content" <?php echo $pushLeftStyle; ?>>
 <nav class="navbar navbar-expand navbar-light bg-light fixed-top shadow-sm bg-white">
	
	<!-- toggle button for small screens -->
	<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarmenu">
		<span class="navbar-toggler-icon"></span>
	</button>
	
	<!-- Other Links on Navbar -->
	<div class="collapse navbar-collapse" id="navbarmenu">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item"><a href="https://dalysoft.com/wholesale/contact.php" class="nav-link">Contact</a></li>
			<?php 
			if (isset($_SESSION['user'])){
				$result = mysqli_query($link, "SELECT `first_name` FROM `users` WHERE `email_address` = '$user'");
				
				$userFullName = '';
				while ($row=mysqli_fetch_array($result)){
					$userFullName = $row['first_name'];
				}
				//if logged in
				?>
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $userFullName;?></a>
						 <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							  <a class="dropdown-item" href="https://dalysoft.com/wholesale/profile.php">Profile</a>
							  <a class="dropdown-item" href="https://dalysoft.com/wholesale/php-scripts/process-logout.php">Logout</a>
							  
						</div>
					</li>
					
									
									
				<?php
				  
			}
			else
			{
				//if logged out
				echo '<li class="nav-item"><a href="https://dalysoft.com/wholesale/login.php" class="nav-link">Login</a></li>';
				echo '<li class="nav-item"><a href="https://dalysoft.com/wholesale/register.php" class="nav-link">Register</a></li>'; 
			} ?>
			
			
		</ul>
	</div>
</nav>
