<?php include('Partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="mainContent">
            <div class="wrapper">
                <h1>Add Admin</h1>

                <?php
                    if(isset($_SESSION['add']))  // Checking whether the session is set or not
                    {
                        echo nl2br($_SESSION['add']);
                        unset($_SESSION['add']);
                    }
                ?>

                <form action="" method="POST">

                    <table class="tbl-30">
                        <tr>
                            <td>Full Name: </td>
                            <td>
                                <input type="text" name="full_name" placeholder="Enter your name">
                            </td>
                        </tr>

                        <tr>
                            <td>Username: </td>
                            <td>
                                <input type="text" name="username" placeholder="Enter your username">
                            </td>
                        </tr>

                        <tr>
                            <td>Password: </td>
                            <td>
                                <input type="password" id="password" name="password" placeholder="Enter your password">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                            </td>
                        </tr>
                    </table>

                </form>
            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('Partials/footer.php'); ?>


<?php
    // Process the value from Form and save it in Database
    // Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button Clicked

        // 1. Get the data from Form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];  // Password Encryption with MD5

        // 2. SQL Query to save the data into Database
        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

        // 3. Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. Check whether the (Query is executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            // Data Inserted
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='success'> Admin Added Successfully. </div>";

            // Redirect to Manage Admin Page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // Failed to Insert Data
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='error'> Failed to Add Admin. Try Again Later. </div>";

            // Redirect to Manage Admin Page
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }

?>