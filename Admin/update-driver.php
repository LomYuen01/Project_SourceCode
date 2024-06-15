<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">Update Driver</div>

            <?php
                if (isset($_GET['id'])) 
                {
                    $driver_id = $_GET['id'];
                }

                if (isset($_GET['address_id'])) 
                {
                    $address_id = $_GET['address_id'];
                }

                if(isset($_GET['id'])) {
                    // Get the id of selected driver
                    $id = $_GET['id'];

                    // Create the Sql Query to Get the details
                    $sql = "SELECT a.*, ad.address, ad.postal_code, ad.city, ad.state, ad.country 
                            FROM tbl_driver a 
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
                            $license_classification = $row['license_classification'];
                            $license_exp_date = $row['license_exp_date'];
                    
                            $address = $row['address'];
                            $postal_code = $row['postal_code'];
                            $city = $row['city'];
                            $state = $row['state'];
                            $country = $row['country'];
                    
                            // Get license types from the new table
                            $sql_license = "SELECT license_type FROM tbl_license_type WHERE driver_id=$id";
                            $res_license = mysqli_query($conn, $sql_license);

                            $license_type = [];
                            while ($row_license = mysqli_fetch_assoc($res_license)) {
                                $license_type[] = $row_license['license_type'];
                            }
                    
                            // license_classification is a single value, so no need to convert it to an array
                            $license_classification = $row['license_classification'];
                        }
                        else
                        {
                            // Redirect to Manage driver Page with Session Message
                            echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Driver Information Not Found.',
                                    icon: 'error'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '".SITEURL."admin/manage-driver.php';
                                    }
                                });
                            </script>";
                        }
                    }
                }
                else
                {
                    // Redirect to Manage driver Page
                    header('location:'.SITEURL.'admin/manage-driver.php');
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container" style="overflow: visible;">
            <!-- =================================================== Form Section =================================================== -->
                <form id="update-driver-form" action="" method="POST" enctype="multipart/form-data" style="background: none; box-shadow: none;">
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
                            <div class="icon-border">
                                <i class='bx bx-camera icon' title="Choose an Image" id="image_icon"></i>
                                <input type="file" id="image" name="image" style="display: none;">
                            </div>
                        </div>
                        <div class="user-details">
                            <span class="details"><?php echo $full_name; ?> [Driver]</span>
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

                                <div class="input-box password">
                                    <span class="details">Password</span>
                                    <div class="password-container">
                                        <input type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder=" Password" required>
                                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                                    </div>
                                </div>

                                <div class="input-box">
                                    <span class="details">IC</span>
                                    <input type="text" id="ic" name="IC" value="<?php echo $IC; ?>" placeholder=" IC" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder=" Email" required>
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

                            <!-- License Details -->
                            <span class="title-name">License Details</span>
                            <!-- Classification Driving License -->
                            <div class="dropdown3" style="left: 0;">
                                <div class="status" style="margin: 0; padding-right: 30px;">
                                    <span class="details">Classification Driving License</span>
                                    <select name="license_classification" style="margin-left: 0; font-size: 14px; font-weight: 500;">
                                        <option value="LDL" <?php echo $license_classification == 'LDL' ? 'selected' : ''; ?>>Learner’s Driving License (LDL)</option>
                                        <option value="PDL" <?php echo $license_classification == 'PDL' ? 'selected' : ''; ?>>Probationary Driving License (PDL)</option>
                                        <option value="CDL" <?php echo $license_classification == 'CDL' ? 'selected' : ''; ?>>Competent Driving License (CDL)</option>
                                        <option value="VDL" <?php echo $license_classification == 'VDL' ? 'selected' : ''; ?>>Vocational Driving License (VDL)</option>
                                        <option value="IDP" <?php echo $license_classification == 'IDP' ? 'selected' : ''; ?>>International Driving Permit (IDP)</option>
                                    </select>
                                </div>

                                <div class="dropdown-license">
                                    <div class="status" style="width: 320px; margin: 0; margin-left: 32px; padding-right: 30px;">
                                        <span class="details">License Type</span>
                                        <button class="select-icon" style="font-size: 14px; font-weight: 500;">
                                            Select License Type
                                            <i class='bx bx-chevron-down'></i>
                                        </button>
                                    </div>

                                    <div class="menu-license" style="width: 291px; font-size: 14px;">
                                        <div class="checkbox-group">
                                            <?php
                                            $license_types = ['A', 'B', 'B1', 'B2', 'C', 'D', 'DA', 'M'];
                                            foreach ($license_types as $type) {
                                                $checked = in_array($type, $license_type) ? 'checked' : '';
                                                echo "<div class='checkbox'>
                                                    <input type='checkbox' name='license_type[]' value='$type' $checked>
                                                    <label for='$type'>$type</label>
                                                </div>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="half-width" style="margin-top: -15px; top: 0;">
                                <div class="input-box">
                                    <span class="details">License Expiry Date</span>
                                    <input type="date" name="license_exp_date" value="<?php echo $license_exp_date; ?>" placeholder=" License Expiry Date" required>
                                </div>
                            </div>

                            <!-- Position & Status -->
                            <span class="title-name">Position & Status</span>
                            <div class="dropdown2">
                                <div class="position">
                                    <span class="text">Position</span>
                                    <select name="position" style="font-size: 14px; font-weight: 500;">
                                        <option value="Driver">Driver</option>
                                    </select>
                                </div>

                                <div class="status">
                                    <span class="text">Status</span>
                                    <select name="status" style="font-size: 14px; font-weight: 500;">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="button">
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>">
                                <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">
                                <input type="submit" name="submit" value="Update driver" class="btn-secondary">
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
            const updateDriverForm = document.querySelector('#update-driver-form');

            updateDriverForm.addEventListener('submit', (event) => {
                event.preventDefault();

                // Send the form data to the server using AJAX
                const formData = new FormData(updateDriverForm);

                // Add the submit field manually
                formData.append('submit', 'Update Driver');

                fetch('Process/process-update-driver.php', {
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
                            window.location.href = 'manage-driver.php';
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

        document.querySelectorAll(".dropdown-license").forEach(dropdown => {
            const button = dropdown.querySelector(".select-icon");
            const menu = dropdown.querySelector(".menu-license");

            button.addEventListener("click", (event) => {
                event.preventDefault();
                menu.classList.toggle("menu-open-license");

                // Add or remove the 'flex' display property
                if (menu.style.display !== 'flex') {
                    menu.style.display = 'flex';
                } else {
                    menu.style.display = '';
                }
            });
        });
    </script>
<script src="../Style/input-validate.js"></script>
<script src="../Style/show-hide.js"></script>
<script src="../Style/sidebar.js"></script>