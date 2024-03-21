
<?php include('Partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="mainContent">
            <div class="wrapper">
                <h1>Manage Category</h1>

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

                <br><br>

                <!-- Button to Add Category -->
                <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>

                <br /><br /><br />

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Food Size</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

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
                                    <td><?php echo $SN++; ?></td>
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
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
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

                </table>

            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('Partials/footer.php'); ?>