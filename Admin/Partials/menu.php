<?php 
ob_start();
    include('../config/constant.php'); 
    include('login-check.php');

    // Check for a saved theme in a cookie
    $savedMode = $_COOKIE['mode'] ?? 'light';

    // Output the correct CSS file based on the saved theme
    $themeCSS = '<link rel="stylesheet" href="../Style/' . $savedMode . '.css">';

    $admin_role = $_SESSION['admin_role'];
?>

<html>
    <head>
        <!-----===============| CSS |===============----->
        <link rel="stylesheet" href="../Style/style-admin.css">

        <!-----===========| Boxicon CSS |===========----->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <title>Dashboard Sidebar menu | Dark-Light Mode</title>

        <style id="mode"></style>

        <?php echo $themeCSS;?> 
    </head>

    <body>
        <nav class="sidebar close">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="../images/Logo.png" alt="Logo" style="height: 51px; width: auto;">
                    </span>
                    <div class="text header-text">
                        <span class="name">Reno Kitchen</span>
                        <span class="profession">Restaurant</span>
                    </div>
                </div>

                <i class="bx bx-chevron-right toggle"></i>
            </header>

            <div class="menu-bar">
                <div class="menu2">
                    <ul class="menu-links">
                        <!--============= Dashboard Link =============-->
                        <li class="nav-link">
                            <a href="index.php">
                                <i class="bx bx-home-alt icon"></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>
                    
                        <!--============== Manage Admin ==============-->
                        <li class="nav-link">
                            <a href="manage-admin.php">
                                <i class="bx bxs-user-account icon"></i>
                                <span class="text nav-text">Manage Admin</span>
                            </a>
                        </li>

                        <!--============ Manage .Category ============-->
                        <li class="nav-link">
                            <a href="manage-category.php">
                                <i class='bx bx-book-content icon'></i>
                                <span class="text nav-text">Categories</span>
                            </a>
                        </li>

                        <!--============== Manage Foods ==============-->
                        <li class="nav-link">
                            <a href="manage-food.php">
                                <i class='bx bx-food-menu icon'></i>
                                <span class="text nav-text">Foods</span>
                            </a>
                        </li>

                        <!--====== Manage Customers Information ======-->
                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bxs-user-circle icon'></i>
                                <span class="text nav-text">Customer Info</span>
                            </a>
                        </li>

                        <!--============== Manage Order ==============-->
                        <li class="nav-link">
                            <a href="manage-order.php">
                                <i class='bx bx-dish icon'></i>
                                <span class="text nav-text">Orders</span>
                            </a>
                        </li>
                        
                        <!--=========== Manage .Deliveries ===========-->
                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-cart-alt icon'></i>
                                <span class="text nav-text">Deliveries</span>
                            </a>
                        </li>

                        <!--============= Manage Reports =============-->
                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-bar-chart-alt-2 icon'></i>
                                <span class="text nav-text">Analytics</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="bottom-content">
                    <!--================= Log Out =================-->
                    <li class="">
                        <a href="logout.php">
                            <i class='bx bx-log-out icon'></i>
                            <span class="text nav-text">Log Out</span>
                        </a>
                    </li>

                    <!--============ Dark / Light Mode ============--> 
                    <li class="mode">
                        <div class="moon-sun">
                            <i class='bx bx-moon icon moon'></i>
                            <i class='bx bx-sun icon sun'></i>
                        </div>

                        <span class="mode-text text">Dark Mode</span>

                        <div class="toggle-switch">
                            <span class="switch"></span>
                        </div>
                    </li>
                </div>
            </div>
        </nav>