<?php include('Partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="mainContent">
            <div class="wrapper">
                <h1>Update Category</h1>

                <br><br>

                <?php

                if(isset($_GET['id']))
                {
                    // Get the id of selected admin
                    $id = $_GET['id'];

                    // Create the Sql Query to Get the details
                    $sql = "SELECT * FROM tbl_category WHERE id=$id";

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
                            $current_image = $row['image_name'];
                            $size = $row['size'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                        }
                        else
                        {
                            // Redirect to Manage Category Page with Session Message
                            $_SESSION['no-category-found'] = "<div class='error'> Category Not Found. <div/>";

                            // Redirect to Manage Category Page
                            header('location:'.SITEURL.'admin/manage-category.php');
                        }
                    }
                }
                else
                {
                    // Redirect to Manage Category Page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                    
                ?>
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-42">
                        <tr>
                            <td>Title: </td>
                            <td>
                            <input type="text" name="title" value="<?php echo $title; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Current Image: </td>
                            <td>
                                <?php
                                    if($current_image != "")
                                    {
                                        // Display the Image
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="100px">
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
                            <td>Food Size: </td>
                            <td>
                                <input <?php if($size == "Yes"){echo "Checked";} ?> type="radio" name="size" value="Yes"> Yes
                                <input <?php if($size == "No"){echo "Checked";} ?> type="radio" name="size" value="No"> No
                            </td>

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
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>

            </div>
        </div>
        <!-- Main Content Section Ends -->

        <?php
            // Process the value from Form and save it in Database
            // Check whether the submit button is clicked or not
            
            if(isset($_POST['submit']))
            {
                // Button Clicked
                // 1. Get all the values from out Form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $size = $_POST['size'];
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
                            while(file_exists("../images/category/" . $base_name . $suffix . '.' . $ext)) 
                            {
                                $suffix = '(' . $index++ . ')';
                            }
                    
                            // Set the image name to the base name plus the suffix
                            $image_name = $base_name . $suffix . '.' . $ext;
            
                        // ---------------------------------------------------------------------------- //
            
                        $source_path = $_FILES['image']['tmp_name'];  
            
                        $destination_path = "../images/category/".$image_name;
            
                        // Finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);
            
                        // Check whether the image is uploaded or not
                        // If its not, we will stop the process and redirect with error message
                        if($upload == FALSE)
                        {
                            $_SESSION['upload'] = "<div class='error'> Failed to Upload Image. </div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die(); // Stop the Process
                        }
            
                        // Section B: Remove the current Image if available
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);
            
                            // Check whether the image is removed or not
                            // If failed to remove, display message and stop the process
                            if($remove==FALSE)
                            {
                                $_SESSION['failed-remove'] = "<div class='error'> Failed to remove current Image. </div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
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
                    // 3. SQL Query to update Category data into Database
                    $sql2 = "UPDATE tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
                        FoodSize = $FoodSize,
                        featured = '$featured',
                        active = '$active'
                        WHERE id = '$id'
                    ";
                    
                    $res2 = mysqli_query($conn, $sql2);
            
                    // 4. Redirect to Manage Category with Message
                    // Check whether the query executed or not
                    if($res2 == TRUE)
                    {
                        // Category Updated
                        $_SESSION['update'] = "<div class='success'> Category Updated Successfully. </div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                    else
                    {
                        // Failed to Update Category
                        $_SESSION['update'] = "<div class='error'> Failed to Update Category. </div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                }
            }

        ?>

<?php include('Partials/footer.php'); ?>