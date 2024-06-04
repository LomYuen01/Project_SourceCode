<?php include('Partials/menu.php'); ?>

    <section class="home">
        <div class="title">
            <div class="text">Add Category</div>

            <?php
                if(isset($_SESSION['add'])) 
                {
                    echo $_SESSION['add'];  
                    unset($_SESSION['add']);  
                }

                if (isset($_SESSION['duplicates'])) {
                    echo "<br />" . nl2br($_SESSION['duplicates']);
                    unset($_SESSION['duplicates']);
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
                            <input type="text" name="title" value="" placeholder="Category Name" required>
                        </div>

                        <div id="variations" class="input-box">
                            <div class="box" style="display: flex; justify-content: space-between; margin-top: 8px;">
                                <span class="details">Variations</span>
                                <div class="button-container">
                                    <button type="button" class="addVariation" title="Add Variation" onclick="addVariation()">+</button>
                                </div>
                            </div>
                            <div class="variation-inputs" style="width: 100%;">
                                <div class="input-group">
                                    <input type="text" name="variations[]" value="" placeholder="Food Variation" required>
                                    <button type="button" class="remove-button" title="Remove Variation" onclick="removeVariation(this)">-</button>
                                </div>
                                <div class="input-group">
                                    <input type="text" name="variations[]" value="" placeholder="Food Variation" required>
                                    <button type="button" class="remove-button" title="Remove Variation" onclick="removeVariation(this)">-</button>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown2">
                            <div class="status" style="margin: 0; margin-top: 8px;">
                                <span class="details">Status</span>
                                <select name="status" style="font-size: 14px; font-weight: 500;">
                                    <option value="Yes">Active</option>
                                    <option value="No">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="button" style="left: 0; padding-bottom: 0">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </div>
                    </div>
                </div>
            </form>
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

        // Check if the category name already exists
        $sql_check_category = "SELECT * FROM tbl_category WHERE title = '$title'";
        $res_check_category = mysqli_query($conn, $sql_check_category) or die(mysqli_error());
        if($res_check_category->num_rows > 0) {
            // Category name already exists
            $_SESSION['duplicates'] = "<div class='error'> Category Name already Exists. </div>";
            header('location:' . SITEURL . 'admin/add-category.php');
            exit;
        }

        // Check if any of the variations already exist
        foreach($variations as $variation) {
            $variation = mysqli_real_escape_string($conn, $variation);
            $sql_check_variation = "SELECT * FROM tbl_store_variation WHERE name = '$variation'";
            $res_check_variation = mysqli_query($conn, $sql_check_variation) or die(mysqli_error());
            if($res_check_variation->num_rows > 0) {
                // Variation already exists
                $_SESSION['duplicates'] = "<div class='error'> Variation already Exists. </div>";
                header('location:' . SITEURL . 'admin/add-category.php');
                exit;
            }
        }

        // SQL Query to save the category details into tbl_category
        $sql_category = "INSERT INTO tbl_category SET
            title = '$title',
            active = '$status'
        ";

        // Executing Query and Saving Data into tbl_category
        $res_category = mysqli_query($conn, $sql_category) or die(mysqli_error());

        // Check whether the (Query is executed) data is inserted or not
        if($res_category==TRUE)
        {
            // Data Inserted
            // Get the ID of the inserted category row
            $category_id = mysqli_insert_id($conn);

            // Loop through the variations and insert each one into the tbl_store_variation table
            foreach($variations as $variation) {
                $variation = mysqli_real_escape_string($conn, $variation);

                // SQL Query to save the variation details into tbl_store_variation
                $sql_variation = "INSERT INTO tbl_store_variation SET
                    category_id = '$category_id',
                    name = '$variation'
                ";

                // Executing Query and Saving Data into tbl_store_variation
                $res_variation = mysqli_query($conn, $sql_variation) or die(mysqli_error());

                // Check whether the (Query is executed) data is inserted or not and display appropriate message
                if($res_variation==FALSE)
                {
                    // Failed to Insert Data
                    // Create a Session Variable to Display Message
                    $_SESSION['add'] = "<div class='error'> Failed to Add Variation. Try Again Later. </div>";

                    // Redirect to Add Category Page
                    header("location:".SITEURL.'admin/add-category.php');
                    exit();  // Terminate the script execution if a variation fails to insert
                }
            }

            // If all variations inserted successfully, redirect to Manage Category Page
            $_SESSION['add'] = "<div class='success'> Category Added Successfully. </div>";
            header("location:".SITEURL.'admin/manage-category.php');
        }
        else
        {
            // Failed to Insert Data
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='error'> Failed to Add Category. Try Again Later. </div>";

            // Redirect to Add Category Page
            header("location:".SITEURL.'admin/add-category.php');
        }
    }
?>