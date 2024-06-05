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

                if(isset($_SESSION['upload'])) 
                {
                    echo $_SESSION['upload'];  
                    unset($_SESSION['upload']);  
                }

                if(isset($_SESSION['update'])) 
                {
                    echo $_SESSION['update'];  
                    unset($_SESSION['update']);  
                }

                if(isset($_SESSION['failed-remove'])) 
                {
                    echo $_SESSION['failed-remove'];  
                    unset($_SESSION['failed-remove']);  
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
                            $_SESSION['user-not-found'] = "<div class='error error-text-shadow'> Driver Information Not Found. </div>";
                    
                            // Redirect to Manage driver Page
                            header('location:'.SITEURL.'admin/manage-driver.php');
                        }
                    }
                }
                else
                {
                    // Redirect to Manage driver Page
                    header('location:'.SITEURL.'admin/manage-driver.php');
                }
            ?>
            <div class="error" id="errorMessage" style="display: none;"></div>
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
                            <div class="icon-border">
                                <i class='bx bx-camera icon' title="Choose an Image" id="image_icon"></i>
                                <input type="file" id="fileInput" name="image" style="display: none;">
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
                                        <input class="readonly-color" type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder=" Password" required>
                                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                                    </div>
                                </div>

                                <div class="input-box">
                                    <span class="details">IC</span>
                                    <input type="text" name="IC" id="IC" value="<?php echo $IC; ?>" placeholder=" IC" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder=" Email" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Ph No.</span>
                                    <input type="text" name="ph_no" value="<?php echo $ph_no; ?>" placeholder=" Phone Number" required>
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
                                        <option value="Driver" <?php echo $position == 'Driver' ? 'selected' : ''; ?>>Driver</option>
                                    </select>
                                </div>

                                <div class="status">
                                    <span class="text">Status</span>
                                    <select name="status" style="font-size: 14px; font-weight: 500;">
                                        <option value="Active" <?php echo $status == 'Active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="Inactive" <?php echo $status == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
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
    <script> 
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

        document.getElementById('IC').addEventListener('keyup', function (e) {
            var value = e.target.value;
            value = value.replace(/-/g, '');
            if (value.length > 6) {
                value = value.slice(0, 6) + '-' + value.slice(6);
            }
            if (value.length > 9) {
                value = value.slice(0, 9) + '-' + value.slice(9);
            }
            // Limit input to 12 characters
            if (value.length > 12) {
                value = value.slice(0, 14);
            }
            e.target.value = value;
        });

        const fileInput = document.getElementById('fileInput');
        const errorMessage = document.getElementById('errorMessage');
        const icon = document.getElementById('image_icon');

        icon.addEventListener('click', () => {
        fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            const image = new Image();

            image.onload = function() {
            if (this.width !== this.height) {
                errorMessage.textContent = 'Please upload an image with equal width and height.';
                errorMessage.style.display = 'block';
            } else {
                errorMessage.style.display = 'none';

                const reader = new FileReader();
                reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
            };

            image.src = URL.createObjectURL(file);
        });
    </script>
    <script src="../Style/show-hide.js"></script>
<?php include('Partials/footer.php'); ?>

<?php
    if(isset($_POST['submit']))
    {
        // Get the data from Form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
        $IC = mysqli_real_escape_string($conn, $_POST['IC']);
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $license_classification = mysqli_real_escape_string($conn, $_POST['license_classification']);
        $submitted_license_types = isset($_POST['license_type']) ? $_POST['license_type'] : [];
        $license_exp_date = mysqli_real_escape_string($conn, $_POST['license_exp_date']);

        // Get the address details from Form
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);

        // Get the IDs of the records to update
        $driver_id = mysqli_real_escape_string($conn, $_POST['driver_id']);
        $address_id = mysqli_real_escape_string($conn, $_POST['address_id']);

        // 2. Upload the Image if selected
        // Check whether the select image is clicked or not and upload the image only if the image is selected
        if(isset($_FILES['image']['name']))
        {
            // Get the details of the selected image
            $image_name = $_FILES['image']['name'];

            // Check whether the image is selected or not and upload image only if selected
            if($image_name != "")
            {
                // Image is selected
                // A. Rename the image

                // ---------- If image exist, it will add a suffix to the image name ---------- //
                        
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $base_name = basename($image_name, ".".$ext);
                
                    // Start with no suffix
                    $suffix = '';
                    $index = 1;
                
                    // While a file with the current name exists, increment the suffix
                    while(file_exists("../images/Profile/" . $base_name . $suffix . '.' . $ext)) 
                    {
                        $suffix = '(' . $index++ . ')';
                    }
            
                    // Set the image name to the base name plus the suffix
                    $image_name = $base_name . $suffix . '.' . $ext;

                // ---------------------------------------------------------------------------- //

                $source_path = $_FILES['image']['tmp_name'];  

                $destination_path = "../images/Profile/".$image_name;

                // B. Upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Check whether the image is uploaded or not
                // If its not, we will stop the process and redirect with error message
                if($upload == FALSE)
                {
                    $_SESSION['upload'] = "<div class='error'> Failed to Upload Image. </div>";
                    header('location:'.SITEURL.'admin/manage-driver.php');
                    die(); // Stop the Process
                }

                // Remove the current image if it exists
                if($current_image != "")
                {
                    $remove_path = "../images/Profile/".$current_image;
                    $remove = unlink($remove_path);

                    // Check whether the image is removed or not
                    // If failed to remove, display message and stop the process
                    if($remove==FALSE)
                    {
                        $_SESSION['failed-remove'] = "<div class='error'> Failed to remove current Image. </div>";
                        header('location:'.SITEURL.'admin/manage-driver.php');
                        die(); // Stop the Process
                    }
                }
            }
            else
            {
                $image_name = $current_image;
            }
        }
        else
        {
            $current_image = $current_image;  // Default Value
        }

        // SQL Query to update the address details in tbl_address
        $sql_address = "UPDATE tbl_address SET
            address = '$address',
            postal_code = '$postal_code',
            city = '$city',
            state = '$state',
            country = '$country'
            WHERE id = $address_id
        ";

        // Executing Query and Updating Data in tbl_address
        $res_address = mysqli_query($conn, $sql_address) or die(mysqli_error());

        // Check whether the (Query is executed) data is updated or not
        if($res_address==TRUE)
        {
            // Data Updated
            // SQL Query to update the driver details in tbl_driver
            $sql_driver = "UPDATE tbl_driver SET
                full_name = '$full_name',
                username = '$username',
                IC = '$IC',
                ph_no = '$ph_no',
                email = '$email',
                address_id = '$address_id',
                position = '$position',
                status = '$status',
                image_name = '$image_name',
                license_classification = '$license_classification',
                license_exp_date = '$license_exp_date'
                WHERE id = $driver_id
            ";

            // Executing Query and Updating Data in tbl_driver
            $res_driver = mysqli_query($conn, $sql_driver) or die(mysqli_error());

            // Check whether the (Query is executed) data is updated or not and display appropriate message
            if($res_driver==TRUE)
            {
                // Data Updated

                // Delete all existing license types for this driver
                $sql_delete_license = "DELETE FROM tbl_license_type WHERE driver_id=$driver_id";
                $res_delete_license = mysqli_query($conn, $sql_delete_license);

                // Insert the new license types
                foreach ($submitted_license_types as $type) {
                    $type = mysqli_real_escape_string($conn, $type);  // Escape each license type here
                    $sql_insert_license = "INSERT INTO tbl_license_type (driver_id, license_type) VALUES ($driver_id, '$type')";
                    $res_insert_license = mysqli_query($conn, $sql_insert_license);
                }

                // Create a Session Variable to Display Message
                $_SESSION['update'] = "<div class='success success-text-shadow' style='color: white;'> Driver Updated Successfully. </div>";

                // Redirect to Manage Driver Page
                header("location:".SITEURL.'admin/manage-driver.php');
            }
            else
            {
                // Failed to Update Data
                // Create a Session Variable to Display Message
                $_SESSION['update'] = "<div class='error error-text-shadow' style='color: white;'> Failed to Update Driver. Try Again Later. </div>";

                // Redirect to Manage Driver Page
                header("location:".SITEURL.'admin/manage-driver.php');
            }
        }
        else
        {
            // Failed to Update Data
            // Create a Session Variable to Display Message
            $_SESSION['update'] = "<div class='error error-text-shadow' style='color: white;'> Failed to Update Address. Try Again Later. </div>";

            // Redirect to Manage Driver Page
            header("location:".SITEURL.'admin/manage-driver.php');
        }
    }
ob_end_flush();
?>