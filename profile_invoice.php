<?php include('partials-front/menu.php'); ?>
<!-- Home -->
<style>
    table, th, td {
        border: 1px solid grey;
        border-collapse: collapse;
        padding: auto;
    }

    .split{
        position: relative;
        width: 100%;
        padding: 40px;
    }

    .invoice-to {
        float: left;
    }
                
    .invoice-from {
        float: right;
    }
    
</style>

<section class="home" style="background: rgb(243, 243, 243);">
    <!--====== Forms ======-->
    <div class="form-container">
        <i class="fa-solid fa-xmark form-close"></i>

        <!-- Login Form -->
        <div class="form login-form">
            <form action="#">
                <h2>Login</h2>

                <div class="input-box">
                    <input type="email" placeholder="Enter your email" required>
                    <i class="fa-solid fa-envelope email"></i>
                </div>

                <div class="input-box">
                    <input type="password" placeholder="Enter your password" required>
                    <i class="fa-solid fa-lock password"></i>
                    <i class="fa-solid fa-eye-slash pw-hide"></i>
                </div>

                <div class="option-field">
                    <span class="checkbox">
                        <input type="checkbox" id="check">
                        <label for="check">Remember me</label>
                    </span>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>

                <button class="btn">Login Now</button>

                <div class="login-singup">
                    Don't have an account? <a href="#" id="signup">Sign up</a>
                </div>
            </form>
        </div>

        <!-- Sign up Form -->
        <div class="form signup-form">
            <form action="#">
                <h2>Sign up</h2>

                <div class="input-box">
                    <input type="email" placeholder="Enter your email" required>
                    <i class="fa-solid fa-envelope email"></i>
                </div>

                <div class="input-box">
                    <input type="password" placeholder="Create password" required>
                    <i class="fa-solid fa-lock password"></i>
                    <i class="fa-solid fa-eye-slash pw-hide"></i>
                </div>

                <div class="input-box">
                    <input type="password" placeholder="Confirm password" required>
                    <i class="fa-solid fa-lock password"></i>
                    <i class="fa-solid fa-eye-slash pw-hide"></i>
                </div>
                
                <button class="btn">Sign Up Now</button>

                <div class="login-singup">
                    Already have an account? <a href="#" id="login">Login</a>
                </div>
            </form>
        </div>
    </div>
    <!--====== Forms ======-->

    <!--===== Content =====-->
    <?php $user_id = 1; ?>
    <div style="width: 90%; margin: auto; margin-top: 5%; margin-left:2%; display:inline-flex; background:#FEFFFC;">
        <div style="border: 1px solid black; width: 20%; font-size: 1rem; background-color: #d9d9d9;">
            <h1>Profile</h1>
            <div style="border: 1px solid black;">
                <div class="profile-img" style="display: flex; justify-content: center; align-items: center; width: 100%; ;">
                    <img src="images/user.png" alt="User Image" class="img-responsive img-curve" style="width: 100%; height: auto; object-fit: cover;">
                </div>
                <div class="user-info style:">
                    User Name
                </div>
            </div>
            <div class="profile-menu">
                <ul>
                    <li>
                        <a href="profile_edit.php">Edit Profile</a>
                    </li>
                    <li>
                        <a href="profile_password.php">Change Password</a>
                    </li>
                    <li>
                        <a href="profile_order.php">Order History</a>
                    </li>
                    <li>
                        <a href="profile_address.php">Address</a>
                    </li>
                </ul>
            </div>
        </div>

        <div style="border: 1px solid black; font-size: 1rem; width:80%;margin-left:2%; background:hsla(90, 100%, 100%, 1);">
            <?php
            $set_order_id = $_GET['order_id'];
            ?>
            <div style="padding-bottom: 40px;"><h1>Invoice #<?php echo $set_order_id ?></h1></div>
            <div style="margin:auto; width:80%; border:pink 1px solid; background-color: #ebe7db;" class="invoice">
                <div style="display: flex; justify-content: center; align-items: center; width: 100%; padding: 40px;">
                    <img src="Images/Logo_RK.png" alt="User Image" class="img-responsive img-curve" style="width: 100%; height: auto; object-fit: cover;">
                </div>

                <?php
                // Fetch order and address details
                $sql_order = "SELECT tbl_order.*, tbl_order_address.firstname, tbl_order_address.address, tbl_order_address.city, tbl_order_address.state, tbl_order_address.zip 
                              FROM tbl_order 
                              INNER JOIN tbl_order_address ON tbl_order.address_id = tbl_order_address.id 
                              WHERE tbl_order.id = $set_order_id";

                $res_order = mysqli_query($conn, $sql_order);

                while($row_order = mysqli_fetch_assoc($res_order)){
                    $order_time = $row_order['order_time'];
                    $firstname = $row_order['firstname'];
                    $address = $row_order['address'];
                    $city = $row_order['city'];
                    $state = $row_order['state'];
                    $zip = $row_order['zip'];
                }
                ?>
                <div class="split">
                    <div class="invoice-to">
                        <p>INVOICE TO</p>
                        <h2 style="color:#8b562a;"><?php echo $firstname ?></h2>
                        <p style="color:#8b562a;"><?php echo $address ?></p>
                        <p style="color:#8b562a;"><?php echo $city ?></p>
                        <p style="color:#8b562a;"><?php echo $state ?></p>
                        <p style="color:#8b562a;"><?php echo $zip ?></p>
                    </div>
                    <div class="invoice-from">
                        <p>Order Date: <?php echo $order_time ?> </p>
                        <p>Invoice ID: <?php echo $set_order_id ?></p>
                    </div>
                </div>
                <div style="display: flex; justify-content: center; align-items: center; width: 100%; padding-top: 40px;;">
                    <h2 style="color:#8b562a; font-size:1cm; font-weight:bold;">Invoice</h2>
                </div>
                <div style="display: flex; justify-content: center; align-items: center; width: 100%;">
                    <table style="border: 0px !important;" >
                        <tr style="border: 0px !important;">
                            <th style="color:#8b562a; padding:15px; border: 0px !important; text-align: center;">No</th>
                            <th style="color:#8b562a; padding:15px; border: 0px !important; text-align: center;">Item</th>
                            <th style="color:#8b562a; padding:15px; border: 0px !important; text-align: center;">Size</th>
                            <th style="color:#8b562a; padding:15px; border: 0px !important; text-align: center;">Price</th>
                            <th style="color:#8b562a; padding:15px; border: 0px !important; text-align: center;">Quantity</th>
                            <th style="color:#8b562a; padding:15px; border: 0px !important; text-align: center;">Total</th>
                        </tr>
                        <?php
                        // Fetch order items
                        $sql_items = "SELECT tbl_order_items.*, tbl_food.title AS food_title 
                                      FROM tbl_order_items 
                                      INNER JOIN tbl_food ON tbl_order_items.food_id = tbl_food.id 
                                      WHERE tbl_order_items.order_id = $set_order_id";

                        $res_items = mysqli_query($conn, $sql_items);

                        $sn = 1; // Serial number
                        while($row_items = mysqli_fetch_assoc($res_items)){
                            $item_title = $row_items['food_title'];
                            $item_size = $row_items['size'];
                            if ($item_size != "Regular" && $item_size != "Large") {
                                $item_size = "Regular";
                            }
                            $item_price = $row_items['price'];
                            $item_quantity = $row_items['quantity'];
                            $item_total = $item_price * $item_quantity;

                            echo '<tr style="border: 0px !important;padding:15px;">';
                            echo '<td style="border: 0px !important;padding:15px;">' . $sn++ . '</td>';
                            echo '<td style="border: 0px !important;padding:15px;">' . $item_title . '</td>';
                            echo '<td style="border: 0px !important;padding:15px; text-align: center;">' . $item_size . '</td>';
                            echo '<td style="border: 0px !important;padding:15px;text-align: center;">' . $item_price . '</td>';
                            echo '<td style="border: 0px !important;padding:15px;text-align: center;">' . $item_quantity . '</td>';
                            echo '<td style="border: 0px !important;padding:15px;text-align: center;">' . $item_total . '</td>';
                            echo '</tr>';
                        }
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: right; color:#8b562a; border: 0px !important;">Total</td>
                            <td style="color:#8b562a; border: 0px !important;text-align: center; padding:15px;">
                                <?php
                                // Calculate total
                                $sql_subtotal = "SELECT SUM(price * quantity) AS Total FROM tbl_order_items WHERE order_id = $set_order_id";
                                $res_subtotal = mysqli_query($conn, $sql_subtotal);
                                $row_subtotal = mysqli_fetch_assoc($res_subtotal);
                                $subtotal = $row_subtotal['Total'];
                                echo $subtotal;
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <p style="color:#8b562a; padding-top: 40px;">Thank you for your order!</p>
                </div>
                <br>
                <div>
                    <p>Reno Kitchen</p>
                    <p>BG-8</p>
                    <p>Jalan Tun Perak</p>
                    <p>Taman Kenaga Mewah</p>
                    <p>75200 Melaka</p>
                </div>

            </div>

            <div class="generate_invoice">

            </div>
            
        </div>
    </div>
</section>
<?php include('partials-front/footer.php'); ?>
