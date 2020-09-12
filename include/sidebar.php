<div class="default-theme sidebar-bg bg1">
<nav class="sidebar-wrapper">
            <div class="sidebar-content">
                <!-- sidebar-brand -->
                <div class="sidebar-item sidebar-brand text-center">
                    <a href="dashboard.php">Dalysoft</a>
                </div>
                <!-- sidebar-header  -->
                <div class="sidebar-item sidebar-header d-flex flex-nowrap">
				<?php if(!empty($profile_image)){ ?>
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="uploads/profile-image/<?php echo $profile_image; ?>" alt="User picture">
                    </div>
				<?php } ?>
                    <div class="user-info">
                        <span class="user-name"><?php echo $userFullName; ?>
                            <strong><?php echo $userLastName; ?></strong>
                        </span>
                        <span class="user-role"><?php echo $role; ?></span>
                       <!-- <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span> -->
                    </div>
                </div>
                <!-- sidebar-search 
                <div class="sidebar-item sidebar-search">
                    <div>
                        <div class="input-group">
                            <input type="text" class="form-control search-menu" placeholder="Search...">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- sidebar-menu  -->
                <div class=" sidebar-item sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>General</span>
                        </li>
                        <!--<li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-tachometer-alt"></i>
                                <span class="menu-text">Dashboard</span>
                                <span class="badge badge-pill badge-warning">New</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="#">Dashboard 1
                                            <span class="badge badge-pill badge-success">Pro</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Dashboard 2</a>
                                    </li>
                                    <li>
                                        <a href="#">Dashboard 3</a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
						<li>
                            <a href="dashboard.php">
                                <i class="fa fa-tachometer-alt"></i>
                                <span class="menu-text">Dashboard</span>
                                
                            </a>
                        </li>
						 <?php if($role == 'Administrator'){ ?>
						<li>
                            <a href="edit-company.php">
                                <i class="fa fa-building"></i>
                                <span class="menu-text">Company</span>
                                
                            </a>
                        </li>
						 <?php } ?>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-th-large"></i>
                                <span class="menu-text">Products</span>
                               <!-- <span class="badge badge-pill badge-danger">3</span> -->
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
									<li><a href="new-product.php">New Product</a></li>
                                    <li><a href="list-products.php">Products List</a></li>
                                    <li><a href="list-products-departments.php">Departments</a></li>
                                  
                                </ul>
                            </div>
                        </li>
						 <?php if($role == 'Administrator'){ ?>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-boxes"></i>
                                <span class="menu-text">Suppliers</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li><a href="new-supplier.php">New Supplier</a></li>
                                    <li><a href="list-suppliers.php">Suppliers List</a></li>
                                <ul>
                            </div>
                        </li>
						 <?php } ?>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-user-friends"></i>
                                <span class="menu-text">Customers</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li><a href="new-customer.php">New Customer</a></li>
                                    <li><a href="list-customers.php">Customers List</a></li>
                                </ul>
                            </div>
                        </li>
						<li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-list-alt"></i>
                                <span class="menu-text">Reports</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li><a href="accounts-unpaid.php">Unpaid Accounts</a></li>
                                    <li><a href="accounts-history.php">Accounts History</a></li>
									<li><a href="list-payments.php">Payments</a></li>
                                </ul>
                            </div>
                        </li>
						<li>
                            <a href="#" id="place-order-template1">
                                <i class="fa fa-pen-square"></i>
                                <span class="menu-text">Place Order</span>
                                
                            </a>
                        </li>
                        <li>
                            <a href="list-orders.php">
                                <i class="fa fa-list-alt"></i>
                                <span class="menu-text">Orders</span>
                                
                            </a>
                        </li>
                        <li class="header-menu">
                            <span>Extra</span>
                        </li>
						<?php if($role == 'Administrator'){ ?>
						<li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-user-friends"></i>
                                <span class="menu-text">Users</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li><a href="new-user.php">New User</a></li>
                                    <li><a href="list-users.php">Users List</a></li>
                                </ul>
                            </div>
                        </li>
						<?php } ?>
                        <li>
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span class="menu-text">Documentation</span>
                             
                            </a>
                        </li>
                        
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-footer  -->
            <div class="sidebar-footer">
                <div class="dropdown">

                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-pill badge-warning notification">3</span>
                    </a>
                    <div class="dropdown-menu notifications" aria-labelledby="dropdownMenuMessage">
                        <div class="notifications-header">
                            <i class="fa fa-bell"></i>
                            Notifications
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <div class="notification-content">
                                <div class="icon">
                                    <i class="fas fa-check text-success border border-success"></i>
                                </div>
                                <div class="content">
                                    <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. In totam explicabo</div>
                                    <div class="notification-time">
                                        6 minutes ago
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item" href="#">
                            <div class="notification-content">
                                <div class="icon">
                                    <i class="fas fa-exclamation text-info border border-info"></i>
                                </div>
                                <div class="content">
                                    <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. In totam explicabo</div>
                                    <div class="notification-time">
                                        Today
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item" href="#">
                            <div class="notification-content">
                                <div class="icon">
                                    <i class="fas fa-exclamation-triangle text-warning border border-warning"></i>
                                </div>
                                <div class="content">
                                    <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. In totam explicabo</div>
                                    <div class="notification-time">
                                        Yesterday
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center" href="#">View all notifications</a>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-envelope"></i>
                        <span class="badge badge-pill badge-success notification">7</span>
                    </a>
                    <div class="dropdown-menu messages" aria-labelledby="dropdownMenuMessage">
                        <div class="messages-header">
                            <i class="fa fa-envelope"></i>
                            Messages
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <div class="message-content">
                                <div class="pic">
                                    <img src="images/user.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="message-title">
                                        <strong> Jhon doe</strong>
                                    </div>
                                    <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. In totam explicabo</div>
                                </div>
                            </div>

                        </a>
                        <a class="dropdown-item" href="#">
                            <div class="message-content">
                                <div class="pic">
                                    <img src="images/user.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="message-title">
                                        <strong> Jhon doe</strong>
                                    </div>
                                    <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. In totam explicabo</div>
                                </div>
                            </div>

                        </a>
                        <a class="dropdown-item" href="#">
                            <div class="message-content">
                                <div class="pic">
                                    <img src="images/user.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="message-title">
                                        <strong> Jhon doe</strong>
                                    </div>
                                    <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. In totam explicabo</div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center" href="#">View all messages</a>

                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog"></i>
                        
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuMessage">
                        <a class="dropdown-item" href="profile.php">My profile</a>
                        <a class="dropdown-item" href="#">Help</a>
                        <a class="dropdown-item" href="edit-settings.php">Setting</a>
                    </div>
                </div>
              <!-- <div>
                    <a href="#">
                        <i class="fa fa-power-off"></i>
                    </a>
                </div> -->
                <div class="pinned-footer">
                    <a href="#">
                        <i class="fas fa-ellipsis-h"></i>
                    </a>
                </div>
            </div>
</nav>
</div>