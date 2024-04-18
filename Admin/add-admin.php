<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">Add Admin</div>

            <?php
                if(isset($_SESSION['add']))  // Checking whether the session is set or not
                {
                    echo nl2br($_SESSION['add']);
                    unset($_SESSION['add']);
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container">
            <!-- =================================================== Form Section =================================================== -->
            <section class="table-form">
                <form action="" method="POST">
                    <div class="user-details">
                        <div class="half-width">
                            <div class="input-box">
                                <span class="details">Full Name</span>
                                <input type="text" name="full_name" placeholder="Full Name" required>
                            </div>
                            
                            <div class="input-box">
                                <span class="details">Username</span>
                                <input type="text" name="username" placeholder="Username" required>
                            </div>

                            <div class="input-box password">
                                <span class="details">Password</span>
                                <input type="password" id="password" name="password" placeholder="Password" required>
                                <i class="fa-solid fa-eye-slash pw-hide"></i>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown2">
                        <div class="admin_role">
                            <span class="text">Admin's Role</span>
                            <select name="admin_role" style="font-size: 14px; font-weight: 500;">
                                <option value="Superadmin">Superadmin</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>

                        <div class="status">
                            <span class="text">Status</span>
                            <select name="status" style="font-size: 14px; font-weight: 500;">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Resigned">Resigned</option>
                                <option value="On Leave">On Leave</option>
                            </select>
                        </div>
                    </div>

                    <div class="button">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </div>
                </form>

            </section>
            <!-- =================================================== Form Section =================================================== -->
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

        // 1. Get the data from Form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];  // Password Encryption with MD5
        $admin_role = $_POST['admin_role'];
        $status = $_POST['status'];

        // 2. SQL Query to save the data into Database
        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password',
            admin_role = '$admin_role',
            status = '$status'
        ";

        // 3. Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. Check whether the (Query is executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            // Data Inserted
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='success'> Admin Added Successfully. </div>";

            // Redirect to Manage Admin Page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // Failed to Insert Data
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='error'> Failed to Add Admin. Try Again Later. </div>";

            // Redirect to Manage Admin Page
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }
?>