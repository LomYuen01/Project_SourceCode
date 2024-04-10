<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">Update Admin</div>

            <?php
                if(isset($_SESSION['update']))  // Checking whether the session is set or not
                {
                    echo nl2br($_SESSION['update']);
                    unset($_SESSION['update']);
                }

                // Get the id of selected admin
                $id = $_GET['id'];

                // Create the Sql Query to Get the details
                $sql = "SELECT * FROM tbl_admin WHERE id=$id";

                // Execute the Query
                $res = mysqli_query($conn, $sql);

                if($res==TRUE)
                {
                    // Check whether the data is available or not
                    $count = mysqli_num_rows($res);

                    if($count==1)
                    {
                        // Get the Details
                        $row = mysqli_fetch_assoc($res);
                        
                        $full_name = $row['full_name'];
                        $username = $row['username'];
                        $password = $row['password'];
                        $admin_role = $row['admin_role'];
                        $status = $row['status'];

                    }
                    else
                    {
                        // Redirect to Manage Admin Page
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container">
            <!-- =================================================== Header Section =================================================== -->
            <section class="table-form">
                <form action="" method="POST">
                    <div class="user-details">
                        <div class="half-width">
                            <div class="input-box">
                                <span class="details">Full Name</span>
                                <input type="text" name="full_name" value="<?php echo $full_name; ?>" required>
                            </div>
                            
                            <div class="input-box">
                                <span class="details">Username</span>
                                <input type="text" name="username" value="<?php echo $username; ?>" required>
                            </div>

                            <div class="input-box password">
                                <span class="details">Password</span>
                                <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
                                <i class="fa-solid fa-eye-slash pw-hide"></i>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown2">
                        <div class="admin_role">
                            <span class="text">Admin's Role</span>
                            <select name="admin_role" style="font-size: 14px; font-weight: 500;">
                                <option value="Superadmin" <?php echo ($admin_role == 'Superadmin') ? 'selected' : ''; ?> >Superadmin</option>
                                <option value="Admin" <?php echo ($admin_role == 'Admin') ? 'selected' : ''; ?> >Admin</option>
                            </select>
                        </div>

                        <div class="status">
                            <span class="text">Status</span>
                            <select name="status" style="font-size: 14px; font-weight: 500;">
                                <option value="Active" <?php echo ($status == 'Active') ? 'selected' : ''; ?> >Active</option>
                                <option value="Inactive" <?php echo ($status == 'Inactive') ? 'selected' : ''; ?> >Inactive</option>
                                <option value="Resigned" <?php echo ($status == 'Resigned') ? 'selected' : ''; ?> >Resigned</option>
                                <option value="On Leave" <?php echo ($status == 'On Leave') ? 'selected' : ''; ?> >On Leave</option>
                            </select>
                        </div>
                    </div>

                    <div class="button">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </div>
                </form>

            </section>
            <!-- =================================================== Header Section =================================================== -->
        </div>
    </section>
    <script src="../Style/show-hide.js"></script>
<?php include('Partials/footer.php'); ?>

<?php
    // Process the value from Form and save it in Database
    // Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button Clicked

        // 1. Get all values from Form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $admin_role = $_POST['admin_role'];
        $status = $_POST['status'];

        // 2. SQL Query to update Admin data into Database
        $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password',
            admin_role = '$admin_role',
            status = '$status'
            WHERE id = '$id'
        ";

        // 3. Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql);

        // 4. Check whether the (Query is executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            // Data Updated
            // Create a Session Variable to Display Message
            $_SESSION['update'] = "<div class='success'> Admin Updated Successfully. </div>";

            // Redirect to Manage Admin Page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // Failed to Update Data
            // Create a Session Variable to Display Message
            $_SESSION['update'] = "<div class='error'> Failed to Update Admin. Try Again Later. </div>";

            // Redirect to Manage Admin Page
            header("location:".SITEURL.'admin/update-admin.php');
        }
    }

?>