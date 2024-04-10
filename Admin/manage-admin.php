<?php include('Partials/menu.php'); ?>

    <section class="home">
        <div class="title">
            <div class="text">Manage Admin</div>

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
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="table">
            <!-- =================================================== Header Section =================================================== -->
            <section class="table-header">
                
                <span></span>

                <div class="input-group">
                    <input type="search" placeholder="Search Data...">
                    <i class='bx bx-search'></i>
                </div>
                <?php if ($admin_role == 'Superadmin') { ?>
                    <a href="<?php echo SITEURL; ?>admin/add-admin.php" class="btn-primary">
                        <i class='bx bx-plus icon'></i>
                        <span class="icon-text">Add Admin</span>
                    </a>
                <?php } else {echo "<span></span>"; } ?>
            </section>
            <!-- =================================================== Header Section =================================================== -->

            <!-- ==================================================== Body Section ==================================================== -->
            <section class="table-body">
                <table>
                    <thead>
                        <tr>
                            <th><span class="text">S.N. <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></span></th>
                            <th> Full Name <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></th>
                            <th> Username <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></th>
                            <th> Admin's Role <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></th>
                            <th> Status <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></th>
                            <?php if ($admin_role == 'Superadmin') { ?>
                                <th> Actions <span class="icon-arrow"></span></th>
                            <?php } echo "<th></th>"; ?>
                        </tr>
                    </thead>
                    <tbody>
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
                                        $admin_role = $rows['admin_role'];
                                        $status = $rows['status'];

                                        // Display the values in the table
                                        ?>
                                        <tr>
                                            <td><?php echo str_pad($SN++, 2, '0', STR_PAD_LEFT); ?></td>
                                            <td> <?php echo $full_name; ?> </td>
                                            <td> <?php echo $username; ?> </td>
                                            <td> <?php echo $admin_role; ?> </td>
                                            <td> <?php echo $status; ?> </td>
                                            <td class="buttons"> 
                                                <?php if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] == 'Superadmin') { ?>
                                                    <a href="<?php echo SITEURL; ?>Admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary" ><i class='bx bxs-edit'></i> Update Admin & Status</a>
                                                    <!-- --><a href="<?php echo SITEURL; ?>Admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger" ><i class='bx bx-trash'></i> Delete Admin</a> 
                                                <?php } ?>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                }
                                else
                                {
                                    // We do not have data
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </section>
            <!-- ==================================================== Body Section ==================================================== -->
        </div>
    </section>
    <script>

    </script>
<?php include('Partials/footer.php'); ?>