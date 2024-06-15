<?php 
    include('config/constant.php');

    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $status = 'no'; 
        $message = $_POST['message'];

        // Insert data into the database
        $sql = "INSERT INTO tbl_contact_us (name, email, status, message) VALUES ('$name', '$email', '$status', '$message')";

        if (mysqli_query($conn, $sql)) {
            echo 'success';
        } else {
            echo 'error';
        }

        mysqli_close($conn);
    }
?>
