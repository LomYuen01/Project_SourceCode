<?php
    // Include constants.php for SITEURL
    include('../config/constant.php');

    // Initialize response array
    $response = array('status' => 'failed', 'message' => 'An error occurred');

    // Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // Get the value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the physical image file if available
        if($image_name != "")
        {
            // Image is available. So, remove it
            $path = "../images/Food/".$image_name;

            // Remove the image file
            $remove = unlink($path);

            // If failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                // Set the response message
                $response['message'] = 'Failed to Remove Food Image.';
                echo json_encode($response);
                die();
            }
        }

        // Delete related data from tbl_food_variation
        $sql = "DELETE FROM tbl_food_variation WHERE food_id=$id";
        $res = mysqli_query($conn, $sql);
        if($res==false)
        {
            // Set the response message
            $response['message'] = 'Failed to Remove Food Variations.';
            echo json_encode($response);
            die();
        }
    }
    else
    {
        // Set the response message
        $response['message'] = 'Unauthorized Access.';
        echo json_encode($response);
        die();
    }

    // Create SQL Query to Delete Food
    $sql = "DELETE FROM tbl_food where id=$id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Set the response status and message
    if($res == TRUE)
    {
        $response['status'] = 'success';
        $response['message'] = 'Food Deleted Successfully.';
    }
    else
    {
        $response['message'] = 'Failed to Delete Food. Try Again Later.';
    }

    // Return the response
    echo json_encode($response);
?>