<?php
    // Authorization - Access Control

    // Check whether the user is logged in or not
    if(!isset($_SESSION['driver']['user']))  // If Login is not set
    {
        // User is not Logged in
        // Redirect to Login Page with Message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to Access Delivery Panel.</div>";
        
        // Redirect to Login Page
        header('location:'.SITEURL.'delivery/login.php');
    }
?>