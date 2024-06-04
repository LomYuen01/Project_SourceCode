<?php
    // Include constants.php for SITEURL
    include('../config/constant.php');

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
                // Set the session message
                $_SESSION['remove'] = "<div class='error'> Failed to Remove Food Image. </div>";
                // Redirect to Manage Food page
                header('location:'.SITEURL.'admin/manage-food.php');
                // Stop the process
                die();
            }
        }

        // Delete related data from tbl_food_variation
        $sql = "DELETE FROM tbl_food_variation WHERE food_id=$id";
        $res = mysqli_query($conn, $sql);
        if($res==false)
        {
            // Set the session message
            $_SESSION['remove'] = "<div class='error'> Failed to Remove Food Variations. </div>";
            // Redirect to Manage Food page
            header('location:'.SITEURL.'admin/manage-food.php');
            // Stop the process
            die();
        }
    }
    else
    {
        // Redirect to Manage Food with Error Message
        $_SESSION['delete'] = "<div class='error'> Unauthorized Access. </div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

    // Create SQL Query to Delete Food
    $sql = "DELETE FROM tbl_food where id=$id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Redirect to Manage Food Page with message (success/error)
    if($res == TRUE)
    {
        // Create Session Variable to Display Message
        $_SESSION['delete'] = "<div class='success'> Food Deleted Successfully. </div>";

        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else{
        // Create Session Variable to Display Message
        $_SESSION['delete'] = "<div class='error'> Failed to Delete Food. Try Again Later. </div>";

        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>