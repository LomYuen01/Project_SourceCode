<?php
    // Include constants.php for SITEURL
    include('../../config/constant.php');

    // Check whether the Submit Button is Clicked or Not
    if(isset($_POST['submit']))
    {
        // Process for Login
        // 1. Get the Data from Login Form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // 2. SQL to Check whether the User with Username and Password Exists or Not
        $sql = "SELECT * FROM tbl_driver WHERE username='$username' AND password='$password'";

        // 3. Execute the Query
        $res = mysqli_query($conn, $sql);

        // 4. Count Rows to Check whether the User Exists or Not
        $count = mysqli_num_rows($res);

        if($count == 1)
        {
            // User Available and Login Success
            $_SESSION['driver']['user'] = $username; // To Check whether the User is Logged in or Not and Logout will unset it

            // Fetch the user data
            $row = mysqli_fetch_assoc($res);

            // Save the driver id, address_id and position in the session
            $_SESSION['driver']['driver_id'] = $row['id'];
            $_SESSION['driver']['address_id'] = $row['address_id'];
            $_SESSION['driver']['position'] = $row['position']; // Fetch position from the database

            // Clean the output buffer and turn off output buffering
            ob_end_clean();

            // Return a JSON response
            echo json_encode([
                'success' => true,
                'message' => 'Login Successful.',
                'redirect' => SITEURL.'delivery/'
            ]);
        }
        else
        {
            // User not Available and Login Fail
            $_SESSION['driver']['login'] = "<div class='error text-center'>Username or Password did not match.</div>";

            // Clean the output buffer and turn off output buffering
            ob_end_clean();

            // Return a JSON response
            echo json_encode([
                'success' => false,
                'message' => 'Username or Password did not match.'
            ]);
        }

        // Prevent the rest of the script from running
        exit;
    }
    else
    {
        // Clean the output buffer and turn off output buffering
        ob_end_clean();

        // Return a JSON response
        echo json_encode([
            'success' => false,
            'message' => 'Submit field not set in POST data.'
        ]);

        // Prevent the rest of the script from running
        exit;
    }
?>