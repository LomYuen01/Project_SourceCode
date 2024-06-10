<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">Add Worker</div>
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
                            <!--<span class="details">Lom Yuen [Worker]</span>-->
                        </div>
                    </section>
                    
                    <section class="profile-form" data-title="Profile Details">
                        <div class="profile-details">
                            <!-- Personal Details -->
                            <span class="title-name">Personal Information</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Full Name</span>
                                    <input type="text" name="full_name" value="" placeholder=" Full Name" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">IC</span>
                                    <input type="text" name="IC" value="" placeholder=" IC" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="text" name="email" value="" placeholder=" Email" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Ph No.</span>
                                    <input type="text" name="ph_no" value="" placeholder=" Phone Number" required>
                                </div>
                            </div>

                            <!-- Address -->
                            <span class="title-name">Address Details</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <input type="text" name="address" value="" placeholder=" Floor/Unit, Street" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Postal Code</span>
                                    <input type="text" name="postal_code" value="" placeholder=" Postal Code" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">City</span>
                                    <input type="text" name="city" value="" placeholder=" City" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">State</span>
                                    <input type="text" name="state" value="" placeholder=" State" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Country</span>
                                    <input type="text" name="country" value="" placeholder=" Country" required>
                                </div>
                            </div>

                            <!-- Position & Status -->
                            <span class="title-name">Position & Status</span>
                            <div class="dropdown2">
                                <div class="position">
                                    <span class="text">Position</span>
                                    <select name="position" style="font-size: 14px; font-weight: 500;">
                                        <option value="Worker">Worker</option>
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
                                <input type="submit" name="submit" value="Add Worker" class="btn-secondary">
                            </div>
                        </div>
                    </section>
                </form>
            <!-- =================================================== Form Section =================================================== -->
        </div>
    </section>
    <script>
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
        $IC = mysqli_real_escape_string($conn, $_POST['IC']);
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Get the address details from Form
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);

        // Check if the full_name, username, IC, ph_no, email already exists
        $fields_to_check = ['full_name', 'username', 'IC', 'ph_no', 'email'];
        foreach($fields_to_check as $field) {
            $value = $$field;  // get the value of the variable with the name contained in $field
            $sql_check = "SELECT * FROM tbl_worker WHERE $field = '$value'";
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
                            window.location.href = '".SITEURL."admin/add-worker.php';
                        }
                    });
                </script>";
                exit;
            }
        }

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
                                window.location.href = '".SITEURL."admin/add-worker.php';
                            }
                        });
                    </script>";
                    exit; 
                }
            }
        }
        else
        {
            $image_name = "";  // Default Value
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

            // SQL Query to save the worker details into tbl_worker
            $sql_worker = "INSERT INTO tbl_worker SET
                full_name = '$full_name',
                IC = '$IC',
                ph_no = '$ph_no',
                email = '$email',
                address_id = '$address_id',
                position = '$position',
                status = '$status',
                image_name = '$image_name'
            ";

            // Executing Query and Saving Data into tbl_worker
            $res_worker = mysqli_query($conn, $sql_worker) or die(mysqli_error());

            // Check whether the (Query is executed) data is inserted or not and display appropriate message
            if($res_worker==TRUE)
            {
                // Data Inserted
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Worker Added Successfully.',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."Admin/manage-worker.php';
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
                        text: 'Failed to Add Worker. Try Again Later.',
                        icon: 'error'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."Admin/add-worker.php';
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
                    text: 'Failed to Add Worker. Try Again Later.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."Admin/add-worker.php';
                    }
                });
            </script>";
        }
    }
?>