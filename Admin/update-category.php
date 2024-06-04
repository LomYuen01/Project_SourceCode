<?php include('Partials/menu.php'); ?>
    <?php
        if (isset($_GET['id'])) {
            $category_id = $_GET['id'];
            // Use $category_id to pre-fill the category field in the form
        }
    ?>

    <section class="home" style="overflow: hidden;">
        <div class="title">
            <div class="text">Update Category</div>

            <?php
                if(isset($_SESSION['update'])) 
                {
                    echo $_SESSION['update'];  
                    unset($_SESSION['update']);  
                }

                if(isset($_GET['id'])) {
                    $category_id = $_GET['id'];
            
                    // Get the category details
                    $sql = "SELECT * FROM tbl_category WHERE id = $category_id";
                    $res = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $status = $row['active'];
            
                    // Get the category variations
                    $sql = "SELECT * FROM tbl_store_variation WHERE category_id = $category_id";
                    $res = mysqli_query($conn, $sql);
                    $variations = array();
                    while($row = mysqli_fetch_assoc($res)) {
                        $variations[] = $row['name'];
                    }
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->

        <div class="table" style="padding-left: 25px;">
            <form action="" method="POST" style="width: 40%">
                <div class="category-container" data-title="Category Details">
                    <div class="category-details">
                        <div class="input-box">
                            <span class="details">Category Name</span>
                            <input type="text" name="title" value="<?php echo $title; ?>" placeholder="Category Name" required>
                        </div>

                        <div id="variations" class="input-box">
                            <div class="box" style="display: flex; justify-content: space-between; margin-top: 8px;">
                                <span class="details">Variations</span>
                                <div class="button-container">
                                    <button type="button" class="addVariation" title="Add Variation" onclick="addVariation()">+</button>
                                </div>
                            </div>
                            <div class="variation-inputs" style="width: 100%;">
                                <?php
                                // Check if there are any variations
                                if(!empty($variations)) {
                                    // Loop through the variations and create an input for each one
                                    foreach($variations as $variation): ?>
                                        <div class="input-group">
                                            <input type="text" name="variations[]" value="<?php echo $variation; ?>" placeholder="Food Variation" required>
                                            <button type="button" class="remove-button" title="Remove Variation" onclick="removeVariation(this)">-</button>
                                        </div>
                                    <?php endforeach;
                                } else {
                                    // No variations, display the two default inputs
                                    for($i = 0; $i < 2; $i++): ?>
                                        <div class="input-group">
                                            <input type="text" name="variations[]" value="" placeholder="Food Variation" required>
                                            <button type="button" class="remove-button" title="Remove Variation" onclick="removeVariation(this)">-</button>
                                        </div>
                                    <?php endfor;
                                }
                                ?>
                            </div>
                        </div>

                        <div class="dropdown2">
                            <div class="status" style="margin: 0; margin-top: 8px;">
                                <span class="details">Status</span>
                                <select name="status" style="font-size: 14px; font-weight: 500;">
                                    <option value="Yes" <?php echo $status == 'Yes' ? 'selected' : ''; ?>>Active</option>
                                    <option value="No" <?php echo $status == 'No' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="button" style="left: 0; padding-bottom: 0">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </div>
                    </div>
                </div>
            </form>

            <div class="show-food-container" data-title="Food Details - Category <?php echo $title ?>">
                <div class="item-details" style="height: 1200%;"> <!-- Fixed Size, Scrollable -->
                    <table>
                        <thead>
                            <tr>
                                <th><span class="cursor_pointer">No.<span class="icon-arrow"></span></span></th>
                                <th><span class="cursor_pointer">Product<span class="icon-arrow"></span></span></th>
                                <th><span class="cursor_pointer">Status<span class="icon-arrow"></span></span></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $SN = 1; // Initialize the serial number
                            $sql = "SELECT * FROM tbl_food WHERE category_id = $category_id";
                            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                            // Count the rows
                            $count = mysqli_num_rows($res);

                            if($count > 0)
                            {
                                // We have data in database
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    $title = $row['title'];
                                    $active = $row['active'];

                                    // Assign status based on the value of active
                                    $status = ($active == 'Yes') ? 'Active' : 'Inactive';
                                    $status_class = strtolower($status) . '_status';
                                ?>
                                    <tr>
                                        <td><?php echo str_pad($SN++, 2, '0', STR_PAD_LEFT); ?></td>
                                        <td><?php echo $title; ?></td>
                                        <td><div class="<?php echo $status_class; ?>"><?php echo $status; ?></div></td>
                                    </tr>
                                <?php
                                }
                            }
                            else
                            {
                                // We do not have data in database
                                echo "<tr> <td colspan='3'> <div class='error'> No Food Added </div> </td> </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="order-summary"> <!-- Below item-details, scroll based on order-container -->
                    <div class="total-price" style="justify-content: flex-start;">
                        <span>Total Food:</span>
                        <span>&nbsp;<?php echo $count; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function addVariation() {
            // Create a new div element
            var newDiv = document.createElement("div");
            newDiv.className = "input-group";

            // Create a new input element
            var newInput = document.createElement("input");
            newInput.type = "text";
            newInput.name = "variations[]";
            newInput.placeholder = "Food Variation";    

            // Create a new button element
            var newButton = document.createElement("button");
            newButton.className = "remove-button";
            newButton.title = "Remove Variation";
            newButton.innerHTML = "-";
            newButton.onclick = function() {
                removeVariation(newButton);
            };

            // Add the new input and button to the new div
            newDiv.appendChild(newInput);
            newDiv.appendChild(newButton);

            // Add the new div to the variations div
            var variationsDiv = document.querySelector(".variation-inputs");
            variationsDiv.appendChild(newDiv);
        }

        function removeVariation(button) {
            // Remove the parent div of the button
            button.parentNode.remove();
        }
    </script>
<?php include('Partials/footer.php'); ?>

<?php
    if(isset($_POST['submit']))
    {
        // Get the data from Form
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $variations = $_POST['variations'];

        // SQL Query to update the category details in tbl_category
        $sql_category = "UPDATE tbl_category SET
            title = '$title',
            active = '$status'
            WHERE id = $category_id
        ";

        // Executing Query and Updating Data in tbl_category
        $res_category = mysqli_query($conn, $sql_category) or die(mysqli_error());

        // Check whether the (Query is executed) data is updated or not
        if($res_category==TRUE)
        {
            // Data Updated

            // Get all existing variations from the database
            $sql_existing = "SELECT name FROM tbl_store_variation WHERE category_id = $category_id";
            $res_existing = mysqli_query($conn, $sql_existing) or die(mysqli_error());
            $existing_variations = mysqli_fetch_all($res_existing, MYSQLI_ASSOC);

            // Loop through the existing variations and delete the ones that are not in the form data
            foreach($existing_variations as $existing_variation) {
                if(!in_array($existing_variation['name'], $variations)) {
                    $sql_delete = "DELETE FROM tbl_store_variation WHERE category_id = $category_id AND name = '{$existing_variation['name']}'";
                    $res_delete = mysqli_query($conn, $sql_delete) or die(mysqli_error());
                }
            }

            // Loop through the variations and update or insert each one into the tbl_store_variation table
            foreach($variations as $variation) {
                $variation = mysqli_real_escape_string($conn, $variation);

                // Check if the variation already exists
                $sql_check = "SELECT * FROM tbl_store_variation WHERE category_id = $category_id AND name = '$variation'";
                $res_check = mysqli_query($conn, $sql_check) or die(mysqli_error());
                if(mysqli_num_rows($res_check) > 0) {
                    // The variation exists, update it
                    $sql_variation = "UPDATE tbl_store_variation SET
                        name = '$variation'
                        WHERE category_id = $category_id AND name = '$variation'
                    ";
                } else {
                    // The variation doesn't exist, insert it
                    $sql_variation = "INSERT INTO tbl_store_variation SET
                        category_id = '$category_id',
                        name = '$variation'
                    ";
                }

                // Executing Query and Updating or Inserting Data into tbl_store_variation
                $res_variation = mysqli_query($conn, $sql_variation) or die(mysqli_error());

                // Check whether the (Query is executed) data is updated or inserted or not and display appropriate message
                if($res_variation==FALSE)
                {
                    // Failed to Update or Insert Data
                    // Create a Session Variable to Display Message
                    $_SESSION['add'] = "<div class='error'> Failed to Update Variation. Try Again Later. </div>";

                    // Redirect to Update Category Page
                    header("location:".SITEURL.'admin/update-category.php?id='.$category_id);
                    exit();  // Terminate the script execution if a variation fails to update or insert
                }
            }

            // If all variations updated or inserted successfully, redirect to Manage Category Page
            $_SESSION['add'] = "<div class='success'> Category Updated Successfully. </div>";
            header("location:".SITEURL.'admin/manage-category.php');
        }
        else
        {
            // Failed to Update Data
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='error'> Failed to Update Category. Try Again Later. </div>";

            // Redirect to Update Category Page
            header("location:".SITEURL.'admin/update-category.php?id='.$category_id);
        }
    }
?>