<?php 
ob_start();
    include('../config/constant.php'); 
    include('login-check.php');

    // Check for a saved theme in a cookie
    $savedMode = $_COOKIE['mode'] ?? 'light';

    // Output the correct CSS file based on the saved theme
    $themeCSS = '<link rel="stylesheet" href="../Style/' . $savedMode . '.css">';

    // Assuming $driver_id is the ID of the driver
    $driver_id = $_SESSION['driver']['driver_id'];

    // Create the Sql Query to Get the details
    $sql = "SELECT a.* FROM tbl_driver a WHERE a.id=$driver_id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    if($res==TRUE) {
        // Check whether the data is available or not
        $count = mysqli_num_rows($res);

        if($count==1) {
            // Get the Details
            $row = mysqli_fetch_assoc($res);

            $current_image = $row['image_name'];
            $full_name = $row['full_name'];
            $position = $row['position'];
        }
        else
        {
            // Redirect to Manage driver Page with Session Message
            $_SESSION['user-not-found'] = "<div class='error'> Driver Information Not Found. <div/>";

            // Redirect to Manage Delivery Page
            header('location:'.SITEURL.'delivery/index.php');
        }
    }
    else
    {
        // Redirect to Manage Delivery Page
        header('location:'.SITEURL.'delivery/index.php');
    }
?>

<html>
    <head>
        <!-----===============| CSS |===============----->
        <link rel="stylesheet" href="../Style/style-delivery.css">

        <!-----===========| Boxicon CSS |===========----->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c6e0062d0c.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <header class="header">
            <nav class="nav">
                <a href="#" class="image-text"> 
                    <span class="image">
                        <img src="../images/Logo.png" alt="Logo" style="height: 64px; width: auto;">
                    </span>
                    <div class="nav-text">
                        <span class="name">Reno Kitchen</span>
                    </div>
                </a> 
                <ul class="nav-items">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                        <a href="order.php" class="nav-link">View Orders</a>
                    </li>
                </ul>
                <?php
                $display = (isset($_SESSION['update']) || isset($_SESSION['add'])) ? 'none' : 'inline-block';
                ?>
                <img style="display: <?php echo $display; ?>;" src="<?php echo $current_image != "" ? SITEURL."images/Profile/".$current_image : '../images/no_profile_pic.png'; ?>" rel="logo" class="user-pic" onclick="toggleMenu()">
                <?php
                    if(isset($_SESSION['update'])) 
                    {
                        echo $_SESSION['update'];  
                        unset($_SESSION['update']);  
                    }

                    if(isset($_SESSION['add'])) 
                    {
                        echo $_SESSION['add'];  
                        unset($_SESSION['add']);  
                    }

                    if(isset($_SESSION['user-not-found'])) 
                    {
                        echo $_SESSION['user-not-found'];  
                        unset($_SESSION['user-not-found']);  
                    }
                ?>
                <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                        <div class="user-info">
                            <img src="<?php echo $current_image != "" ? SITEURL."images/Profile/".$current_image : '../images/no_profile_pic.png'; ?>">
                            <h3><?php echo $full_name ?> [Driver]</h3>
                        </div>

                        <!-- LINEEEEEEEE --> <hr> <!-- LINEEEEEEEE -->

                        <a href="edit-profile.php?id=<?php echo $_SESSION['driver']['driver_id']; ?>&address_id=<?php echo $_SESSION['driver']['address_id']; ?>" class="sub-menu-link">
                            <i class='bx bxs-user-circle icon'></i>
                            <p>Edit Profile</p>
                            <span>></span>
                            <form method="post" action="edit-profile.php">
                                <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            </form>
                        </a>

                        <a href="#" class="sub-menu-link">
                            <i class='bx bx-lock icon'></i>
                            <p>Change Password</p>
                            <span>></span>
                            <form method="post" action="change-password.php">
                                <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            </form>
                        </a>

                        <a href="logout.php" class="sub-menu-link">
                            <i class='bx bx-log-out icon' style="margin-left: -5px;"></i>
                            <p style="margin-left: 5px;">Log Out</p>
                            <span>></span>
                        </a>
                    </div>
                </div>
            </nav>
        </header>
