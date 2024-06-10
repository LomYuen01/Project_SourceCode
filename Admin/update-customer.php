<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">Update customer</div>

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
                    $sql = "SELECT a.full_name, a.username, a.password, a.image_name, a.ph_no, a.email , a.status
                            FROM tbl_customer a 
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
                        }
                        else
                        {
                            // Redirect to Manage customer Page with Session Message
                            echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Customer Information Not Found.',
                                    icon: 'error'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '".SITEURL."admin/manage-customer.php';
                                    }
                                });
                            </script>";
                        }
                    }
                }
                else
                {
                    // Redirect to Manage customer Page
                    header('location:'.SITEURL.'customer/manage-customer.php');
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
                            <div class="icon-border">
                                <i class='bx bx-camera icon' title="Choose an Image" id="image_icon"></i>
                                <input type="file" id="image" name="image" style="display: none;">
                            </div>
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
                                    <span class="details">Email</span>
                                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder=" Email" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Ph No.</span>
                                    <input type="text" name="ph_no" value="<?php echo $ph_no; ?>" placeholder=" Phone Number" required>
                                </div>
                            </div>

                            <!-- Position & Status -->
                            <span class="title-name">Account Status</span>
                            <div class="dropdown2">
                                <div class="status">
                                    <span class="text">Status</span>
                                    <div class="input-box">
                                        <select name="status" style="font-size: 14px; font-weight: 500;">
                                            <option value="Active" <?php echo $status == 'Active' ? 'selected' : ''; ?>>Active</option>
                                            <option value="Inactive" <?php echo $status == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="button">
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                                <input type="submit" name="submit" value="Update customer" class="btn-secondary">
                            </div>
                        </div>
                    </section>
                </form>
            <!-- =================================================== Form Section =================================================== -->
        </div>
    </section>
    <script>
        const fileInput = document.getElementById('image');
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
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);

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
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to Upload Image.',
                            icon: 'error'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '".SITEURL."admin/manage-customer.php';
                            }
                        });
                    </script>";
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
                        echo "<script>
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to remove current Image.',
                                icon: 'error'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '".SITEURL."admin/manage-customer.php';
                                }
                            });
                        </script>";
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

        // Data Updated
        // SQL Query to update the customer details in tbl_customer
        $sql_customer = "UPDATE tbl_customer SET
            full_name = '$full_name',
            username = '$username',
            password = '$password',
            ph_no = '$ph_no',
            email = '$email',
            status = '$status',
            image_name = '$image_name'
            WHERE id = $customer_id
        ";

        // Executing Query and Updating Data in tbl_customer
        $res_customer = mysqli_query($conn, $sql_customer) or die(mysqli_error());

        // Check whether the (Query is executed) data is updated or not and display appropriate message
        if($res_customer==TRUE)
        {
            // Data Updated
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Customer Updated Successfully.',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."admin/manage-customer.php';
                    }
                });
            </script>";
        }
        else
        {
            // Failed to Update Data
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to Update Customer. Try Again Later.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."admin/manage-customer.php';
                    }
                });
            </script>";
        }
    }
?>