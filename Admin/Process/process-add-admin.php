<?php
    include('../../config/constant.php');
    ob_start();

    if(isset($_POST['submit']))
    {
        // Get the data from Form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);  // Password Encryption with MD5
        $IC = mysqli_real_escape_string($conn, $_POST['IC']);
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Check if the full_name, username, IC, ph_no, email already exists
        $fields_to_check = ['full_name', 'username', 'IC', 'ph_no', 'email'];
        foreach($fields_to_check as $field) {
            $value = $$field;  // get the value of the variable with the name contained in $field
            $sql_check = "SELECT * FROM tbl_admin WHERE $field = '$value'";
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
            }
        }
        else
        {
            $image_name = ""; 
        }

        // SQL Query to save the address details into tbl_address
        $sql_address = "INSERT INTO tbl_address SET
            address = '$address',
            postal_code = '$postal_code',
            city = '$city',
            state = '$state',
            country = '$country'
        ";

        // Executing Query and Saving Data into tbl_address
        $res_address = mysqli_query($conn, $sql_address) or die(mysqli_error());

        // Check whether the (Query is executed) data is inserted or not
        if($res_address==TRUE)
        {
            // Data Inserted
            // Get the ID of the inserted address row
            $address_id = mysqli_insert_id($conn);

            // SQL Query to save the admin details into tbl_admin
            $sql_admin = "INSERT INTO tbl_admin SET
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
            ";
        
            // Executing Query and Saving Data into tbl_admin
            $res_admin = mysqli_query($conn, $sql_admin) or die(mysqli_error());
        
            // Check whether the (Query is executed) data is inserted or not and display appropriate message
            if($res_admin==TRUE)
            {
                // Data Inserted

                ob_end_clean();
                echo json_encode([
                    'success' => true,
                    'message' => 'Admin added successfully.'
                ]);
                exit;
            }
            else
            {
                // Failed to Insert Data
                ob_end_clean();
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to insert admin details.'
                ]);
                exit;
            }
        }
    }
?>