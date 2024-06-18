<?php
    include('../../config/constant.php');
    ob_start();
    
    if(isset($_POST['submit']))
    {
        // 1. Get the data from Form
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

        $normal_price = isset($_POST['normal_price']) ? mysqli_real_escape_string($conn, $_POST['normal_price']) : 0;
        $large_price = isset($_POST['large_price']) ? mysqli_real_escape_string($conn, $_POST['large_price']) : 0;
        $normal_active = isset($_POST['normal_active']) ? 'Yes' : 'No';
        $large_active = isset($_POST['large_active']) ? 'Yes' : 'No';

        $category = mysqli_real_escape_string($conn, $_POST['category_id']);

        if (!isset($category) || $category == null) {
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Please select a category.'
            ]);
            exit;
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
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Food Name already Exists.'
            ]);
            exit;
        }

        if (!is_numeric($normal_price) || !is_numeric($large_price) || 
            round($normal_price, 2) != $normal_price || round($large_price, 2) != $large_price) {
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Invalid price. Please enter a valid number with up to two decimal places.'
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
                        'message' => 'Failed to Upload Image.'
                    ]);
                    exit;
                }
            }
        }
        else
        {
            $image_name = "";  // Default Value
        }

        // 3. Insert into Database

        // Create SQL Query to save or add food
        $sql2 = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            normal_price = $normal_price,
            large_price = $large_price,
            image_name = '$image_name',
            category_id = $category,
            quantity = $quantity,
            active = '$status',
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
                        ob_end_clean();
                        echo json_encode([
                            'success' => false,
                            'message' => 'Failed to Add Food Variation.'
                        ]);
                        exit;
                    }
                }
            }

            // Query Executed and Food Added
            ob_end_clean();
            echo json_encode([
                'success' => true,
                'message' => 'Food Added Successfully.'
            ]);
            exit;
        }
        else
        {
            // Failed to Add Food
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Failed to Add Food. Please Try Again.'
            ]);
            exit;
        }
    }
?>