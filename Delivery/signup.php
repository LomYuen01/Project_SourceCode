<?php include ('../config/constant.php'); ?>
<!--  HTML form here -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reno's Kitchen - Driver Module</title>
    <link rel="stylesheet" href="../Style/style-driver.css">
</head>

<body>
    <div class="container">
        <h1>Reno's Kitchen Driver</h1>
        <form method="POST" action="#">
            Username: <br>
            <input type="text" name="username" placeholder="Username" required>
            <?php if (isset($_SESSION['username_error'])) {
                echo "<div class='error'>" . $_SESSION['username_error'] . "</div>";
                unset($_SESSION['username_error']);
            } ?>
            Email: <br>
            <input type="email" name="email" placeholder="Email" required>
            <?php if (isset($_SESSION['email_error'])) {
                echo "<div class='error'>" . $_SESSION['email_error'] . "</div>";
                unset($_SESSION['email_error']);
            } ?>
            Password: <br>
            <input type="password" name="password" placeholder="Password" required>
            <?php if (isset($_SESSION['password_error'])) {
                echo "<div class='error'>" . $_SESSION['password_error'] . "</div>";
                unset($_SESSION['password_error']);
            } ?>
            Phone Number: <br>
            <input type="ph_no" name="ph_no" placeholder="XXX-XXXXXXX" required>
            <?php if (isset($_SESSION['ph_no_error'])) {
                echo "<div class='error'>" . $_SESSION['ph_no_error'] . "</div>";
                unset($_SESSION['ph_no_error']);
            } ?>
            Address: <br>
            <input type="address" name="address" placeholder="Address" required>
            Postal Code: <br>
            <input type="postal_code" name="postal_code" placeholder="Postal Code" required>
            City: <br>
            <input type="city" name="city" placeholder="City" required>
            State: <br>
            <input type="state" name="state" placeholder="State" required>
            Country: <br>
            <input type="country" name="country" placeholder="Country" required>

            <div class="information">
                <input type="submit" name="submit" styles="padding: 10px 20px;">
            </div>
        </form>
        <a href="http://localhost/RenoKitchen/delivery/Email/login.php">Have account? Login here</a>
    </div>
</body>

</html>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
    if (isset($_POST['submit'])) {
        // Get the data from Form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);  // Password Encryption with MD5
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);


        $errors = [];

        // Check if username already exists
        $sql_check = "SELECT * FROM tbl_driver WHERE username = '$username'";
        $res_check = mysqli_query($conn, $sql_check) or die(mysqli_error());
        if ($res_check->num_rows > 0) {
            $errors[] = 'This User Name already Registered. Please using other User Name.';
        }
        
        // Password validation
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
            $errors[] = 'Please Enter at-least 1 character and 8 numbers in password.';
        }
        
        // Phone number validation
        if (!preg_match("/^\d{3}-\d{7}$/", $ph_no)) {
            $errors[] = 'Please Enter Correct Phone Number.';
        }
        
        // Email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@gmail.com')) {
            $errors[] = 'Please Enter Correct Email Address.';
        }
        
        // Check if email already exists
        $sql_check = "SELECT * FROM tbl_driver WHERE email = '$email'";
        $res_check = mysqli_query($conn, $sql_check) or die(mysqli_error());
        if ($res_check->num_rows > 0) {
            $errors[] = 'This Email already Registered.';
        }
        
        // Check if the full_name, username, IC, ph_no, email already exists
        $fields_to_check = ['username', 'ph_no', 'email'];
        foreach ($fields_to_check as $field) {
            $value = $$field;  // get the value of the variable with the name contained in $field
            $sql_check = "SELECT * FROM tbl_driver WHERE $field = '$value'";
            $res_check = mysqli_query($conn, $sql_check) or die(mysqli_error());
            if ($res_check->num_rows > 0) {
                // Field value already exists
                $errors[] = "$field already Exists.";
            }
        }

        // Check if there are any errors
        if (!empty($errors)) {
            // Convert the PHP array to a JavaScript array
            $js_array = json_encode($errors);

            echo "<script>
                var errors = $js_array;

                // Loop through the errors array and display each error in a SweetAlert
                errors.forEach(function(error) {
                    Swal.fire({
                        title: 'Error!',
                        text: error,
                        icon: 'error'
                    });
                });
            </script>";
            exit();
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
        if ($res_address == TRUE) {
            // Data Inserted
            $address_id = mysqli_insert_id($conn);
        
            // SQL Query to save the driver details into tbl_driver
            $sql_driver = "INSERT INTO tbl_driver SET
                    username = '$username',
                    password = '$password',
                    ph_no = '$ph_no',
                    email = '$email',
                    address_id = '$address_id'
                ";
        
            // Executing Query and Saving Data into tbl_driver
            $res_driver = mysqli_query($conn, $sql_driver) or die(mysqli_error());
        
            // Check whether the (Query is executed) data is inserted or not and display appropriate message
            if ($res_driver == TRUE) {
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Driver Added Successfully.',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."delivery/Email/login.php';
                        }
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to Add Driver. Try Again Later.',
                        icon: 'error'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."delivery/signup.php';
                        }
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to Add Address. Try Again Later.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."delivery/signup.php';
                    }
                });
            </script>";
        }
    }
?>