<?php include('Partials/menu.php'); ?>
    <?php
        // Assuming $admin_id is the ID of the admin
        $admin_id = $_SESSION['admin']['admin_id'];

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

        $res_food = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_food");
        $count_food = mysqli_fetch_array($res_food)[0];

        $res_category = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_category");
        $count_category = mysqli_fetch_array($res_category)[0];

        $res_customer = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_customer");
        $count_customer = mysqli_fetch_array($res_customer)[0];

        $res_admin = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_admin");
        $count_admin = mysqli_fetch_array($res_admin)[0];
    ?>

    <section class="home" style="overflow: hidden;">
        <div class="title">
            <div class="text">Dashboard</div>
            <img style="display: <?php echo $display; ?>;" src="<?php echo $current_image != "" ? SITEURL."images/Profile/".$current_image : '../images/no_profile_pic.png'; ?>" rel="logo" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu" style="padding-bottom: 7.5px;">
                    <div class="user-info">
                        <img src="<?php echo $current_image != "" ? SITEURL."images/Profile/".$current_image : '../images/no_profile_pic.png'; ?>">
                        <h3><?php echo $full_name ?> [<?php echo $position ?>]</h3>
                    </div>

                    <!-- LINEEEEEEEE --> <hr> <!-- LINEEEEEEEE -->

                    <a href="edit-profile.php?id=<?php echo $_SESSION['admin']['admin_id']; ?>&address_id=<?php echo $_SESSION['admin']['address_id']; ?>" class="sub-menu-link">
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
                        <i class='bx bx-log-out icon' style="margin-left: 0px; margin-right: 16px;"></i>
                        <p>Log Out</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </div>

        <br>

        <div class="index-table">
            <section class="dashboard-box-container">
                <a href="manage-food.php" class="box1">
                    <div class="box-text">
                        <span class="details">Menu Items</span>
                        <span class="num-count"><?php echo $count_food; ?></span>
                    </div>
                    <div class="box-icon"><img src="Icon/Menu_Img.png" style="width: 90px;"></div>
                </a>
                <a href="manage-category.php" class="box2">
                    <div class="box-text">
                        <span class="details">Categories</span>
                        <span class="num-count"><?php echo $count_category; ?></span>
                    </div>
                    <div class="box-icon"><img src="Icon/Category_Img.png" style="width: 78px;"></div>
                </a>
                <a href="manage-customer.php" class="box3">
                    <div class="box-text">
                        <span class="details">Customers</span>
                        <span class="num-count"><?php echo $count_customer; ?></span>
                    </div>
                    <div class="box-icon"><img src="Icon/Customer_Img.png" style="width: 80px;"></div>
                </a>
                <a href="manage-admin.php" class="box4">
                    <div class="box-text">
                        <span class="details">Admins</span>
                        <span class="num-count"><?php echo $count_admin; ?></span>
                    </div>
                    <div class="box-icon"><img src="Icon/Admin_Img.png" style="width: 90px;"></div>
                </a>
            </section>

            <section class="down-d-container">
                <section class="table-body index-title" style="display: flex; flex-direction: column; overflow: hidden; max-height: 100%; width: 60%; background: none; margin: 0;" data-title="Active Orders">
                    <div class="item-details" style="height: 100%;"> <!-- Fixed Size, Scrollable -->
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
                                WHERE tbl_order.order_status != 'Delivered'
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

                <section class="table-body index-title" style="display: flex; flex-direction: column; overflow: hidden; max-height: 100%; width: 39%; background: none; margin: 0;" data-title="Customer's Feedbacks">
                    <div class="item-details" style="height: 100%; box-shadow: 4px -5px 8px 1px rgba(0, 0, 0, 0.1);">
                        <table>
                            <thead>
                                <tr>
                                    <th><span>Name<span class="icon-arrow"></span></span></th>
                                    <th><span>Status <span class="icon-arrow"></span></span></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM tbl_contact_us ORDER BY id ASC";
                                    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                                    // Count the rows
                                    $count = mysqli_num_rows($res);

                                    if($count > 0)
                                    {
                                        // We have data in database
                                        while($row = mysqli_fetch_assoc($res))
                                        {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $status = $row['status'] == 'Yes' ? 'Read' : 'Unread';
                                            ?>
                                                <tr class="table-row">
                                                    <td><?php echo $name; ?></td>
                                                    <td style="padding-right: 3rem;"><div class="<?php echo strtolower($status); ?>"><?php echo $status; ?></div></td>
                                                    <td style="padding-right: 3rem;">
                                                        <a href="<?php echo SITEURL; ?>admin/view-feedback.php?id=<?php echo $id; ?>" style="width: 40px; font-size: 14px; text-decoration: none;" title="View Feedback">Details</a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        // We do not have data in database
                                        echo "<tr> <td colspan='3'> <div class='error'> No Feedback Found </div> </td> </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
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