<?php include('Partials/menu.php'); ?>

    <section class="home">
        <div class="title">
            <div class="text">Manage Category</div>

            <?php
                if(isset($_SESSION['add']))  // Checking whether the session is set or not
                {
                    echo "<br />" . nl2br($_SESSION['add']);
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['remove']))  // Checking whether the session is set or not
                {
                    echo "<br />" . nl2br($_SESSION['remove']);
                    unset($_SESSION['remove']);
                }

                if(isset($_SESSION['delete']))  // Checking whether the session is set or not
                {
                    echo "<br />" . nl2br($_SESSION['delete']);
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['no-category-found']))  // Checking whether the session is set or not
                {
                    echo "<br />" . nl2br($_SESSION['no-category-found']);
                    unset($_SESSION['no-category-found']);
                }

                if(isset($_SESSION['update']))  // Checking whether the session is set or not
                {
                    echo "<br />" . nl2br($_SESSION['update']);
                    unset($_SESSION['update']);
                }

                if(isset($_SESSION['upload']))  // Checking whether the session is set or not
                {
                    echo "<br />" . nl2br($_SESSION['upload']);
                    unset($_SESSION['upload']);
                }

                if(isset($_SESSION['failed-remove']))  // Checking whether the session is set or not
                {
                    echo "<br />" . nl2br($_SESSION['failed-remove']);
                    unset($_SESSION['failed-remove']);
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
                <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">
                    <i class='bx bx-plus icon'></i>
                    <span class="icon-text">Add Category</span>
                </a>

            </section>
            <!-- =================================================== Header Section =================================================== -->

            <!-- ==================================================== Body Section ==================================================== -->
            <section class="table-body">
                <table>
                    <thead>
                        <tr>
                            <th> S.N. <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></th>
                            <th> Title <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></th>
                            <th> Image <span class="icon-arrow"></i></span></th>
                            <th> Food Size <span class="icon-arrow"></i></span></th>
                            <th> Featured <span class="icon-arrow"></i></span></th>
                            <th> Active <span class="icon-arrow"></i></span></th>
                            <th> Actions <span class="icon-arrow"></i></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM tbl_category";
                            $res = mysqli_query($conn, $sql);

                            // Count the rows
                            $count = mysqli_num_rows($res);

                            $SN = 1;

                            if($count > 0)
                            {
                                // We have data in database
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    $image_name = $row['image_name'];
                                    $FoodSize = $row['FoodSize'];
                                    $featured = $row['featured'];
                                    $active = $row['active'];

                                ?>

                                    <tr>
                                        <td><?php echo str_pad($SN++, 2, '0', STR_PAD_LEFT); ?></td>
                                        <td><?php echo $title; ?></td>

                                        <td>
                                            <?php 
                                                // Check whether image name is available
                                                if($image_name!="")
                                                {
                                                    // Display the Image
                                                    ?>

                                                        <img src="<?php echo SITEURL; ?>images/Category/<?php echo $image_name; ?>" width="100px">

                                                    <?php
                                                }
                                                else
                                                {
                                                    // Display the Message
                                                    echo "<div class='error'>Image not Added</div>";
                                                }
                                            ?>
                                        </td>
                                        
                                        <td><?php echo $FoodSize; ?></td>
                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td class="buttons">
                                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary"><i class='bx bxs-edit'></i> Update Category</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"><i class='bx bx-trash'></i> Delete Category</a>
                                        </td>
                                    </tr>

                                <?php
                                }
                            }
                            else
                            {
                            // We do not have data in database
                            ?>

                                <tr>
                                    <td colspan="6"><div class="error">No Category Added</div></td>
                                </tr>

                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </section>
            <!-- ==================================================== Body Section ==================================================== -->
        </div>
    </section>

<?php include('Partials/footer.php'); ?>