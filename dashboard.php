<?php $page_title = 'Profile';?>
<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/header.php"); ?>
<div class="card-deck">
  <div class="card text-center">
   <a href="list-products.php"><div class="card-body">
	<h1 class="card-title"><i class="fa fa-th-large"></i></h1>
      <h5 class="card-title">Products</h5>
      
    </div></a>
  </div>
  <div class="card text-center">
    
    <a href="list-suppliers.php"><div class="card-body">
	<h1 class="card-title"><i class="fa fa-boxes"></i></h1>
      <h5 class="card-title">Suppliers</h5>
      
    </div></a>
  </div>
  <div class="card text-center">
    <a href="list-customers.php"><div class="card-body">
	<h1 class="card-title"><i class="fa fa-user-friends"></i></h1>
      <h5 class="card-title">Customers</h5>
      
    </div></a>
  </div>
  <div class="card text-center">
    <a href="list-users.php"><div class="card-body">
	<h1 class="card-title"><i class="fa fas fa-user"></i></h1>
      <h5 class="card-title">Users</h5>
      
    </div></a>
  </div>
</div><br>
<div class="card-deck">
  <div class="card text-center">
   <a href="list-orders.php"><div class="card-body">
	<h1 class="card-title"><i class="fa fa-list-alt"></i></h1>
      <h5 class="card-title">Orders</h5>
      
    </div></a>
  </div>
  <div class="card text-center">
    
    <a href="#" id="place-order-template1-2"><div class="card-body">
	<h1 class="card-title"><i class="fa fa-pen-square"></i></h1>
      <h5 class="card-title">Place Order</h5>
      
    </div></a>
  </div>
  <div class="card text-center">
    <a href="edit-settings.php"><div class="card-body">
	<h1 class="card-title"><i class="fa fa-user-friends"></i></h1>
      <h5 class="card-title">Settings</h5>
      
    </div></a>
  </div>
  
</div>


<?php include($_SERVER['DOCUMENT_ROOT']."/wholesale/include/footer.php"); ?>


