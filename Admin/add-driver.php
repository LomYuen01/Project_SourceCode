<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">Add Driver</div>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container">
            <!-- =================================================== Form Section =================================================== -->
                <form action="" method="POST" enctype="multipart/form-data" style="background: none; box-shadow: none;">
                    <section class="profile-container">
                        <div class="profile-img">
                            <img src="../images/no_profile_pic.png" id="profileImage">
                            <div class="icon-border">
                                <i class='bx bx-camera icon' title="Choose an Image" id="image_icon"></i>
                                <input type="file" id="fileInput" name="image" style="display: none;">
                            </div>
                        </div>
                        <div class="user-details">
                            <span class="details" style="margin-top: 15px; margin-left: 27%;">Profile Picture</span>
                        </div>
                    </section>
                    
                    <section class="profile-form" data-title="Profile Details">
                        <div class="profile-details">
                            <!-- Personal Details -->
                            <span class="title-name">Personal Information</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Full Name</span>
                                    <input type="text" name="full_name" placeholder=" Full Name" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Username</span>
                                    <input type="text" name="username" placeholder=" Username" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">IC</span>
                                    <input type="text" name="IC" id="IC" placeholder=" IC" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="text" name="email" placeholder=" Email" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Ph No.</span>
                                    <input type="text" name="ph_no" placeholder=" Phone Number" required>
                                </div>
                            </div>

                            <!-- Address -->
                            <span class="title-name">Address Details</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <input type="text" name="address" placeholder=" Floor/Unit, Street" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Postal Code</span>
                                    <input type="text" name="postal_code" placeholder=" Postal Code" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">City</span>
                                    <input type="text" name="city" placeholder=" City" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">State</span>
                                    <input type="text" name="state" placeholder=" State" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Country</span>
                                    <input type="text" name="country" placeholder=" Country" required>
                                </div>
                            </div>

                            <!-- License Details -->
                            <span class="title-name">License Details</span>
                            <!-- Classification Driving License -->
                            <div class="dropdown3" style="left: 0;">
                                <div class="status" style="margin: 0; padding-right: 30px;">
                                    <span class="details">Classification Driving License</span>
                                    <select name="license_classification" style="margin-left: 0; font-size: 14px; font-weight: 500;">
                                        <option value="LDL">Learner’s Driving License (LDL)</option>
                                        <option value="PDL">Probationary Driving License (PDL)</option>
                                        <option value="CDL">Competent Driving License (CDL)</option>
                                        <option value="VDL">Vocational Driving License (VDL)</option>
                                        <option value="IDP">International Driving Permit (IDP)</option>
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
                                                echo "<div class='checkbox'>
                                                    <input type='checkbox' name='license_type[]' value='$type'>
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
                                <input type="submit" name="submit" value="Add driver" class="btn-secondary">
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
                        Swal.fire('Error!', 'Please upload an image with equal width and height.', 'error');
                    } else {
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
        $password = mysqli_real_escape_string($conn, $_POST['password']);  // Password Encryption with MD5
        $IC = mysqli_real_escape_string($conn, $_POST['IC']);
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $license_type = mysqli_real_escape_string($conn, $_POST['license_type']);
        $license_exp_date = mysqli_real_escape_string($conn, $_POST['license_exp_date']);

        // Check if the full_name, username, IC, ph_no, email already exists
        $fields_to_check = ['full_name', 'username', 'IC', 'ph_no', 'email'];
        foreach($fields_to_check as $field) {
            $value = $$field;  // get the value of the variable with the name contained in $field
            $sql_check = "SELECT * FROM tbl_driver WHERE $field = '$value'";
            $res_check = mysqli_query($conn, $sql_check) or die(mysqli_error());
            if($res_check->num_rows > 0) {
                // Field value already exists
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: '$field already Exists.',
                        icon: 'error'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."admin/add-driver.php';
                        }
                    });
                </script>";
                exit;
            }
        }
        
        // Get the address details from Form
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);

        // Upload the Image if selected
        if(isset($_FILES['image']['name']))
        {
            // Get the details of the selected image
            $image_name = $_FILES['image']['name'];

            // Check whether the image is selected or not and upload image only if selected
            if($image_name != "")
            {
                // Image is selected
                // A. Rename the image
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

                $source_path = $_FILES['image']['tmp_name'];  
                $destination_path = "../images/Profile/".$image_name;

                // B. Upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Check whether the image is uploaded or not
                // If its not, we will stop the process and redirect with error message
                if($upload == FALSE)
                {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to Upload Image.',
                            icon: 'error'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '".SITEURL."admin/add-driver.php';
                            }
                        });
                    </script>";
                    exit; 
                }
            }
        }
        else
        {
            $image_name = ""; 
        }

        // SQL Query to save the address details into tbl_address
        $sql_address = "INSERT INTO tbl_address SET
            address = '$address',
            postal_code = '$postal_code',
            city = '$city',
            state = '$state',
            country = '$country'
        ";

        // Executing Query and Saving Data into tbl_address
        $res_address = mysqli_query($conn, $sql_address) or die(mysqli_error());

        // Check whether the (Query is executed) data is inserted or not
        if($res_address==TRUE)
        {
            // Data Inserted
            // Get the ID of the inserted address row
            $address_id = mysqli_insert_id($conn);

            // SQL Query to save the driver details into tbl_driver
            $sql_driver = "INSERT INTO tbl_driver SET
                full_name = '$full_name',
                username = '$username',
                password = '$password',
                IC = '$IC',
                ph_no = '$ph_no',
                email = '$email',
                address_id = '$address_id',
                position = '$position',
                status = '$status',
                license_type = '$license_type',
                license_exp_date = '$license_exp_date',
                image_name = '$image_name'
            ";

            // Executing Query and Saving Data into tbl_driver
            $res_driver = mysqli_query($conn, $sql_driver) or die(mysqli_error());

            // Check whether the (Query is executed) data is inserted or not and display appropriate message
            if($res_driver==TRUE)
            {
                // Data Inserted
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Driver Added Successfully.',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."Admin/manage-driver.php';
                        }
                    });
                </script>";
            }
            else
            {
                // Failed to Insert Data
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to Add Driver. Try Again Later.',
                        icon: 'error'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."Admin/add-driver.php';
                        }
                    });
                </script>";
            }
        }
        else
        {
            // Failed to Insert Data
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to Add Driver. Try Again Later.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."Admin/add-driver.php';
                    }
                });
            </script>";
        }
    }
?>