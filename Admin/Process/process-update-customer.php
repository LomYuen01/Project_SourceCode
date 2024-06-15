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
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);

        // Check if the full_name, username, IC, ph_no, email already exists
        $fields_to_check = ['full_name', 'username', 'ph_no', 'email'];
        foreach($fields_to_check as $field) {
            $value = $$field;  // get the value of the variable with the name contained in $field
            $sql_check = "SELECT * FROM tbl_customer WHERE $field = '$value' AND id != '$customer_id'";
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

        // Assuming you have the following arrays:
        $addresses = $_POST['address'];
        $postal_codes = $_POST['postal_code'];
        $cities = $_POST['city'];
        $states = $_POST['state'];
        $countries = $_POST['country'];
        $address_ids = $_POST['address_id'];

        // Loop through the arrays
        for($i = 0; $i < count($addresses); $i++) {
            $address = mysqli_real_escape_string($conn, $addresses[$i]);
            $postal_code = mysqli_real_escape_string($conn, $postal_codes[$i]);
            $city = mysqli_real_escape_string($conn, $cities[$i]);
            $state = mysqli_real_escape_string($conn, $states[$i]);
            $country = mysqli_real_escape_string($conn, $countries[$i]);
            $address_id = mysqli_real_escape_string($conn, $address_ids[$i]); // Get the address ID

            // SQL Query to save the address details into tbl_address
            $sql_address = "UPDATE tbl_customer_address SET
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
            if($res_address==FALSE)
            {
                // Failed to update Data
                ob_end_clean();
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update address details.'
                ]);
                exit;
            }
        }

        // Check whether the (Query is executed) data is updated or not
        if($res_address==TRUE)
        {
            // Data updated
            
            $sql_customer = "UPDATE tbl_customer SET
                full_name = '$full_name',
                username = '$username',
                password = '$password',
                ph_no = '$ph_no',
                email = '$email',
                status = '$status',
                image_name = '$image_name'
                WHERE id = $customer_id
            ";

            // Executing Query and Saving Data into tbl_customer
            $res_customer = mysqli_query($conn, $sql_customer) or die(mysqli_error());

            // Check whether the (Query is executed) data is updated or not and display appropriate message
            if($res_customer==TRUE)
            {
                // Data updated

                ob_end_clean();
                echo json_encode([
                    'success' => true,
                    'message' => 'Customer updated successfully.'
                ]);
                exit;
            }
            else
            {
                // Failed to update Data
                ob_end_clean();
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update customer details.'
                ]);
                exit;
            }
        }
    }
?>