<?php include('Partials/menu.php'); ?>
    <?php
        if (isset($_GET['id'])) 
        {
            $food_id = $_GET['id'];
            // Use $id to pre-fill the form for updating the food item
        }
    
        if (isset($_SESSION['category_id'])) {
            $category_id = $_SESSION['category_id'];
        }
        
        // Process the value from Form and save it in Database
        if(isset($_POST['submit']))
        {
            // 1. Get the data from Form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $category = $_POST['category_id'];
            $current_image = $_POST['current_image'];
            $quantity = $_POST['quantity'];

            // Check if the category is active
            $sql = "SELECT active FROM tbl_category WHERE id = '$category'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);

            $normal_price = isset($_POST['normal_price']) ? $_POST['normal_price'] : 0;
            $large_price = isset($_POST['large_price']) ? $_POST['large_price'] : 0;
            $normal_active = isset($_POST['normal_active']) ? 'Yes' : 'No';
            $large_active = isset($_POST['large_active']) ? 'Yes' : 'No';

            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else
            {
                $featured = "No";  // Default Value
            }

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No";  // Default Value
            }

            if(isset($_POST['food_type']))
            {
                $food_type = $_POST['food_type'];
                foreach ($food_type as $selected) {
                    // Handle each selected value
                }
            }

            // 2. Upload the Image if selected
            // Check whether the select image is clicked or not and upload the image only if the image is selected
            if(isset($_FILES['image']['name']))
            {
                // Get the details of the selected image
                $image_name = $_FILES['image']['name'];

                // Check whether the image is selected or not and upload image only if selected
                if($image_name != "")
                {
                    // Image is selected
                    // A. Rename the image

                    // ---------- If image exist, it will add a suffix to the image name ---------- //
                            
                        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                        $base_name = basename($image_name, ".".$ext);
                    
                        // Start with no suffix
                        $suffix = '';
                        $index = 1;
                    
                        // While a file with the current name exists, increment the suffix
                        while(file_exists("../images/Food/" . $base_name . $suffix . '.' . $ext)) 
                        {
                            $suffix = '(' . $index++ . ')';
                        }
                
                        // Set the image name to the base name plus the suffix
                        $image_name = $base_name . $suffix . '.' . $ext;

                    // ---------------------------------------------------------------------------- //

                    $source_path = $_FILES['image']['tmp_name'];  

                    $destination_path = "../images/Food/".$image_name;

                    // B. Upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Check whether the image is uploaded or not
                    // If its not, we will stop the process and redirect with error message
                    if($upload == FALSE)
                    {
                        echo "<script>
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to Upload Image.',
                                icon: 'error'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '".SITEURL."admin/manage-food.php';
                                }
                            });
                        </script>";
                        die(); // Stop the Process
                    }

                    // Remove the current image if it exists
                    if($current_image != "")
                    {
                        $remove_path = "../images/Food/".$current_image;
                        $remove = unlink($remove_path);

                        // Check whether the image is removed or not
                        // If failed to remove, display message and stop the process
                        if($remove==FALSE)
                        {
                            echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to remove current Image.',
                                    icon: 'error'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '".SITEURL."admin/manage-food.php';
                                    }
                                });
                            </script>";
                            die(); // Stop the Process
                        }
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $current_image = $current_image;  // Default Value
            }

            // 3. Update Database

            // Escape special characters in a string for use in an SQL statement
            $title = mysqli_real_escape_string($conn, $title);
            $description = mysqli_real_escape_string($conn, $description);
            $normal_price = mysqli_real_escape_string($conn, $normal_price);
            $large_price = mysqli_real_escape_string($conn, $large_price);
            $quantity = mysqli_real_escape_string($conn, $quantity);
            $image_name = mysqli_real_escape_string($conn, $image_name);
            $category = mysqli_real_escape_string($conn, $category);
            $featured = mysqli_real_escape_string($conn, $featured);
            $active = mysqli_real_escape_string($conn, $active);
            $normal_active = mysqli_real_escape_string($conn, $normal_active);
            $large_active = mysqli_real_escape_string($conn, $large_active);

            // Create SQL Query to update food
            $sql2 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                normal_price = '$normal_price',
                large_price = '$large_price',
                quantity = '$quantity',
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active',
                normal_active = '$normal_active',
                large_active = '$large_active'
                WHERE id = '$id'
            ";

            // Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            // Check if the food was updated successfully
            if($res2 == TRUE)
            {
                $food_id = $id; // Get the ID of the updated row

                // Get existing food variations
                $sql3 = "SELECT name FROM tbl_food_variation WHERE food_id = $food_id";
                $res3 = mysqli_query($conn, $sql3);
                $existing_variations = array();
                while($row = mysqli_fetch_assoc($res3)) {
                    $existing_variations[] = $row['name'];
                }

                // Handle food variations
                $food_type = isset($_POST['food_type']) ? $_POST['food_type'] : array();
                foreach ($food_type as $selected) {
                    $selected = mysqli_real_escape_string($conn, $selected);
                    if(in_array($selected, $existing_variations)) {
                        // This variation exists, so we need to update it
                        $sql4 = "UPDATE tbl_food_variation SET active = 'Yes' WHERE food_id = $food_id AND name = '$selected'";
                        $res4 = mysqli_query($conn, $sql4);
                        if($res4 == FALSE) {
                            echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to Update Food Variation.',
                                    icon: 'error'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '".SITEURL."admin/manage-food.php';
                                    }
                                });
                            </script>";
                            exit;
                        }
                    } else {
                        // This variation does not exist, so we need to insert it
                        $sql4 = "INSERT INTO tbl_food_variation (food_id, name, active) VALUES ($food_id, '$selected', 'Yes')";
                        $res4 = mysqli_query($conn, $sql4);
                        if($res4 == FALSE) {
                            echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to Insert Food Variation.',
                                    icon: 'error'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '".SITEURL."admin/manage-food.php';
                                    }
                                });
                            </script>";
                            exit;
                        }
                    }
                }

                // Now we need to handle unchecked variations
                $unchecked_variations = array_diff($existing_variations, $food_type);
                foreach ($unchecked_variations as $unchecked) {
                    $unchecked = mysqli_real_escape_string($conn, $unchecked);
                    $sql4 = "DELETE FROM tbl_food_variation WHERE food_id = $food_id AND name = '$unchecked'";
                    $res4 = mysqli_query($conn, $sql4);
                    if($res4 == FALSE) {
                        echo "<script>
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to Delete Food Variation.',
                                icon: 'error'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '".SITEURL."admin/manage-food.php';
                                }
                            });
                        </script>";
                        exit;
                    }
                }

                $_SESSION['food_id'] = $food_id;
                $_SESSION['category_id'] = $category_id;

                // Query Executed and Food Updated
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Food Updated Successfully.',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."admin/manage-food.php';
                        }
                    });
                </script>";
            }
            else
            {
                // Failed to Update Food
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to Update Food.',
                        icon: 'error'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."admin/manage-food.php';
                        }
                    });
                </script>";
                exit;
            }
        }
    ?>
    <section class="home">
        <div class="title">
            <div class="text">Update Food</div>

            <?php
                if(isset($_SESSION['upload'])) 
                {
                    echo $_SESSION['upload'];  
                    unset($_SESSION['upload']);  
                }

                if(isset($_SESSION['update'])) 
                {
                    echo $_SESSION['update'];  
                    unset($_SESSION['update']);  
                }

                if(isset($_SESSION['failed-remove'])) 
                {
                    echo $_SESSION['failed-remove'];  
                    unset($_SESSION['failed-remove']);  
                }

                if(isset($_GET['id']))
                {
                    // Get the id of selected food
                    $id = $_GET['id'];

                    // Create the Sql Query to Get the details
                    $sql = "SELECT * FROM tbl_food WHERE id=$id";

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

                            $title = $row['title'];
                            $description = $row['description'];
                            $normal_price = $row['normal_price'];
                            $large_price = $row['large_price'];
                            $quantity = $row['quantity'];
                            $current_image = $row['image_name'];
                            $category = $row['category_id'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                        }
                        else
                        {
                            // Redirect to Manage Food Page with Session Message
                            $_SESSION['no-food-found'] = "<div class='error'> Food Not Found. </div>";

                            // Redirect to Manage Food Page
                            header('location:'.SITEURL.'admin/manage-food.php');
                        }
                    }
                }
                else
                {
                    // Redirect to Manage Food Page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container">
            <!-- =================================================== Body Section =================================================== -->
            <form action="#" method="POST" enctype="multipart/form-data">
                <section class="table-form">
                    <!--===== FOOD DETAILS =====-->
                    <div class="user-details">
                        <div class="title-name">
                            <h3>Food Details</h3>
                        </div>
                        <div class="half-width">
                            <div class="input-box">
                                <span class="details">Food Name</span>
                                <input type="text" name="title" value="<?php echo $title; ?>" required>
                            </div>

                            <div class="input-box">
                                <span class="details">Image</span>
                                <input type="file" id="image" name="image">
                            </div>

                            <div class="input-box" style="margin-top: 5px; position: relative; display: flex; flex-wrap: wrap;">
                                <span class="details" style="position: relative; display: flex; justify-content: center; align-items: center; margin-right: 25px;">Current Image</span>
                                <?php
                                    if($current_image != "")
                                    {
                                        // Display the Image
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">
                                        <?php
                                    }
                                    else
                                    {
                                        // Display the Message
                                        echo "<div class='error'>Image not Added</div>";
                                    }
                                ?>
                            </div>

                            <div class="input-box"></div>

                            <div class="input-box">
                                <span class="details">Description</span>
                                <textarea rows="2"name="description"><?php echo $description; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!--===== FOOD PRICE =====-->
                    <div class="user-details" style="background: #F7F7FC; margin-top: -39px;">
                        <div class="title-name">
                            <h3>Food Price</h3>
                        </div>
                        <div class="half-width">
                            <div class="price-container">
                                <?php
                                    // Fetch prices from the database
                                    $sql = "SELECT normal_price, large_price, quantity FROM tbl_food WHERE id = $food_id";
                                    $res = mysqli_query($conn, $sql);

                                    $normal_price = 0;
                                    $large_price = 0;
                                    if ($res == TRUE) {
                                        $row = mysqli_fetch_assoc($res);
                                        $normal_price = $row['normal_price'];
                                        $large_price = $row['large_price'];
                                    }
                                ?>

                                <div class="price-box">
                                    <input type="checkbox" class="checkbox-splash price-check"<?php echo $normal_price != 0 ? 'checked' : ''; ?>>
                                    <div class="input-box">
                                        <span class="details">Normal Price</span>
                                        <input type="number" name="normal_price" value="<?php echo $normal_price; ?>" placeholder="Normal Price" min="0" step="0.01" required <?php echo $normal_price == 0 ? 'disabled' : ''; ?> style="background-color: #F7F7EF; color: #B0B0B6; cursor: not-allowed;">
                                    </div>

                                    <input type="checkbox" class="checkbox-splash price-check" <?php echo $large_price != 0 ? 'checked' : ''; ?>>
                                    <div class="input-box">
                                        <span class="details">Large Price</span>
                                        <input type="number" name="large_price" value="<?php echo $large_price; ?>" placeholder="Large Price" min="0" step="0.01" required <?php echo $large_price == 0 ? 'disabled' : ''; ?> style="background-color: #F7F7EF; color: #B0B0B6; cursor: not-allowed;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--===== TYPE DETAILS =====-->
                    <div class="user-details" style="background: linear-gradient(to top, #FFF, #F7F7FC); margin-top: -39px;">
                        <div class="title-name">
                            <h3 style="font-size: 20px;">Items Specification</h3>
                        </div>
                        <div class="half-width">
                            <div class="input-box">
                                <span class="details">Quantity</span>
                                <input type="number" name="quantity" value="<?php echo $quantity; ?>" placeholder="Set your Quantity" min="0" step="0.01" required>
                            </div>

                            <div class="radio" style="margin-top: 25px;">
                                <div class="featured">
                                    <span class="text">Recommended</span>
                                    <div class="down">
                                        <input <?php if($featured == "Yes"){echo "Checked";} ?> type="radio" name="featured" value="Yes"> Yes 
                                        <input <?php if($featured == "No"){echo "Checked";} ?> type="radio" name="featured" value="No"> No
                                    </div>
                                </div>

                                <div class="active">
                                    <span class="text">Active</span>
                                    <div class="down">
                                        <input <?php if($active == "Yes"){echo "Checked";} ?> type="radio" name="active" value="Yes"> Yes 
                                        <input <?php if($active == "No"){echo "Checked";} ?> type="radio" name="active" value="No"> No
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="user-details" style="background: #FFF; margin-top: -39px;">
                        <div class="button">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="hidden" name="category" value="<?php echo $category; ?>">
                            <input type="hidden" name="id" value="<?php echo $food_id; ?>">
                            <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                        </div>
                    </div>
                </section>

                <section class="table-form-side">
                    <!--===== TYPE DETAILS =====-->
                    <div class="user-details" style="background: linear-gradient(to top, #FFF, #F7F7FC);">
                        <div class="half-width" style="margin-left: 15px;">
                            <div style="margin-left: 0px;">
                                <h4>Categories</h4>
                                
                                <ul class="category-menu" style="list-style-type: none;">
                                    <?php
                                        // Fetch the food item from the database
                                        $sql = "SELECT * FROM tbl_food WHERE id=$id";
                                        $res = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($res);
                                        $category_id = $row['category_id']; // Get the category_id of the food item

                                        $sql = "SELECT * FROM tbl_category";
                                        $res = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            
                                            echo "<li style='margin-top: 5px;'>";
                                            // Check if the category id matches the food's category id
                                            if ($id == $category_id) {
                                                echo "<input type=\"radio\" name=\"category_id\" value=\"$id\" checked>&nbsp;&nbsp;$title"; 
                                            } else {
                                                echo "<input type=\"radio\" name=\"category_id\" value=\"$id\">&nbsp;&nbsp;$title"; 
                                            }
                                            echo "</li>";
                                        }
                                    ?>
                                    <li></li>
                                </ul>
                            </div>

                            <div style="margin-left: 0px; margin-top: -5px;">
                                <?php
                                    // Fetch food types from the database
                                    $sql = "SELECT name FROM tbl_food_variation WHERE food_id = $food_id";
                                    $res = mysqli_query($conn, $sql);

                                    $food_types = array();
                                    if ($res == TRUE) {
                                        while($row = mysqli_fetch_assoc($res)) {
                                            $food_types[] = $row['name'];
                                        }
                                    }

                                    // Fetch the food variations based on the category
                                    $sql = "SELECT sv.name, c.title FROM tbl_store_variation sv JOIN tbl_category c ON sv.category_id = c.id WHERE sv.category_id = $category_id ORDER BY c.title";
                                    $res = mysqli_query($conn, $sql);
                                ?>
                                
                                <h4 style="margin-left: -5px;">Food Types</h4>
                                
                                <ul id="variations" style="list-style-type: none;">
                                    <li>
                                        <?php
                                            if ($res == TRUE) {
                                                $current_category = '';
                                                while($row = mysqli_fetch_assoc($res)) {
                                                    $variation = $row['name'];
                                                    $category = $row['title'];

                                                    // If the category has changed, print the category name
                                                    if ($category != $current_category) {
                                                        echo '<span class="details">' . $category . '</span> <br>';
                                                        $current_category = $category;
                                                    }
                                                    $checked = in_array($variation, $food_types) ? 'checked' : '';
                                                    echo '<label><input type="checkbox" class="checkbox-splash" name="food_type[]" value="' . $variation . '" ' . $checked . '/>&nbsp; ' . $variation . ' &nbsp; </label> <br>';
                                                }
                                            }
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>  
                    </div>
                </section>
            </form>
            <!-- =================================================== Body Section =================================================== -->
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        document.querySelectorAll('.price-check').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var inputBox = this.nextElementSibling.querySelector('input[type="number"]');
                if (this.checked) {
                    inputBox.disabled = false;
                    inputBox.style.backgroundColor = '#F7F7FF';
                    inputBox.style.color = 'black';
                    inputBox.style.cursor = 'text';
                } else if (!this.checked) {
                    inputBox.disabled = true;
                    inputBox.style.backgroundColor = '#F7F7EF';
                    inputBox.style.color = '#B0B0B6';
                    inputBox.style.cursor = 'not-allowed';
                }
            });
        });

        document.querySelectorAll('.price-check').forEach(function(checkbox) {
            var inputBox = checkbox.nextElementSibling.querySelector('input[type="number"]');

            // Store the original price in a data attribute
            inputBox.dataset.originalPrice = inputBox.value;

            // Function to enable or disable the input field
            function toggleInput() {
                if (checkbox.checked) {
                    inputBox.disabled = false;
                    inputBox.style.backgroundColor = '#F7F7FF';
                    inputBox.style.color = 'black';
                    inputBox.style.cursor = 'text';
                } else {
                    inputBox.disabled = true;
                    inputBox.style.backgroundColor = '#F7F7EF';
                    inputBox.style.color = '#B0B0B6';
                    inputBox.style.cursor = 'not-allowed';
                }
            }

            // Check the initial state of the checkbox
            toggleInput();

            // Listen for changes on the checkbox
            checkbox.addEventListener('change', toggleInput);
        });

        $(document).ready(function() {
            // Add an onchange event listener to the category radio buttons
            $('input[name="category_id"]').change(function() {
                var categoryId = $(this).val();

                $.ajax({
                    url: 'get-variations.php', // The PHP script that fetches the variations
                    type: 'GET',
                    data: { category_id: categoryId },
                    dataType: 'json',
                    success: function(response) {
                        // Clear the current variations
                        $('#variations').empty();

                        // Add the new variations
                        $.each(response, function(index, variation) {
                            $('#variations').append('<li><label><input type="checkbox" class="checkbox-splash" name="food_type[]" value="' + variation + '"/>&nbsp; ' + variation + ' &nbsp; </label> <br></li>');
                        });
                    }
                });
            });
        });
    </script>
<?php include('Partials/footer.php'); ?>