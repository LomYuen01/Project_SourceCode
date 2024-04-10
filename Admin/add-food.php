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
            ?>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container">
            <!-- =================================================== Header Section =================================================== -->
            <section class="table-form">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="user-details">
                        <div class="half-width">
                            <div class="input-box">
                                <span class="details">Food Name</span>
                                <input type="text" name="title" placeholder="Food Name" required>
                            </div>

                            <div class="input-box">
                                <span class="details">Image</span>
                                <input type="file" id="image" name="image">
                            </div>

                            <?php 
                                // Create PHP Code to display categories from database
                                // 1. Create SQL to get all active categories from database
                                $sql = "SELECT * FROM tbl_category";
                                $res = mysqli_query($conn, $sql);

                                // Count rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                // If count is greater than zero, we have categories else we don't have categories
                                if($count>0)
                                {
                                    // We have categories
                                    if (isset($_GET['category_id'])) {
                                        $category = $_GET['category_id'];
                                    } else {
                                        // Handle the case when the category_id parameter is not set in the URL
                                        echo "No category_id parameter found in the URL";
                                        exit;
                                    }

                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        // Get the details of categories
                                        $id = $row['id'];
                                        $FoodSize = $row['FoodSize'];

                                        if($id == $category)
                                        {
                                            if($FoodSize == "Yes")
                                            {
                                            ?>
                                            <div class="input-box">
                                                <span class="details">Normal Price</span>
                                                <input type="number" name="normal_price" placeholder="Normal Price" min="0" step="0.01" required>
                                            </div>

                                            <div class="input-box">
                                                <span class="details">Large Price</span>
                                                <input type="number" name="large_price" placeholder="Large Price" min="0" step="0.01" required>
                                            </div>
                                        <?php
                                        }
                                        else if($FoodSize == "No")
                                        {
                                        ?>
                                            <div class="input-box">
                                                <span class="details">Price</span>
                                                <input type="number" name="normal_price" placeholder="Price" min="0" step="0.01" required>
                                            </div>

                                            <div class="input-box">
                                                <input type="hidden" name="large_price" value="0.00">
                                            </div>
                                        <?php
                                        }
                                        break; // Exit the loop as we've found the matching id
                                        }
                                    }
                                }
                            ?>

                            <div class="input-box">
                                <span class="details">Description</span>
                                <textarea name="description" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="radio">
                        <div class="featured">
                            <span class="text">Featured</span>
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
                    
                    <div class="button">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </div>
                </form>

            </section>
            <!-- =================================================== Header Section =================================================== -->
        </div>
    </section>
    <script>

    </script>
<?php include('Partials/footer.php'); ?>

<?php
        if(isset($_POST['submit']))
        {
            // 1. Get the data from Form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $normal_price = $_POST['normal_price'];
            $large_price = $_POST['large_price'];
            $category = $_GET['category_id'];

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
            $normal_price = mysqli_real_escape_string($conn, $_POST['normal_price']);
            $large_price = mysqli_real_escape_string($conn, $_POST['large_price']);
            $image_name = mysqli_real_escape_string($conn, $image_name);
            $category = mysqli_real_escape_string($conn, $category);
            $featured = mysqli_real_escape_string($conn, $featured);
            $active = mysqli_real_escape_string($conn, $active);

            // Create SQL Query to save or add food
            $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                normal_price = $normal_price,
                large_price = $large_price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
            ";

            // Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            // 4. Redirect to Manage Food with Message
            if($res2 == TRUE)
            {
                $food_id = mysqli_insert_id($conn); // Get the ID of the last inserted row
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