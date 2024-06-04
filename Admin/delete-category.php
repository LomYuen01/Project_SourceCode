<?php
    // Include constants.php for SITEURL
    include('../config/constant.php');

    // --------------------------- Deleting Image from the Folder --------------------------- //
    // Check whether the id and image_name value is set or not
    if(isset($_GET['id']))
    {
        // Get the Value and Delete
        $id = $_GET['id'];

        // 2. Create SQL Query to Delete Admin
        $sql = "DELETE FROM tbl_category where id=$id";

        // Execute the Query
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed successfully or not
        if($res==true)
        {
            // Category Deleted
            $_SESSION['delete'] = "<div class='success'> Category Deleted Successfully. </div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            // Failed to Delete Category
            $_SESSION['delete'] = "<div class='error'> Failed to Delete Category. </div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else
    {
        // Redirect to Manage Category with Error Message
        $_SESSION['delete'] = "<div class='error'> Unauthorized Access. </div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>