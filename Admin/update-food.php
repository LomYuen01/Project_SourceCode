<?php include('Partials/menu.php'); ?>

        <?php
            if (isset($_GET['id'])) 
            {
                $food_id = $_GET['id'];
                // Use $id to pre-fill the form for updating the food item
            }

            if (isset($_SESSION['category_id'])) {
                $category_id = $_SESSION['category_id'];
                // Use $category_id to pre-fill the category field in the form
            }

            // Process the value from Form and save it in Database
            // Check whether the submit button is clicked or not
            if(isset($_POST['submit']))
            {
                // Button Clicked
                // 1. Get all the values from out Form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $normal_price = $_POST['normal_price'];
                $large_price = $_POST['large_price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
            
                // Flag to check if we should process the image
                $process_image = true;
            
                // 2. Upload the Image if selected
                // Check whether the image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    // Get the Image Details
                    $image_name = $_FILES['image']['name'];
            
                    // Check whether the image is available or not
                    if($image_name != "")
                    {
                        // Section A: Upload the new image
            
                        // ---------- If image exist, it will add a suffix to the image name ---------- //
                                
                            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                            $base_name = basename($image_name, ".".$ext);
                        
                            // Start with no suffix
                            $suffix = '';
                            $index = 1;
                        
                            // While a file with the current name exists, increment the suffix
                            while(file_exists("../images/food/" . $base_name . $suffix . '.' . $ext)) 
                            {
                                $suffix = '(' . $index++ . ')';
                            }
                    
                            // Set the image name to the base name plus the suffix
                            $image_name = $base_name . $suffix . '.' . $ext;
            
                        // ---------------------------------------------------------------------------- //
            
                        $source_path = $_FILES['image']['tmp_name'];  
            
                        $destination_path = "../images/food/".$image_name;
            
                        // Finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);
            
                        // Check whether the image is uploaded or not
                        // If its not, we will stop the process and redirect with error message
                        if($upload == FALSE)
                        {
                            $_SESSION['upload'] = "<div class='error'> Failed to Upload Image. </div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die(); // Stop the Process
                        }
            
                        // Section B: Remove the current Image if available
                        if($current_image != "")
                        {
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);
            
                            // Check whether the image is removed or not
                            // If failed to remove, display message and stop the process
                            if($remove==FALSE)
                            {
                                $_SESSION['failed-remove'] = "<div class='error'> Failed to remove current Image. </div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
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
                    $image_name = $current_image;
                }
            
                // Only process the rest of the script if the image was successfully processed
                if($process_image)
                {
                    $title = mysqli_real_escape_string($conn, $_POST['title']);
                    $description = mysqli_real_escape_string($conn, $_POST['description']);
                    $normal_price = mysqli_real_escape_string($conn, $_POST['normal_price']);
                    $large_price = mysqli_real_escape_string($conn, $_POST['large_price']);
                    $category = mysqli_real_escape_string($conn, $_POST['category']);
                    $featured = mysqli_real_escape_string($conn, $_POST['featured']);
                    $active = mysqli_real_escape_string($conn, $_POST['active']);
                    $id = mysqli_real_escape_string($conn, $_POST['id']);

                    // 3. SQL Query to update Food data into Database
                    $sql2 = "UPDATE tbl_food SET 
                        title = '$title', 
                        description = '$description', 
                        image_name = '$image_name', 
                        category_id = '$category', 
                        featured = '$featured', 
                        active = '$active',
                        normal_price = '$normal_price', 
                        large_price = '$large_price'
                        WHERE id = '$id'";
                        
                    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
            
                    // 4. Redirect to Manage Food with Message
                    // Check whether the query executed or not
                    if($res2 == TRUE)
                    {
                        // Food Updated
                        $_SESSION['update'] = "<div class='success'> Food Updated Successfully. </div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        // Failed to Update Food
                        $_SESSION['update'] = "<div class='error'> Failed to Update Food. </div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                }
            }

        ?>

        <!-- Main Content Section Starts -->
        <div class="mainContent">
            <div class="wrapper">
                <h1>Update Food</h1>

                <br><br>

                <?php

                if(isset($_GET['id']))
                {
                    // Get the id of selected admin
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
                            $current_image = $row['image_name'];
                            $category = $row['category_id'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                        }
                        else
                        {
                            // Redirect to Manage Food Page with Session Message
                            $_SESSION['no-food-found'] = "<div class='error'> Food Not Found. <div/>";

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
                
                <form action="update-food.php" method="POST" enctype="multipart/form-data">
                    <table class="tbl-42">
                        <tr>
                            <td>Title: </td>
                            <td>
                            <input type="text" name="title" value="<?php echo $title; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Description: </td>
                            <td>
                                <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <?php 
                                // Get the id of the food item from the URL
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                } else {
                                    // Handle the case when the id parameter is not set in the URL
                                    echo "No id parameter found in the URL";
                                    exit;
                                }

                                // Fetch the food item from the database
                                $sql = "SELECT * FROM tbl_food WHERE id=$id";
                                $res = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($res);
                                $category_id = $row['category_id'];

                                // Fetch the categories from the database
                                $sql = "SELECT * FROM tbl_category";
                                $res = mysqli_query($conn, $sql);

                                // Count rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                // If count is greater than zero, we have categories else we don't have categories
                                if($count>0)
                                {
                                    // We have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        // Get the details of categories
                                        $id = $row['id'];
                                        $FoodSize = $row['FoodSize'];

                                        if($id == $category_id)
                                        {
                                            if($FoodSize == "Yes")
                                            {
                                            ?>
                                                <tr>
                                                    <td>Price (Normal): </td>
                                                    <td>
                                                        <input type="number" name="normal_price" min="0" step="0.01" value="<?php echo $normal_price; ?>" required>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Price (Large): </td>
                                                    <td>
                                                        <input type="number" name="large_price" min="0" step="0.01" value="<?php echo $large_price; ?>" required>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            else if($FoodSize == "No")
                                            {
                                            ?>
                                                <td>Price: </td>
                                                <td>
                                                    <input type="number" name="normal_price" min="0" step="0.01" value="<?php echo $normal_price; ?>" required>
                                                </td>

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
                            <td>Current Image: </td>
                            <td>
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
                            </td>
                        </tr>

                        <tr>
                            <td>New Image: </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>

                        <tr>
                            <td>Category: </td>
                            <td>
                                <?php
                                    // Query to get active categories
                                    $sql = "SELECT * FROM tbl_category WHERE id='$category_id'";
                                    $res = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($res);

                                    if($row)
                                    {
                                        // We have the category
                                        $category_title = $row['title'];
                                        echo $category_title;
                                    }
                                    else
                                    {
                                        // We do not have the category
                                        echo "No Category Found";
                                    }
                                ?>
                                <input type="hidden" name="category" value="<?php echo $category_id; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Featured: </td>
                            <td>
                                <input <?php if($featured == "Yes"){echo "Checked";} ?> type="radio" name="featured" value="Yes"> Yes 

                                <input <?php if($featured == "No"){echo "Checked";} ?> type="radio" name="featured" value="No"> No
                            </td>
                        </tr>

                        <tr>
                            <td>Active: </td>
                            <td>
                                <input <?php if($active == "Yes"){echo "Checked";} ?> type="radio" name="active" value="Yes"> Yes 
                                <input <?php if($active == "No"){echo "Checked";} ?> type="radio" name="active" value="No"> No
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="" name="id" value="<?php echo $food_id; ?>">
                                <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>

            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('Partials/footer.php'); ?>
