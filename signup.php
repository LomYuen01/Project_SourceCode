<?php 
    // Include constants.php for SITEURL
    include('config/constant.php');
    
    // Check whether the Submit Button is Clicked or Not
    if(isset($_POST['submit']))
    {
        // Get the Data from Form
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Process for Signup

        // Check whether the passwords match
        if ($password != $confirm_password) {
            // Passwords do not match
            $_SESSION['user']['signup'] = "<div class='error text-center'>Passwords do not match.</div>";

            // Get the redirect URL
            $redirect_url = $_POST['redirect_url'] ?? SITEURL;

            // Redirect to the previous page or Home Page/Dashboard
            header('location:'.$redirect_url);
        } else {
            // Passwords match

            // SQL to Insert the User Data into Database
            $sql = "INSERT INTO tbl_customer (email, password) VALUES ('$email', '$password')";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Get the redirect URL
            $redirect_url = $_POST['redirect_url'] ?? SITEURL;

            if($res == true)
            {
                // User Created and Signup Success
                $_SESSION['user']['signup'] = "<div class='success text-center'>Signup Successful.</div>";

                // Redirect to the previous page or Home Page/Dashboard
                header('location:'.$redirect_url);
            }
            else
            {
                // User not Created and Signup Fail
                $_SESSION['user']['signup'] = "<div class='error text-center'>Signup Failed.</div>";

                // Redirect to the previous page or Home Page/Dashboard
                header('location:'.$redirect_url);
            }
        }
    }
?>