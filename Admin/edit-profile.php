<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">Edit Profile</div>

            <?php
                if (isset($_GET['id'])) 
                {
                    $admin_id = $_GET['id'];
                }

                if (isset($_GET['address_id'])) 
                {
                    $address_id = $_GET['address_id'];
                }

                if(isset($_GET['id'])) {
                    // Get the id of selected admin
                    $id = $_GET['id'];

                    // Create the Sql Query to Get the details
                    $sql = "SELECT a.*, ad.address, ad.postal_code, ad.city, ad.state, ad.country 
                            FROM tbl_admin a 
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
                            $IC = $row['IC'];
                            $ph_no = $row['ph_no'];
                            $email = $row['email'];
                            $position = $row['position'];
                            $status = $row['status'];

                            $address = $row['address'];
                            $postal_code = $row['postal_code'];
                            $city = $row['city'];
                            $state = $row['state'];
                            $country = $row['country'];
                        }
                        else
                        {
                            // Redirect to Manage Admin Page with Message
                            echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Admin Information Not Found.',
                                    icon: 'error'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '".SITEURL."admin/index.php';
                                    }
                                });
                            </script>";
                        }
                    }
                }
                else
                {
                    // Redirect to Manage Admin Page
                    header('location:'.SITEURL.'admin/index.php');
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container" style="overflow: visible;">
            <!-- =================================================== Form Section =================================================== -->
                <form id="edit-profile-form" action="" method="POST" enctype="multipart/form-data" style="background: none; box-shadow: none;">
                    <section class="profile-container">
                        <div class="profile-img">
                            <?php
                                if($current_image != "")
                                {
                                    // Display the Image
                                    $borderColor = $status == 'active' ? '#ff4757' : '#2ed573';
                                    echo "<img src='".SITEURL."images/Profile/".$current_image."' id='profileImage' style='border-color: $borderColor; border-width: 2.5px; border-style: solid;'>";
                                }
                                else
                                {
                                    // Display the default image
                                    echo "<img src='../images/no_profile_pic.png' id='profileImage'>";
                                }
                            ?>
                            <div class="icon-border">
                                <i class='bx bx-camera icon' title="Choose an Image" id="image_icon"></i>
                                <input type="file" id="image" name="image" style="display: none;">
                            </div>
                        </div>
                        <div class="user-details">
                            <span class="details"><?php echo $full_name; ?> [<?php echo $position; ?>]</span>
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
                                    <input type="text" name="full_name" value="<?php echo $full_name; ?>" placeholder=" Full Name" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Username</span>
                                    <input type="text" name="username" value="<?php echo $username; ?>" placeholder=" Username" required>
                                </div>

                                <div class="input-box password" style="display: none;">
                                    <span class="details">Password</span>
                                    <div class="password-container">
                                        <input type="hidden" id="password">
                                    </div>
                                </div>

                                <div class="input-box">
                                    <span class="details">IC</span>
                                    <input type="text" id="ic" name="IC" value="<?php echo $IC; ?>" placeholder=" IC" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="text" id="email" name="email" value="<?php echo $email; ?>" placeholder=" Email" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Ph No.</span>
                                    <input type="text" id="phone" name="ph_no" value="<?php echo $ph_no; ?>" placeholder=" Phone Number" required>
                                </div>
                            </div>

                            <!-- Address -->
                            <span class="title-name">Address Details</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <input type="text" name="address" value="<?php echo $address; ?>" placeholder=" Floor/Unit, Street" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Postal Code</span>
                                    <input type="text" name="postal_code" value="<?php echo $postal_code; ?>" placeholder=" Postal Code" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">City</span>
                                    <input type="text" name="city" value="<?php echo $city; ?>" placeholder=" City" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">State</span>
                                    <input type="text" name="state" value="<?php echo $state; ?>" placeholder=" State" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Country</span>
                                    <input type="text" name="country" value="<?php echo $country; ?>" placeholder=" Country" required>
                                </div>
                            </div>

                            <div class="button">
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                                <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">
                                <input type="submit" name="submit" value="Update Profile" class="btn-secondary">
                            </div>
                        </div>
                    </section>
                </form>
            <!-- =================================================== Form Section =================================================== -->
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editProfileForm = document.querySelector('#edit-profile-form');

            editProfileForm.addEventListener('submit', (event) => {
                event.preventDefault();

                // Send the form data to the server using AJAX
                const formData = new FormData(editProfileForm);

                // Add the submit field manually
                formData.append('submit', 'Update Profile');

                fetch('Process/process-edit-profile.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.text();  // Change this line
                })
                .then(text => {
                    console.log(text);  // Log the raw response text
                    const data = JSON.parse(text);  // Parse the text as JSON

                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success').then(() => {
                            window.location.href = 'index.php';
                        });
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', error.message, 'error');
                });
            });
        });
    </script>
<script src="../Style/input-validate.js"></script>
<script src="../Style/show-hide.js"></script>
<script src="../Style/sidebar.js"></script>