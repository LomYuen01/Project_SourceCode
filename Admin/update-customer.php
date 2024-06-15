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

                if(isset($_GET['id'])) {
                    // Get the id of selected customer
                    $id = $_GET['id'];

                    // Create the Sql Query to Get the details
                    $sql = "SELECT a.full_name, a.username, a.password, a.image_name, a.ph_no, a.email , a.status, b.address, b.postal_code, b.city, b.state, b.country
                            FROM tbl_customer a 
                            LEFT JOIN tbl_customer_address b ON a.id = b.customer_id
                            WHERE a.id=$id";

                    // Execute the Query
                    $res = mysqli_query($conn, $sql);

                    if($res==TRUE) {
                        // Check whether the data is available or not
                        $count = mysqli_num_rows($res);

                        if($count > 0) {
                            // Get the Details
                            $i = 1;
                            while($row = mysqli_fetch_assoc($res)) {
                                $full_name = $row['full_name'];
                                $username = $row['username'];
                                $password = $row['password'];
                                $current_image = $row['image_name'];
                                $ph_no = $row['ph_no'];
                                $email = $row['email'];
                                $status = $row['status'];
                            }
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
                <form id="update-customer-form" action="" method="POST" enctype="multipart/form-data" style="background: none; box-shadow: none;">
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

                                <div class="input-box" style="display: none;">
                                    <span class="details">IC</span>
                                    <input type="hidden" id="ic">
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
                            <?php
                                // Assuming $id is the customer's ID
                                $sql_address = "SELECT id, address, postal_code, city, state, country FROM tbl_customer_address WHERE customer_id=$id";
                                $res_address = mysqli_query($conn, $sql_address);

                                if($res_address==TRUE) {
                                    $count_address = mysqli_num_rows($res_address);

                                    if($count_address > 0) {
                                        $i = 1;
                                        while($row_address = mysqli_fetch_assoc($res_address)) {
                                            $address_id = $row_address['id'];
                                            $address = $row_address['address'];
                                            $postal_code = $row_address['postal_code'];
                                            $city = $row_address['city'];
                                            $state = $row_address['state'];
                                            $country = $row_address['country'];

                                            ?>
                                            <div class="half-width">
                                                <input type="hidden" name="address_id[]" value="<?php echo $address_id; ?>">

                                                <div class="input-box">
                                                    <span class="details">Address #<?php echo $i; ?></span>
                                                    <input type="text" name="address[]" value="<?php echo $address; ?>" required>
                                                </div>

                                                <div class="input-box">
                                                    <span class="details">Postal Code</span>
                                                    <input type="text" name="postal_code[]" value="<?php echo $postal_code; ?>" placeholder=" Postal Code" required>
                                                </div>

                                                <div class="input-box">
                                                    <span class="details">City</span>
                                                    <input type="text" name="city[]" value="<?php echo $city; ?>" placeholder=" City" required>
                                                </div>

                                                <div class="input-box">
                                                    <span class="details">State</span>
                                                    <input type="text" name="state[]" value="<?php echo $state; ?>" placeholder=" State" required>
                                                </div>

                                                <div class="input-box">
                                                    <span class="details">Country</span>
                                                    <input type="text" name="country[]" value="<?php echo $country; ?>" placeholder=" Country" required>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        }
                                    } else {
                                        echo "<div class='error' style='margin-left: 15px; margin-bottom: 25px;'>No address found for this customer.</div>";
                                    }
                                }
                            ?>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateCustomerForm = document.querySelector('#update-customer-form');

            updateCustomerForm.addEventListener('submit', (event) => {
                event.preventDefault();

                // Send the form data to the server using AJAX
                const formData = new FormData(updateCustomerForm);

                // Add the submit field manually
                formData.append('submit', 'Update Customer');

                fetch('Process/process-update-customer.php', {
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
                            window.location.href = 'manage-customer.php';
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