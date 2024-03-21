<?php include('Partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="mainContent">
            <div class="wrapper">
                <h1>Update Admin</h1>

                <br><br>

                <?php
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
                        }
                        else
                        {
                            // Redirect to Manage Admin Page
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                ?>

                <form action="" method="POST">
                    <table class="tbl-30">
                        <tr>
                            <td>Full Name: </td>
                            <td>
                                <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Username: </td>
                            <td>
                                <input type="text" name="username" value="<?php echo $username; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                            </td>
                        </tr>
                    </table>

            </div>
        </div>
        <!-- Main Content Section Ends -->

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

                // 2. SQL Query to update Admin data into Database
                $sql = "UPDATE tbl_admin SET
                    full_name = '$full_name',
                    username = '$username'
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

<?php include('Partials/footer.php'); ?>