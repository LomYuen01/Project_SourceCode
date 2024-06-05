<?php include('config/constant.php'); ?>

<html>
    <head>
        <!-----===============| CSS |===============----->
        <link rel="stylesheet" href="Style/style-user.css">

        <!-----===========| Boxicon CSS |===========----->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c6e0062d0c.js" crossorigin="anonymous"></script>

        <title>Menu / Header for User Page</title>
    </head>

    <body>
        <header class="header">
            <nav class="nav">
                <a href="#" class="image-text"> 
                    <span class="image">
                        <img src="images/Logo.png" alt="Logo" style="height: 64px; width: auto;">
                    </span>
                    <div class="nav-text">
                        <span class="name">Reno Kitchen</span>
                    </div>
                </a> 
                <ul class="nav-items">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                        <a href="#" class="nav-link">Menu</a>
                        <a href="#" class="nav-link">About Us</a>
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                </ul>
                <?php 
                    // Check if the user is logged in
                    if(isset($_SESSION['user']['email'])): 
                        // Assuming $user_id is the ID of the user
                        $user_id = $_SESSION['user']['user_id'];

                        // Create the Sql Query to Get the details
                        $sql = "SELECT a.* FROM tbl_customer a WHERE a.id=$user_id";

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
                            }
                        }
                    ?>
                        <img src="<?php echo $current_image != "" ? SITEURL."images/Profile/".$current_image : 'images/no_profile_pic.png'; ?>" rel="logo" class="user-pic" onclick="toggleMenu()">
                        <div class="sub-menu-wrap" id="subMenu">
                            <div class="sub-menu">
                                <div class="user-info">
                                    <img src="<?php echo $current_image != "" ? SITEURL."images/Profile/".$current_image : 'images/no_profile_pic.png'; ?>">
                                    <h3><?php echo $full_name ?></h3>
                                </div>

                                <!-- LINEEEEEEEE --> <hr> <!-- LINEEEEEEEE -->

                                <a href="edit-profile.php?id=<?php echo $_SESSION['user']['user_id']; ?>" class="sub-menu-link">
                                    <i class='bx bxs-user-circle icon'></i>
                                    <p>Edit Profile</p>
                                    <span>></span>
                                </a>

                                <a href="change-password.php" class="sub-menu-link">
                                    <i class='bx bx-lock icon'></i>
                                    <p>Change Password</p>
                                    <span>></span>
                                </a>

                                <a href="logout.php" class="sub-menu-link">
                                    <i class='bx bx-log-out icon' style="margin-left: -5px;"></i>
                                    <p style="margin-left: 5px;">Log Out</p>
                                    <span>></span>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="#" id="scroll-to-top">
                            <button class="btn" id="form-open">Login</button>
                        </a>
                <?php endif; ?>
            </nav>
        </header>
    