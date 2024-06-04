<?php include('Partials/menu.php'); ?>

    <!----------------------------------------------------------------------------------------------------------------------------------------------------------+
    |  The Main Content is shifted below the PHP function is because the main content started a session already and if the php were below it, we're basically   |
    |  creating another session which could lead to an error "Cannot Modify header Information"                                                                 |
    +----------------------------------------------------------------------------------------------------------------------------------------------------------->

    <section class="home">
        <div class="title">
            <div class="text">Add Food</div>

            <?php
                if(isset($_SESSION['upload'])) 
                {
                    echo $_SESSION['upload'];  
                    unset($_SESSION['upload']);  
                }

                if(isset($_SESSION['add'])) 
                {
                    echo $_SESSION['add'];  
                    unset($_SESSION['add']);  
                }

                if(isset($_SESSION['no-category-found'])) 
                {
                    echo $_SESSION['no-category-found'];  
                    unset($_SESSION['no-category-found']);  
                }

                if(isset($_SESSION['duplicates'])) 
                {
                    echo $_SESSION['duplicates'];  
                    unset($_SESSION['duplicates']);  
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
                                <input type="text" name="title" placeholder="Food Name" required>
                            </div>

                            <div class="input-box">
                                <span class="details">Image</span>
                                <input type="file" id="image" name="image">
                            </div>

                            <div class="input-box">
                                <span class="details">Description</span>
                                <textarea name="description" placeholder="Description"></textarea>
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
                                <div class="price-box">
                                    <input type="checkbox" class="checkbox-splash" name="normal_active">
                                    <div class="input-box">
                                        <span class="details">Normal Price</span>
                                        <input type="number" name="normal_price" placeholder="Normal Price" min="0" step="0.01" required disabled style="background-color: #F7F7EF; color: #B0B0B6; cursor: not-allowed;">
                                    </div>

                                    <input type="checkbox" class="checkbox-splash" name="large_active">
                                    <div class="input-box">
                                        <span class="details">Large Price</span>
                                        <input type="number" name="large_price" placeholder="Large Price" min="0" step="0.01" required disabled style="background-color: #F7F7EF; color: #B0B0B6; cursor: not-allowed;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--===== TYPE DETAILS =====-->
                    <div class="user-details" style="background: linear-gradient(to top, #FFF, #F7F7FC); margin-top: -39px;">
                        <div class="title-name">
                            <h3 style="font-size: 20px;">Extra Options</h3>
                        </div>
                        <div class="half-width">
                            <div class="radio">
                                <div class="featured">
                                    <span class="text">Recommended</span>
                                    <div class="down">
                                        <input type="radio" name="featured" value="Yes"> Yes 
                                        <input type="radio" name="featured" value="No"> No
                                    </div>
                                </div>

                                <div class="active">
                                    <span class="text">Active</span>
                                    <div class="down">
                                        <input type="radio" name="active" value="Yes"> Yes 
                                        <input type="radio" name="active" value="No"> No
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="user-details" style="background: #FFF; margin-top: -39px;">
                        <div class="button">
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
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
                                        // Fetch all categories from the database
                                        $sql = "SELECT * FROM tbl_category";
                                        $res = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            $active = $row['active'];

                                            if ($active == 'Yes') {
                                                echo "<li style='margin-top: 5px;'>";
                                                echo "<input type=\"radio\" name=\"category_id\" value=\"$id\">&nbsp;&nbsp;$title"; 
                                                echo "</li>";
                                            }
                                        }
                                    ?>
                                    <li></li>
                                </ul>
                            </div>

                            <div style="margin-left: 0px; margin-top: -5px;">
                                <h4 style="margin-left: -5px;">Food Types</h4>
                                
                                <ul id="variations" style="list-style-type: none; display: none;">
                                    <li>
                                        <?php
                                            // Fetch all food variations from the database
                                            $sql = "SELECT sv.name, c.title FROM tbl_store_variation sv JOIN tbl_category c ON sv.category_id = c.id ORDER BY c.title";
                                            $res = mysqli_query($conn, $sql);

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
                                                    echo '<label><input type="checkbox" class="checkbox-splash" name="food_type[]" value="' . $variation . '"/>&nbsp; ' . $variation . ' &nbsp; </label> <br>';
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

                        // Show the variations list
                        $('#variations').show();
                    }
                });
            });
        });
    </script>
    <script src="../Style/add-food.js"></script>
<?php include('Partials/footer.php'); ?>

<?php
    if(isset($_POST['submit']))
    {
        // 1. Get the data from Form
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category_id'];

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

        // Check for Food Name Duplicates
        $sql = "SELECT * FROM tbl_food WHERE title = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Food name already exists
            $_SESSION['duplicates'] = "<div class='error'> Food Name already Exists. </div>";
            header('location:'.SITEURL.'admin/add-food.php');
            exit;
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
                    $_SESSION['upload'] = "<div class='error'> Failed to Upload Image. </div>";
                    header('location:'.SITEURL.'admin/add-food.php');
                    die(); // Stop the Process
                }
            }
        }
        else
        {
            $image_name = "";  // Default Value
        }

        // 3. Insert into Database

        // Escape special characters in a string for use in an SQL statement
        $title = mysqli_real_escape_string($conn, $title);
        $description = mysqli_real_escape_string($conn, $description);
        $normal_price = mysqli_real_escape_string($conn, isset($_POST['normal_price']) ? $_POST['normal_price'] : 0);
        $large_price = mysqli_real_escape_string($conn, isset($_POST['large_price']) ? $_POST['large_price'] : 0);
        $image_name = mysqli_real_escape_string($conn, $image_name);
        $category = mysqli_real_escape_string($conn, $category);
        $featured = mysqli_real_escape_string($conn, $featured);
        $active = mysqli_real_escape_string($conn, $active);
        $normal_active = mysqli_real_escape_string($conn, $normal_active);
        $large_active = mysqli_real_escape_string($conn, $large_active);

        // Create SQL Query to save or add food
        $sql2 = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            normal_price = $normal_price,
            large_price = $large_price,
            image_name = '$image_name',
            category_id = $category,
            featured = '$featured',
            active = '$active',
            normal_active = '$normal_active',
            large_active = '$large_active'
        ";

        // Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        // Check if the food was added successfully
        if($res2 == TRUE)
        {
            $food_id = mysqli_insert_id($conn); // Get the ID of the last inserted row

            // Insert into tbl_food_variation
            if(isset($_POST['food_type']))
            {
                $food_type = $_POST['food_type'];
                foreach ($food_type as $selected) {
                    $selected = mysqli_real_escape_string($conn, $selected);
                    $sql3 = "INSERT INTO tbl_food_variation SET
                        food_id = $food_id,
                        name = '$selected',
                        active = 'Yes'
                    ";
                    $res3 = mysqli_query($conn, $sql3);
                    if($res3 == FALSE) {
                        // Handle error - break the loop and redirect with error message
                        $_SESSION['add'] = "<div class='error'> Failed to Add Food Variation. </div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        exit;
                    }
                }
            }

            $_SESSION['food_id'] = $food_id;
            $_SESSION['category_id'] = $category_id;

            // Query Executed and Food Added
            $_SESSION['add'] = "<div class='success'> Food Added Successfully. </div>";

            // Redirect to Manage Food Page
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            // Failed to Add Food
            $_SESSION['add'] = "<div class='error'> Failed to Add Food. </div>";

            echo "SQL error: " . mysqli_error($conn);

            // Redirect to Add Food Page
            header('location:'.SITEURL.'admin/add-food.php');
        }
    }
?>