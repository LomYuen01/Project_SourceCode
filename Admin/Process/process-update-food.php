<?php
    include('../../config/constant.php');
    ob_start();

    // Process the value from Form and save it in Database
    if(isset($_POST['submit']))
    {
        // 1. Get the data from Form
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);

        $normal_price = isset($_POST['normal_price']) ? mysqli_real_escape_string($conn, $_POST['normal_price']) : 0;
        $large_price = isset($_POST['large_price']) ? mysqli_real_escape_string($conn, $_POST['large_price']) : 0;
        $normal_active = isset($_POST['normal_active']) ? 'Yes' : 'No';
        $large_active = isset($_POST['large_active']) ? 'Yes' : 'No';

        $id = mysqli_real_escape_string($conn, $_POST['id']);
        if (isset($_POST['category_id'])) 
        {
            // Use the new category_id
            $category_id = $_POST['category_id'];
        } 
        else 
        {
            // Use the default category_id
            $category_id = $_GET['category_id'];
        }

        if(isset($_POST['food_type']))
        {
            $food_type = $_POST['food_type'];
            foreach ($food_type as $selected) {
                // Handle each selected value
            }
        }

        // Check if the category is active
        $sql = "SELECT active FROM tbl_category WHERE id = '$category_id'";
        $res = mysqli_query($conn, $sql);

        if ($res == TRUE) {
            $row = mysqli_fetch_assoc($res);
            if ($row && $row['active'] == 'No') {
                ob_end_clean();
                echo json_encode([
                    'success' => false,
                    'message' => 'The selected category is not active.'
                ]);
                exit;
            }
        } else {
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Failed to check category status.'
            ]);
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
                    while(file_exists("../../images/Food/" . $base_name . $suffix . '.' . $ext)) 
                    {
                        $suffix = '(' . $index++ . ')';
                    }
            
                    // Set the image name to the base name plus the suffix
                    $image_name = $base_name . $suffix . '.' . $ext;

                // ---------------------------------------------------------------------------- //

                $source_path = $_FILES['image']['tmp_name'];  

                $destination_path = "../../images/Food/".$image_name;

                // B. Upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Check whether the image is uploaded or not
                // If its not, we will stop the process and redirect with error message
                if($upload == FALSE)
                {
                    ob_end_clean();
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to upload image file.'
                    ]);
                    exit; 
                }

                // Remove the current image if it exists
                if($current_image != "")
                {
                    $remove_path = "../../images/Food/".$current_image;
                    $remove = unlink($remove_path);

                    // Check whether the image is removed or not
                    // If failed to remove, display message and stop the process
                    if($remove==FALSE)
                    {
                        ob_end_clean();
                        echo json_encode([
                            'success' => false,
                            'message' => 'Failed to remove current image.'
                        ]);
                        exit; 
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

        // Create SQL Query to update food
        $sql2 = "UPDATE tbl_food SET
            title = '$title',
            description = '$description',
            normal_price = '$normal_price',
            large_price = '$large_price',
            quantity = '$quantity',
            image_name = '$image_name',
            category_id = '$category_id',
            active = '$status',
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
                        ob_end_clean();
                        echo json_encode([
                            'success' => false,
                            'message' => 'Failed to Update Food Variation.'
                        ]);
                        exit;
                    }
                } else {
                    // This variation does not exist, so we need to insert it
                    $sql4 = "INSERT INTO tbl_food_variation (food_id, name, active) VALUES ($food_id, '$selected', 'Yes')";
                    $res4 = mysqli_query($conn, $sql4);
                    if($res4 == FALSE) {
                        ob_end_clean();
                        echo json_encode([
                            'success' => false,
                            'message' => 'Failed to Insert Food Variation.'
                        ]);
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
                    ob_end_clean();
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to Delete Food Variation.'
                    ]);
                    exit;
                }
            }

            // Query Executed and Food Updated
            ob_end_clean();
            echo json_encode([
                'success' => true,
                'message' => 'Food Updated Successfully.'
            ]);
            exit;
        }
        else
        {
            // Failed to Update Food
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Failed to Update Food.'
            ]);
            exit;
        }
    }
?>