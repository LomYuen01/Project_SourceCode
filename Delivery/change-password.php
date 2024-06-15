<?php include('Partials/menu.php'); ?>

<!-- Home -->
<section class="home">
    <!--====== Forms ======-->
    <link rel="stylesheet" href="../Style/style-driver.css">
        <div class="container">
            <div><h1>Change Password</h1></div>
            <div >
                <form action="" method="post">
                <div >
                <div><span>Current password</span></div>
                <div >
                    <input type="password" name="current_password" placeholder="Enter your Current Password" required>
                </div>
                </div>
                
                <div>
                <div><span>New password</span></div>
                <div>
                    <input type="password" name="new_password" placeholder="Enter your new Password" required>
                </div>
                </div>

                <div >
                <div><span>Confirm new password</span></div>
                <div >
                    <input type="password" name="confirm_new_password" placeholder="Confirm your new Password" required>
                </div>
                </div>

                
                <div style="display: flex; justify-content: center; width: 100%;">
                    <button type="submit" name="password">Change Password</button>
                </div>
                </form>
            </div>
        </div>
    </section>

<?php include('Partials/footer.php'); ?>
<?php       
    if (isset($_POST['password'])) {
        $user_id = isset($_SESSION['driver']['user_id']) ? $_SESSION['driver']['user_id'] : "";
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_new_password'];

        $sql = "SELECT * FROM tbl_driver WHERE id=$driver_id AND password='$current_password'";
        $res = mysqli_query($conn, $sql);

        if ($res == TRUE) {
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                if ($new_password == $confirm_password) {
                    $sql2 = "UPDATE tbl_driver SET password='$new_password' WHERE id=$driver_id";
                    $res2 = mysqli_query($conn, $sql2);
                    if ($res2 == TRUE) {
                        echo "<script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'Password changed successfully.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '".SITEURL."delivery/index.php';
                                }
                            });
                        </script>";
                    } else {
                        echo "<script>
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to change password.',
                                icon: 'error'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '".SITEURL."delivery/change-password.php';
                                }
                            });
                        </script>";
                    }
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'New password and confirm password do not match.',
                            icon: 'error'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '".SITEURL."delivery/change-password.php';
                            }
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Current Password Incorrect.',
                        icon: 'error'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."delivery/change-password.php';
                        }
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to change password.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."delivery/change-password.php';
                    }
                });
            </script>";
        }
    }
?>