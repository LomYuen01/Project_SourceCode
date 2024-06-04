<?php include('Partials/menu.php'); ?>
    <?php
        // Assuming $admin_id is the ID of the admin
        $admin_id = $_SESSION['admin_id'];

        // Create the Sql Query to Get the details
        $sql = "SELECT a.* FROM tbl_admin a WHERE a.id=$admin_id";

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
                // Redirect to Manage Admin Page with Session Message
                $_SESSION['user-not-found'] = "<div class='error'> Admin Information Not Found. <div/>";

                // Redirect to Manage Admin Page
                header('location:'.SITEURL.'admin/index.php');
            }
        }
        else
        {
            // Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/index.php');
        }
    ?>

    <section class="home" style="overflow: hidden;">
        <div class="title">
            <div class="text">Dashboard</div>
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
            ?>

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="<?php echo $current_image != "" ? SITEURL."images/Profile/".$current_image : '../images/no_profile_pic.png'; ?>">
                        <h3><?php echo $full_name ?> [<?php echo $position ?>]</h3>
                    </div>

                    <!-- LINEEEEEEEE --> <hr> <!-- LINEEEEEEEE -->

                    <a href="edit-profile.php?id=<?php echo $_SESSION['admin_id']; ?>&address_id=<?php echo $_SESSION['address_id']; ?>" class="sub-menu-link">
                        <i class='bx bxs-user-circle icon'></i>
                        <p>Edit Profile</p>
                        <span>></span>
                    </a>

                    <a href="logout.php" class="sub-menu-link">
                        <i class='bx bx-log-out icon'></i>
                        <p>Log Out</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </div>

        <br>

        <div class="index-table">
            <section class="left-container">
                <div class="box-link-container">
                    <div class="box1"></div>
                    <div class="box2"></div>
                    <div class="box3"></div>
                    <div class="box4"></div>
                </div>

                <section class="table-body index-title" style="height: 90%; width: 100%; background: transparent; padding-top: 10px;" data-title="Recent Orders">
                    <div class="item-details" style="height: 66%;"> <!-- Fixed Size, Scrollable -->
                    <table>
                        <thead>
                            <tr>
                                <th><span>Order ID<span class="icon-arrow"></span></span></th>
                                <th><span>Customer Name<span class="icon-arrow"></span></span></th>
                                <th><span>Status <span class="icon-arrow"></span></span></th>
                                <th><span>Total <span class="icon-arrow"></span></span></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $sql = "SELECT tbl_order.*, tbl_customer.full_name AS customer_name 
                                FROM tbl_order 
                                INNER JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.id
                                ORDER BY tbl_order.id ASC";
                                $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                                // Count the rows
                                $count = mysqli_num_rows($res);

                                if($count > 0)
                                {
                                    // We have data in database
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        $id = $row['id'];
                                        $customer_name = $row['customer_name'];
                                        $order_time = $row['order_time'];
                                        $delivery_time = $row['delivery_time'];
                                        $status = $row['order_status'];

                                        // Fetch the total price from the tbl_order_items table
                                        $sql2 = "SELECT price FROM tbl_order_items WHERE order_id = $id";
                                        $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
                                        $total = 0;
                                        while($row2 = mysqli_fetch_assoc($res2))
                                        {
                                            $total += $row2['price'];
                                        }
                                        ?>
                                            <tr class="table-row">
                                                <td><?php echo 'order' . str_pad($id, 2, '0', STR_PAD_LEFT); ?></td>
                                                <td><?php echo $customer_name; ?></td>
                                                <td style="padding-right: 3rem;"><div class="<?php echo strtolower($status); ?>"><?php echo $status; ?></div></td>
                                                <td>RM <?php echo number_format($total, 2); ?></td>
                                                <td style="padding-right: 3rem;">
                                                    <a href="<?php echo SITEURL; ?>admin/view-order.php?id=<?php echo $id; ?>" style="width: 40px; font-size: 14px; text-decoration: none;" title="View Order">Details</a>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    // We do not have data in database
                                    echo "<tr> <td colspan='7'> <div class='error'> No Orders Found </div> </td> </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </section>
            </section>
            <section class="right-container">
                
            </section>
        </div>
    </section>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu(){
            subMenu.classList.toggle("open-menu");
        }
    </script>
<?php include('Partials/footer.php'); ?>