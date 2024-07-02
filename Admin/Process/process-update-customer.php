<?php
    header('Content-Type: application/json');
    include('../../config/constant.php');
    ob_start();

    if(isset($_POST['submit']))
    {
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

        if(isset($_FILES['image']['name']))
        {
            $image_name = $_FILES['image']['name'];

            if($image_name != "")
            {
                // ---------- If image exist, it will add a suffix to the image name ---------- //
                        
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $base_name = basename($image_name, ".".$ext);
                
                    $suffix = '';
                    $index = 1;
                
                    while(file_exists("../../images/Profile/" . $base_name . $suffix . '.' . $ext)) 
                    {
                        $suffix = '(' . $index++ . ')';
                    }
            
                    $image_name = $base_name . $suffix . '.' . $ext;

                // ---------------------------------------------------------------------------- //

                $source_path = $_FILES['image']['tmp_name'];  

                $destination_path = "../../images/Profile/".$image_name;

                // B. Upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

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

        if(isset($_POST['address_id']) && !empty($_POST['address_id'])) {
            $addresses = $_POST['address'];
            $postal_codes = $_POST['postal_code'];
            $cities = $_POST['city'];
            $states = $_POST['state'];
            $countries = $_POST['country'];
            $address_ids = $_POST['address_id'];
        
            $updateSuccess = true; // Flag to track overall success
        
            for($i = 0; $i < count($addresses); $i++) {
                $address = mysqli_real_escape_string($conn, $addresses[$i]);
                $postal_code = mysqli_real_escape_string($conn, $postal_codes[$i]);
                $city = mysqli_real_escape_string($conn, $cities[$i]);
                $state = mysqli_real_escape_string($conn, $states[$i]);
                $country = mysqli_real_escape_string($conn, $countries[$i]);
                $address_id = mysqli_real_escape_string($conn, $address_ids[$i]); // Get the address ID
        
                $sql_address = "UPDATE tbl_customer_address SET
                    address = '$address',
                    postal_code = '$postal_code',
                    city = '$city',
                    state = '$state',
                    country = '$country'
                    WHERE id = $address_id
                ";
                $res_address = mysqli_query($conn, $sql_address);
        
                if($res_address == false) {
                    $updateSuccess = false; 
                    break; 
                }
            }
        
            if(!$updateSuccess) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update address details.'
                ]);
                exit;
            }

            if($res_address==TRUE)
            {
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
                $res_customer = mysqli_query($conn, $sql_customer) or die(mysqli_error());

                if($res_customer==TRUE){
                    ob_end_clean();
                    echo json_encode([
                        'success' => true,
                        'message' => 'Customer updated successfully.'
                    ]);
                    exit;
                } else {
                    ob_end_clean();
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to update customer details.'
                    ]);
                    exit;
                }
            }
        }

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
        $res_customer = mysqli_query($conn, $sql_customer);

        if($res_customer) {
            echo json_encode([
                'success' => true,
                'message' => 'Customer updated successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update customer details.'
            ]);
        }
        exit;
    }
?>