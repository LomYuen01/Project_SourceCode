<?php
    include('../../config/constant.php');
    ob_start();

    if(isset($_POST['submit']))
    {
        // Get the data from Form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); 
        $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
        $IC = mysqli_real_escape_string($conn, $_POST['IC']);
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $license_classification = mysqli_real_escape_string($conn, $_POST['license_classification']);
        $license_exp_date = mysqli_real_escape_string($conn, $_POST['license_exp_date']);

        $driver_id = mysqli_real_escape_string($conn, $_POST['driver_id']);
        $address_id = mysqli_real_escape_string($conn, $_POST['address_id']);

        if (!isset($_POST['license_type']) || empty($_POST['license_type'])) {
            // License type is not set or is empty
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Please select at least one license type.'
            ]);
            exit;
        }
        $license_types = array_map(function($license_type) use ($conn) {
            return mysqli_real_escape_string($conn, $license_type);
        }, $_POST['license_type']);

        // Check if the full_name, username, IC, ph_no, email already exists
        $fields_to_check = ['full_name', 'username', 'IC', 'ph_no', 'email'];
        foreach($fields_to_check as $field) {
            $value = $$field;  // get the value of the variable with the name contained in $field
            $sql_check = "SELECT * FROM tbl_driver WHERE $field = '$value' AND id != '$driver_id'";
            $res_check = mysqli_query($conn, $sql_check) or die(mysqli_error());
            if($res_check->num_rows > 0) {
                // Field value already exists
                ob_end_clean();
                echo json_encode([
                    'success' => false,
                    'message' => ucfirst($field).' already exists.'
                ]);
                exit;
            }
        }
        
        // Get the address details from Form
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);

        // Upload the Image if selected
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
                    while(file_exists("../../images/Profile/" . $base_name . $suffix . '.' . $ext)) 
                    {
                        $suffix = '(' . $index++ . ')';
                    }
            
                    // Set the image name to the base name plus the suffix
                    $image_name = $base_name . $suffix . '.' . $ext;

                // ---------------------------------------------------------------------------- //

                $source_path = $_FILES['image']['tmp_name'];  

                $destination_path = "../../images/Profile/".$image_name;

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
                    $remove_path = "../../images/Profile/".$current_image;
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

        // SQL Query to save the address details into tbl_address
        $sql_address = "UPDATE tbl_address SET
            address = '$address',
            postal_code = '$postal_code',
            city = '$city',
            state = '$state',
            country = '$country'
            WHERE id = $address_id
        ";

        // Executing Query and Saving Data into tbl_address
        $res_address = mysqli_query($conn, $sql_address) or die(mysqli_error());

        // Check whether the (Query is executed) data is updated or not
        if($res_address==TRUE)
        {
            // Data updated

            $sql_driver = "UPDATE tbl_driver SET
                full_name = '$full_name',
                username = '$username',
                password = '$password',
                IC = '$IC',
                ph_no = '$ph_no',
                email = '$email',
                address_id = '$address_id',
                position = '$position',
                status = '$status',
                image_name = '$image_name'
                WHERE id = $driver_id
            ";

            // Executing Query and Saving Data into tbl_driver
            $res_driver = mysqli_query($conn, $sql_driver) or die(mysqli_error());

            // Check whether the (Query is executed) data is updated or not and display appropriate message
            if($res_driver==TRUE)
            {
                // Data updated

                // Delete existing license types
                $sql_delete_license = "DELETE FROM tbl_license_type WHERE driver_id = $driver_id";
                $res_delete_license = mysqli_query($conn, $sql_delete_license) or die(mysqli_error());

                // Insert new license types
                foreach ($license_types as $license_type) {
                    $sql_license = "INSERT INTO tbl_license_type SET
                        driver_id = '$driver_id',
                        license_type = '$license_type'
                    ";

                    // Executing Query and Saving Data into tbl_license_type
                    $res_license = mysqli_query($conn, $sql_license) or die(mysqli_error());

                    if($res_license==FALSE)
                    {
                        // Failed to update Data
                        ob_end_clean();
                        echo json_encode([
                            'success' => false,
                            'message' => 'Failed to update license type.'
                        ]);
                        exit;
                    }
                }

                if($res_license==TRUE)
                {
                    ob_end_clean();
                    echo json_encode([
                        'success' => true,
                        'message' => 'Driver updated successfully.'
                    ]);
                    exit;
                }
            }
            else
            {
                // Failed to update Data
                ob_end_clean();
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update driver details.'
                ]);
                exit;
            }
        }
    }
?>