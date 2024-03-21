
<?php include('Partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="mainContent">
            <div class="wrapper">
                <h1>Manage Food</h1>

                <?php
                    if(isset($_SESSION['add']))  // Checking whether the session is set or not
                    {
                        echo "<br />" . nl2br($_SESSION['add']);
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['upload']))  // Checking whether the session is set or not
                    {
                        echo "<br />" . nl2br($_SESSION['upload']);
                        unset($_SESSION['upload']);
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

                    if(isset($_SESSION['no-food-found']))  // Checking whether the session is set or not
                    {
                        echo "<br />" . nl2br($_SESSION['no-food-found']);
                        unset($_SESSION['no-food-found']);
                    }

                    if(isset($_SESSION['update']))  // Checking whether the session is set or not
                    {
                        echo "<br />" . nl2br($_SESSION['update']);
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['failed-remove']))  // Checking whether the session is set or not
                    {
                        echo "<br />" . nl2br($_SESSION['failed-remove']);
                        unset($_SESSION['failed-remove']);
                    }
                ?>

                <br /><br />

                <!-- Button to Add Food -->
                <!-- <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a> -->
                <h2 class="text-center">Categories</h2>
                <div class="button-center">
                    <div class="button-grid">
                        <?php
                            $sql = "SELECT * FROM tbl_category";
                            $res = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $title = $row['title'];
                                $active = $row['active'];

                                if ($active == 'Yes') {
                                    echo "<a href=\"".SITEURL."admin/add-food.php?category_id=$id\" class=\"btn-category\">$title</a>";
                                }
                            }
                        ?>
                    </div>
                </div>

                <br /><br /><br />

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Normal Price</th>
                        <th>Large Price</th>
                        <th>Image</th>
                        <!--<th>Category</th>-->
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        $sql = "SELECT tbl_food.*, tbl_category.title AS category_name 
                                FROM tbl_food 
                                INNER JOIN tbl_category ON tbl_food.category_id = tbl_category.id
                                ORDER BY tbl_category.id ASC, tbl_food.id ASC";
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
                                $normal_price = $row['normal_price'] == '0.00' ? '-' : $row['normal_price'];
                                $large_price = $row['large_price'] == '0.00' ? '-' : $row['large_price'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];

                            ?>

                                <tr>
                                    <td><?php echo $SN++; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $normal_price; ?></td>
                                    <td><?php echo $large_price; ?></td>

                                    <td>
                                        <?php 
                                            // Check whether image name is available
                                            if($image_name!="")
                                            {
                                                // Display the Image
                                                ?>

                                                    <img src="<?php echo SITEURL; ?>images/Food/<?php echo $image_name; ?>" width="100px">

                                                <?php
                                            }
                                            else
                                            {
                                                // Display the Message
                                                echo "<div class='error'>Image not Added</div>";
                                            }
                                        ?>
                                    </td>
                                    
                                    <!--<td><?php echo $row['category_name'] ?></td>-->
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                                    </td>
                                </tr>

                            <?php
                            }
                        }
                        else
                        {
                            // We do not have data in database

                                echo "<tr> <td colspan='7'> <div class='error'> No Food Added </div> </td> </tr>";
                        }
                    ?>

                    </table>

            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('Partials/footer.php'); ?>