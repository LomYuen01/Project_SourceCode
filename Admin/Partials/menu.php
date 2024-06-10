<?php 
ob_start();
    include('../config/constant.php'); 
    include('login-check.php');

    // Check for a saved theme in a cookie
    $savedMode = $_COOKIE['mode'] ?? 'light';

    // Output the correct CSS file based on the saved theme
    $themeCSS = '<link rel="stylesheet" href="../Style/' . $savedMode . '.css">';

    $position = $_SESSION['admin']['position'];
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
                            <span class="tooltip">Dashboard</span>
                        </li>

                        <!--============ Manage .Category ============-->
                        <li class="nav-link">
                            <a href="manage-category.php">
                                <i class='bx bx-book-content icon'></i>
                                <span class="text nav-text">Manage Category</span>
                            </a>
                            <span class="tooltip">Manage Category</span>
                        </li>

                        <!--============== Manage Foods ==============-->
                        <li class="nav-link">
                            <a href="manage-food.php">
                                <i class='bx bx-food-menu icon'></i>
                                <span class="text nav-text">Manage Menu</span>
                            </a>
                            <span class="tooltip">Manage Menu</span>
                        </li>

                        <!--============== Manage Order ==============-->
                        <li class="nav-link">
                            <a href="manage-order.php">
                                <i class='bx bx-dish icon'></i>
                                <span class="text nav-text">Manage Order</span>
                            </a>
                            <span class="tooltip">Manage Order</span>
                        </li>

                        <?php if (isset($_SESSION['admin']['position']) && $_SESSION['admin']['position'] == 'Superadmin') { ?>
                            <!--======= Manage Admin's Information =======-->
                            <li class="nav-link">
                                <a href="manage-admin.php">
                                    <img src="Icon/admin_icon.png" class="icon" style="margin-left: 15px; min-width: 30px; width: 30px; height: 30px;">
                                    <span class="text nav-text" style="margin-left: 15px;">Admin details</span>
                                </a>
                                <span class="tooltip">Admin details</span>
                            </li>
                        <?php } ?>

                        <!--======= Manage Workers Information =======-->
                        <li class="nav-link">
                            <a href="manage-worker.php">
                                <img src="Icon/chef_hat_icon.png" class="icon" style="margin-left: 14px; min-width: 32px; width: 32px; height: 32px;">
                                <span class="text nav-text" style="margin-left: 15px;">Worker details</span>
                            </a>
                            <span class="tooltip">Worker details</span>
                        </li>

                        <!--======= Manage Drivers Information= ======-->
                        <li class="nav-link">
                            <a href="manage-driver.php">
                                <img src="Icon/driver_icon.png" class="icon" style="margin-left: 14px; min-width: 30px; width: 30px; height: 30px;">
                                <span class="text nav-text" style="margin-left: 15px;">Driver details</span>
                            </a>
                            <span class="tooltip">Driver details</span>
                        </li>

                        <!--====== Manage Customers Information ======-->
                        <li class="nav-link">
                            <a href="manage-customer.php">
                                <img src="Icon/customer_icon.png" class="icon" style="margin-left: 17.5px; min-width: 25px; width: 25px; height: 25px;">
                                <span class="text nav-text" style="margin-left: 15px;">Customer details</span>
                            </a>
                            <span class="tooltip">Customer details</span>
                        </li>
                    </ul>
                </div>

                <div class="bottom-content">
                    <!--================= Log Out =================-->
                    <li class="nav-link">
                        <a href="logout.php">
                            <i class='bx bx-log-out icon'></i>
                            <span class="text nav-text">Log Out</span>
                        </a>
                        <span class="tooltip">Log Out</span>
                    </li>

                    <!--============ Dark / Light Mode ============
                    <li class="mode">
                        <div class="moon-sun">
                            <i class='bx bx-moon icon moon'></i>
                            <i class='bx bx-sun icon sun'></i>
                        </div>

                        <span class="mode-text text">Dark Mode</span>

                        <div class="toggle-switch">
                            <span class="switch"></span>
                        </div>
                    </li> -->
                </div>
            </div>
        </nav>