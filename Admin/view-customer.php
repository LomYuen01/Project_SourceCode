<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">View Customer details</div>

            <?php
                if (isset($_GET['id'])) 
                {
                    $customer_id = $_GET['id'];
                }

                if (isset($_GET['address_id'])) 
                {
                    $address_id = $_GET['address_id'];
                }

                if(isset($_GET['id'])) {
                    // Get the id of selected customer
                    $id = $_GET['id'];

                    // Create the Sql Query to Get the details
                    $sql = "SELECT a.*, ad.address, ad.postal_code, ad.city, ad.state, ad.country 
                            FROM tbl_customer a 
                            JOIN tbl_address ad ON a.address_id = ad.id 
                            WHERE a.id=$id";

                    // Execute the Query
                    $res = mysqli_query($conn, $sql);

                    if($res==TRUE) {
                        // Check whether the data is available or not
                        $count = mysqli_num_rows($res);

                        if($count==1) {
                            // Get the Details
                            $row = mysqli_fetch_assoc($res);

                            $full_name = $row['full_name'];
                            $username = $row['username'];
                            $password = $row['password'];
                            $current_image = $row['image_name'];
                            $ph_no = $row['ph_no'];
                            $email = $row['email'];
                            $status = $row['status'];

                            $address = $row['address'];
                            $postal_code = $row['postal_code'];
                            $city = $row['city'];
                            $state = $row['state'];
                            $country = $row['country'];
                        }
                        else
                        {
                            // Redirect to Manage Customer Page with Session Message
                            $_SESSION['user-not-found'] = "<div class='error'> Customer Information Not Found. </div>";

                            // Redirect to Manage Customer Page
                            header('location:'.SITEURL.'admin/manage-customer.php');
                        }
                    }
                }
                else
                {
                    // Redirect to Manage Customer Page
                    header('location:'.SITEURL.'admin/manage-customer.php');
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container" style="overflow: visible;">
            <!-- =================================================== Form Section =================================================== -->
                <form action="" method="POST" enctype="multipart/form-data" style="background: none; box-shadow: none;">
                    <section class="profile-container">
                        <div class="profile-img">
                            <?php
                                if($current_image != "")
                                {
                                    // Display the Image
                                    $borderColor = $status == 'Active' ? '#2ed573' : '#ff4757';
                                    echo "<img src='".SITEURL."images/Profile/".$current_image."' id='profileImage' style='border-color: $borderColor; border-width: 2.5px; border-style: solid;'>";
                                }
                                else
                                {
                                    // Display the default image
                                    $borderColor = $status == 'Active' ? '#2ed573' : '#ff4757';
                                    echo "<img src='../images/no_profile_pic.png' id='profileImage' style='border-color: $borderColor; border-width: 2.5px; border-style: solid;'>";
                                }
                            ?>
                        </div>
                        <div class="user-details">
                            <span class="details"><?php echo $full_name; ?> [Customer]</span>
                            <span class="light-color"><?php echo $username ?></span>
                        </div>
                    </section>
                    
                    <section class="profile-form" data-title="Profile Details">
                        <div class="profile-details">
                            <!-- Personal Details -->
                            <span class="title-name">Personal Information</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Full Name</span>
                                    <input class="readonly-color" type="text" name="full_name" value="<?php echo $full_name; ?>" placeholder=" Full Name" readonly>
                                </div>

                                <div class="input-box">
                                    <span class="details">Username</span>
                                    <input class="readonly-color" type="text" name="username" value="<?php echo $username; ?>" placeholder=" Username" readonly>
                                </div>

                                <div class="input-box password">
                                    <span class="details">Password</span>
                                    <div class="password-container">
                                        <input class="readonly-color" type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder=" Password" readonly>
                                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                                    </div>
                                </div>

                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input class="readonly-color" type="text" name="email" value="<?php echo $email; ?>" placeholder=" Email" readonly>
                                </div>

                                <div class="input-box">
                                    <span class="details">Ph No.</span>
                                    <input class="readonly-color" type="text" name="ph_no" value="<?php echo $ph_no; ?>" placeholder=" Phone Number" readonly>
                                </div>
                            </div>

                            <!-- Address -->
                            <span class="title-name">Address Details</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <input class="readonly-color" type="text" name="address" value="<?php echo $address; ?>" placeholder=" Floor/Unit, Street" readonly>
                                </div>

                                <div class="input-box">
                                    <span class="details">Postal Code</span>
                                    <input class="readonly-color" type="text" name="postal_code" value="<?php echo $postal_code; ?>" placeholder=" Postal Code" readonly>
                                </div>

                                <div class="input-box">
                                    <span class="details">City</span>
                                    <input class="readonly-color" type="text" name="city" value="<?php echo $city; ?>" placeholder=" City" readonly>
                                </div>

                                <div class="input-box">
                                    <span class="details">State</span>
                                    <input class="readonly-color" type="text" name="state" value="<?php echo $state; ?>" placeholder=" State" readonly>
                                </div>

                                <div class="input-box">
                                    <span class="details">Country</span>
                                    <input class="readonly-color" type="text" name="country" value="<?php echo $country; ?>" placeholder=" Country" readonly>
                                </div>
                            </div>

                            <!-- Position & Status -->
                            <span class="title-name">Account Status</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Status</span>
                                    <input class="readonly-color" type="text" name="status" value="<?php echo $status; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            <!-- =================================================== Form Section =================================================== -->
        </div>
    </section>
    <script>
        window.onload = function() {
            var inputs = document.querySelectorAll('input[readonly]');
            inputs.forEach(function(input) {
                input.style.cursor = 'default';
            });
        }
    </script>
    <script src="../Style/show-hide.js"></script>
<?php include('Partials/footer.php'); ?>