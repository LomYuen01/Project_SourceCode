<?php 
    // Include constants.php for SITEURL
    include('../config/constant.php');

    // 1. Get the ID of Admin to be deleted
    $id = $_GET['id'];

    // 2. Create SQL Query to Delete Admin
    $sql = "DELETE FROM tbl_admin where id=$id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    if($res==TRUE)
    {
        // echo "Admin Deleted";
        // Create Session Variable to Display Message
        $_SESSION['delete'] = "<div class='success'> Admin Deleted Successfully. </div>";

        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else{
        // echo "Failed to Delete Admin";
        // Create Session Variable to Display Message
        $_SESSION['delete'] = "<div class='error'> Failed to Delete Admin. Try Again Later. </div>";

        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    // 3. Redirect to Manage Admin Page with message (success/error)
?>