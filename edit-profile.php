<?php 
    ob_start(); 
    include('config/constant.php');
?>

<!DOCTYPE html>
    <head>
        <!-----===============| CSS |===============----->
        <link rel="stylesheet" href="Style/style-edit-profile.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-----===========| Boxicon CSS |===========----->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c6e0062d0c.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <section class="home">
            <div class="title">
                <div class="text">Edit Profile</div>

                <?php
                    if (isset($_GET['id'])) 
                    {
                        $customer_id = $_GET['id'];
                    }
                    if (empty($customer_id)) {header('Location: index.php');exit();}

                    // Check if the redirect_url is set in the POST data
                    if(isset($_POST['redirect_url'])) {
                        $redirect_url = $_POST['redirect_url'];
                    } else {
                        // Default redirect_url if it's not set
                        $redirect_url = SITEURL.'index.php';
                    }

                    if(isset($_GET['id'])) {
                        // Get the id of selected customer
                        $id = $_GET['id'];

                        // Create the Sql Query to Get the details
                        $sql = "SELECT a.full_name, a.username, a.image_name, a.ph_no, a.email , a.status
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
                                $current_image = $row['image_name'];
                                $ph_no = $row['ph_no'];
                                $email = $row['email'];
                                $status = $row['status'];
                            }
                            else
                            {
                                // Redirect to Manage customer Page with Session Message
                                $_SESSION['user-not-found'] = "<div class='error error-text-shadow'> Customer Information Not Found. </div>";
                        
                                // Redirect to Manage customer Page
                                header('location:'.$redirect_url);
                            }
                        }
                    }
                    else
                    {
                        // Redirect to Manage customer Page
                        header('location:'.$redirect_url);
                    }
                ?>
                <div class="error" id="errorMessage" style="display: none;"></div>
            </div>

            <!-- Break --><br><!-- Line -->
            
            <div class="form-container" style="overflow: visible;">
                <!-- =================================================== Form Section =================================================== -->
                    <form action="" method="POST" enctype="multipart/form-data" style="background: none; box-shadow: none;">
                    <a href="javascript:history.back()"><img src="Delivery/Icon/Back_Icon.png" class="icon" title="Back" style="margin-left: -20px;"></a>    
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
                                        echo "<img src='images/no_profile_pic.png' id='profileImage' style='border-color: $borderColor; border-width: 2.5px; border-style: solid;'>";
                                    }
                                ?>
                                <div class="icon-border">
                                    <i class='bx bx-camera icon' title="Choose an Image" id="image_icon"></i>
                                    <input type="file" id="fileInput" name="image" style="display: none;">
                                </div>
                            </div>
                            <div class="user-details">
                                <span class="details"><?php echo $full_name; ?> </span>
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

                                    <div class="input-box">
                                        <span class="details">Email</span>
                                        <input type="text" name="email" value="<?php echo $email; ?>" placeholder=" Email" required>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Ph No.</span>
                                        <input type="text" name="ph_no" value="<?php echo $ph_no; ?>" placeholder=" Phone Number" required>
                                    </div>
                                </div>
                            </div>

                            <div class="button" style="margin-left: 15px;">
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                                <input type="submit" name="submit" value="Update Profile" class="btn-secondary">
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
    </body>
</html>

<?php
    if(isset($_POST['submit']))
    {
        // Get the data from Form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Get the IDs of the records to update
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
                    while(file_exists("images/Profile/" . $base_name . $suffix . '.' . $ext)) 
                    {
                        $suffix = '(' . $index++ . ')';
                    }
            
                    // Set the image name to the base name plus the suffix
                    $image_name = $base_name . $suffix . '.' . $ext;

                // ---------------------------------------------------------------------------- //

                $source_path = $_FILES['image']['tmp_name'];  

                $destination_path = "images/Profile/".$image_name;

                // B. Upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Check whether the image is uploaded or not
                // If its not, we will stop the process and redirect with error message
                if($upload == FALSE)
                {
                     echo "<script>Swal.fire({icon: 'error',title: 'Error!',text: 'Failed to Upload Image.',confirmButtonText: 'OK'}).then((result) => {if (result.isConfirmed) {
                    
                     window.location.href = '".$redirect_url."';}});</script>";
                    die(); // Stop the Process
                }

                // Remove the current image if it exists
                if($current_image != "")
                {
                    $remove_path = "images/Profile/".$current_image;
                    $remove = unlink($remove_path);

                    // Check whether the image is removed or not
                    // If failed to remove, display message and stop the process
                    if($remove==FALSE)
                    {
                        echo "<script>Swal.fire({icon: 'error',title: 'Error!',text: 'Failed to remove current Image.',confirmButtonText: 'OK'}).then((result) => {if (result.isConfirmed) {
                    
                        window.location.href = '".$redirect_url."';}});</script>";
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
            ph_no = '$ph_no',
            email = '$email',
            image_name = '$image_name'
            WHERE id = $customer_id
        ";

        // Executing Query and Updating Data in tbl_customer
        $res_customer = mysqli_query($conn, $sql_customer) or die(mysqli_error());

        // Check whether the (Query is executed) data is updated or not and display appropriate message
        if($res_customer==TRUE)
        {
            // Data Updated
            // Create a Session Variable to Display Message
            echo "<script>Swal.fire({icon: 'success',title: 'Success!',text: 'Customer Updated Successfully.',confirmButtonText: 'OK'}).then((result) => {if (result.isConfirmed) {
                        
            // Redirect to Manage customer Page
            window.location.href = '".$redirect_url."';}});</script>";
        }
        else
        {
            // Failed to Update Data
            // Create a Session Variable to Display Message
            echo "<script>Swal.fire({icon: 'error',title: 'Error!',text: 'Failed to Update Customer. Try Again Later.',confirmButtonText: 'OK'}).then((result) => {if (result.isConfirmed) {
            
            // Redirect to Manage customer Page
            window.location.href = '".$redirect_url."';}});</script>";
        }
    }
ob_end_flush();
?>