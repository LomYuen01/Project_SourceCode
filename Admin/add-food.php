<?php include('Partials/menu.php'); ?>

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

                    // Redirect to Add Food Page
                    header('location:'.SITEURL.'admin/add-food.php');
                }
            }
        ?>

        <!----------------------------------------------------------------------------------------------------------------------------------------------------------+
        |  The Main Content is shifted below the PHP function is because the main content started a session already and if the php were below it, we're basically   |
        |  creating another session which could lead to an error "Cannot Modify header Information"                                                                 |
        +----------------------------------------------------------------------------------------------------------------------------------------------------------->

        <!-- Main Content Section Starts -->
        <div class="mainContent">
            <div class="wrapper">
                <h1>Add Food</h1>

                <br>

                <form action="" method="POST" enctype="multipart/form-data">

                    <table class="tbl-42">
                        <tr>
                            <td>Title: </td>
                            <td>
                                <input type="text" name="title" placeholder="Food Title">
                            </td>
                        </tr>

                        <tr>
                            <td>Description: </td>
                            <td>
                                <textarea name="description" cols="30" rows="5" placeholder="Food Description"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Select Image: </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>

                        <tr>
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
                                                <tr>
                                                    <td>Price (Normal): </td>
                                                    <td>
                                                        <input type="number" name="normal_price" placeholder="Price for Normal Size" min="0" step="0.01" required>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Price (Large): </td>
                                                    <td>
                                                        <input type="number" name="large_price" placeholder="Price for Large Size" min="0" step="0.01" required>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            else if($FoodSize == "No")
                                            {
                                            ?>
                                                <tr>
                                                    <td>Price: </td>
                                                    <td>
                                                        <input type="number" name="normal_price" placeholder="Price" min="0" step="0.01" required>
                                                    </td>
                                                </tr>

                                                <input type="hidden" name="large_price" value="0.00">
                                            <?php
                                            }
                                            break; // Exit the loop as we've found the matching id
                                        }
                                    }
                                }
                            ?>
                        </tr>

                        <tr>
                            <td>Featured: </td>
                            <td>
                                <input type="radio" name="featured" value="Yes"> Yes 
                                <input type="radio" name="featured" value="No"> No
                            </td>
                        </tr>

                        <tr>
                            <td>Active: </td>
                            <td>
                                <input type="radio" name="active" value="Yes"> Yes 
                                <input type="radio" name="active" value="No"> No
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                            </td>
                        </tr>

                    </table>
                </form>
            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('Partials/footer.php'); ?>