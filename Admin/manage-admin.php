<?php include('Partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="mainContent">
            <div class="wrapper">
                <h1>Manage Admin</h1>

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo "<br />" . nl2br($_SESSION['add']);
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo "<br />" . nl2br($_SESSION['delete']);
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo "<br />" . nl2br($_SESSION['update']);
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo "<br />" . nl2br($_SESSION['user-not-found']);
                        unset($_SESSION['user-not-found']);
                    }

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo "<br />" . nl2br($_SESSION['pwd-not-match']);
                        unset($_SESSION['pwd-not-match']);
                    }

                    if(isset($_SESSION['change-pwd']))
                    {
                        echo "<br />" . nl2br($_SESSION['change-pwd']);
                        unset($_SESSION['change-pwd']);
                    }
                ?>

                <br><br>

                <!-- Button to Add Admin -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>

                <br /><br /><br />

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php 
                        // Query to Get All Admin
                        $sql = "SELECT * FROM tbl_admin";

                        // Execute the Query
                        $res = mysqli_query($conn, $sql);

                        // Check whether the query is executed or not
                        if($res==TRUE)
                        {
                            // Count rows to check if we have data in database or not
                            $count = mysqli_num_rows($res);

                            $SN = 1;

                            // Check the num of rows
                            if($count > 0)
                            {
                                // We have data in database
                                while($rows = mysqli_fetch_assoc($res))
                                {
                                    // Using while loop to get all the data from the database & will run as long as there is data in database
                                    $id = $rows['id'];
                                    $full_name = $rows['full_name'];
                                    $username = $rows['username'];

                                    // Display the values in the table
                                    ?>

                                    <tr>
                                        <td><?php echo $SN++; ?></td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            else
                            {
                                // We do not have data in database
                            }
                        }
                    ?>

                </table>

            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('Partials/footer.php'); ?>