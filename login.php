<?php 
    // Include constants.php for SITEURL
    include("config/constant.php");

    // Check whether the Submit Button is Clicked or Not
    if(isset($_POST['submit']))
    {
        // Get the Data from Form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Process for Login

        // SQL to Check whether the User with Email and Password Exists or Not
        $sql = "SELECT * FROM tbl_customer WHERE email='$email' AND password='$password'";

        // Execute the Query
        $res = mysqli_query($conn, $sql);

        // Count Rows to Check whether the User Exists or Not
        $count = mysqli_num_rows($res);

        // Get the redirect URL
        $redirect_url = $_POST['redirect_url'] ?? SITEURL;

        if($count == 1)
        {
            // User Available and Login Success
            $_SESSION['user']['login'] = "<div class='success text-center'>Login Successful.</div>";
            $_SESSION['user']['email'] = $email; // To Check whether the User is Logged in or Not and Logout will unset it

            // Fetch the user data
            $row = mysqli_fetch_assoc($res);

            // Save the user id in the session
            $_SESSION['user']['user_id'] = $row['id'];

            // Redirect to the previous page or Home Page/Dashboard
            header('location:'.$redirect_url);
        }
        else
        {
            // User not Available and Login Fail
            $_SESSION['user']['login'] = "<div class='error text-center'>Username or Password did not match.</div>";

            // Redirect to the previous page or Home Page/Dashboard
            header('location:'.$redirect_url);
        }
    }
?>