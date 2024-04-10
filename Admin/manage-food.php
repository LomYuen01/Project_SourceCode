<?php include('Partials/menu.php'); ?>

    <section class="home">
        <div class="title">
            <div class="text">Manage Foods</div>

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

                <div class="dropdown">
                    <label for="dropdown-nav-bar" class="dropdown-btn" title="Dropdown Nav Bar">
                        <i class='bx bx-plus icon'></i>    
                        Add Food
                    </label>
                    <input type="checkbox" id="dropdown-nav-bar">
                    <div class="dropdown-options">
                        <label>Categories &nbsp; &#10140;</label>
                        <?php
                            $sql = "SELECT * FROM tbl_category";
                            $res = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $title = $row['title'];
                                $active = $row['active'];

                                if ($active == 'Yes') {
                                    echo "<label for='dropdown-nav-bar'>";
                                    echo "<a href=\"".SITEURL."admin/add-food.php?category_id=$id\">Add to $title</a>";
                                    echo "</label>";
                                }
                            }
                        ?>
                    </div>
                </div>
            </section>
            <!-- =================================================== Header Section =================================================== -->

            <!-- ==================================================== Body Section ==================================================== -->
            <section class="table-body">
                <table>
                    <thead>
                        <tr>
                            <th> S.N. <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></th>
                            <th> Title <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></th>
                            <th> Normal Price <span class="icon-arrow"></span></th>
                            <th> Large Price <span class="icon-arrow"></span></th>
                            <th> Image <span class="icon-arrow"></span></th>
                            <th> Featured <span class="icon-arrow"></span></th>
                            <th> Active <span class="icon-arrow"></span></th>
                            <th> Actions <span class="icon-arrow"></span></th>
                        </tr>
                    </thead>
                    <tbody>
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
                                        <td><?php echo str_pad($SN++, 2, '0', STR_PAD_LEFT); ?></td>
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
                                        <td class="buttons">
                                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary"><i class='bx bxs-edit'></i></a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"><i class='bx bx-trash'></i></a>
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
                    </tbody>
                </table>
            </section>
            <!-- ==================================================== Body Section ==================================================== -->
        </div>
    </section>
    <script src="../Style/dropdown.js"></script>
<?php include('Partials/footer.php'); ?>