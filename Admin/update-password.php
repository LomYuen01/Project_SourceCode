<?php include('Partials/menu.php'); ?>

    <!-- Main Content Section Starts -->
    <div class="mainContent">
        <div class="wrapper">
            <h1>Change Admin Password</h1>

            <br /><br />

            <form action="" method="POST">

                <table class="tbl-30">
                    <tr>
                        <td>Current Password: </td>
                        <td>
                            <input type="password" name="current_password" placeholder="Current Password">
                        </td>
                    </tr>

                    <tr>
                        <td>New Password: </td>
                        <td>
                            <input type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password: </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>

        </div>
    </div>
    <!-- Main Content Section Ends -->

    <?php 
        // Check whether the Submit Button is Clicked or Not
        if(isset($_POST['submit']))
        {
            // 1. Get the data from Form
            $id = $_GET['id'];
            $current_password = $_POST['current_password']; // md5($_POST['current_password']);
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // 2. Check whether the user with current ID and Current Password Exists or Not
            $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

            $res = mysqli_query($conn, $sql);

            if($res==TRUE)
            {
                // Check whether the data is available
                $count = mysqli_num_rows($res); // Corrected here

                if($count==1)
                {
                    // 3. Check whether the new password and confirm password match or not
                    // User Exists and Password Can be Changed
                    if($new_password == $confirm_password)
                    {
                        // 4. Change Password if all above is true
                        // echo "Password Matched";
                        $sql2 = "UPDATE tbl_admin SET
                            password = '$new_password'
                            WHERE id=$id
                        ";

                        $res2 = mysqli_query($conn, $sql2);

                        if($res2 == TRUE)
                        {
                            $_SESSION['change-pwd'] = "<div class='success'> Password Changed Succesfully! </div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                        else
                        {
                            $_SESSION['change-pwd'] = "<div class='error'> Failed to Change Password! </div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        $_SESSION['pwd-not-match'] = "<div class='error'> Password Not Matched. </div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    // User Does Not Exist and Password Cannot be Changed
                    $_SESSION['user-not-found'] = "<div class='error'> User Not Found or Incorrect Password </div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

        }
    ?>


<?php include('Partials/footer.php'); ?>