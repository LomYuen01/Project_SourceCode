<?php include('partials-front/menu.php'); 
    $user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : "";
    if (isset($_POST['password'])) {
        
        $user_id = 1;
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_new_password'];

        $sql = "SELECT * FROM tbl_customer WHERE id=$user_id AND password='$current_password'";
        $res = mysqli_query($conn, $sql);

        if ($res == TRUE) {
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                if ($new_password == $confirm_password) {
                    $sql2 = "UPDATE tbl_customer SET password='$new_password' WHERE id=$user_id";
                    $res2 = mysqli_query($conn, $sql2);
                    if ($res2 == TRUE) {
                        $_SESSION['password_change'] = "<div class='success'>Password changed successfully</div>";
                        header('location:'.SITEURL.'profile.php');
                    } else {
                        $_SESSION['password_change'] = "<div class='error'>Failed to change password</div>";
                        header('location:'.SITEURL.'profile_password.php');
                    }
                } else {
                    $_SESSION['password_change'] = "<div class='error'>New password and confirm password do not match</div>";
                    header('location:'.SITEURL.'profile_password.php');
                }
            } else {
                $_SESSION['password_change'] = "<div class='error'>Password does not match</div>";
                header('location:'.SITEURL.'profile_password.php');
            }
        } else {
            $_SESSION['password_change'] = "<div class='error'>Failed to change password</div>";
            header('location:'.SITEURL.'profile_password.php');
        }
    }


?>
    <!-- Home -->
    <section class="home">
        <!--====== Forms ======-->
        <div class="form-container">
            <i class="fa-solid fa-xmark form-close"></i>

            <!-- Login Form -->
            <div class="form login-form">
                <form action="#">
                    <h2>Login</h2>

                    <div class="input-box">
                        <input type="email" placeholder="Enter your email" required>
                        <i class="fa-solid fa-envelope email"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" placeholder="Enter your password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>

                    <div class="option-field">
                        <span class="checkbox">
                            <input type="checkbox" id="check">
                            <label for="check">Remember me</label>
                        </span>
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>

                    <button class="btn">Login Now</button>

                    <div class="login-singup">
                        Don't have an account? <a href="#" id="signup">Sign up</a>
                    </div>
                </form>
            </div>

            <!-- Sign up Form -->
            <div class="form signup-form">
                <form action="#">
                    <h2>Sign up</h2>

                    <div class="input-box">
                        <input type="email" placeholder="Enter your email" required>
                        <i class="fa-solid fa-envelope email"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" placeholder="Create password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" placeholder="Confirm password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>
                    
                    <button class="btn">Sign Up Now</button>

                    <div class="login-singup">
                        Already have an account? <a href="#" id="login">Login</a>
                    </div>
                </form>
            </div>
        </div>
        <!--====== Forms ======-->

        <!--===== Content =====-->
        <div style="width: 90%; margin: auto; margin-top: 5%; margin-left:2%; display:inline-flex;">
            <div style="border: 1px solid black; width: 20%; font-size: 1rem;  background: #8e9eab;  background: -webkit-linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243)); background: linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243));">
                <h1>Profile</h1>
                    <?php
                        
                        $sql = "SELECT * FROM tbl_customer WHERE id=$user_id";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                        if($count==1){
                            $row = mysqli_fetch_assoc($res);
                            $full_name = $row['full_name'];
                            $username = $row['username'];
                            $current_image = $row['image_name'];
                        }
                    ?>
                <div style="padding:10%;">
                    <div class="profile-img" style="display: flex; justify-content: center; align-items: center; width: 100%; ;">
                        <?php
                            if($current_image != "") {
                                // If $current_image is not empty, display the image
                                
                                echo "<img src='".SITEURL."images/Profile/".$current_image."' id='profileImage' style='border-width: 2.5px; width: 100% !important; height:auto !important; object-fit: contain;'>";
                            }
                            else {
                                // If $current_image is empty, display the default image
                                echo "<img src='images/no_profile_pic.png' id='profileImage' style='border-width: 2.5px; width: 100% !important; height:auto !important; object-fit: contain;'>";
                            }
                        ?>
                    </div>

                    <div class="user-info" style="text-align: center; font-size: 1rem;margin:auto;">
                        <?php echo $username; ?>
                    </div>
                </div>
                <div class="profile-menu" style="height: auto;">
                    <ul style="font-size: 1rem !important;">
                        <li style="height: 80px;">
                            <a href="profile-edit.php">Edit Profile</a>
                        </li>
                        <li style="height: 80px;">
                            <a href="change-password.php">Change Password</a>
                        </li>
                        <li style="height: 80px;">
                            <a href="profile_order.php">Order History</a>
                        </li>
                        <li style="height: 80px;">
                            <a href="profile_address.php">Address</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div style="border: 1px solid black; font-size: 1rem; width:80%;margin-left:2%;">
                <div><h1>Change Password</h1></div>
                <div style="margin: auto;  width: 40%;">
                    <form action="" method="post">
                    <div style="padding-top: 2%;padding-bottom:2%;">
                    <div><span>Current password</span></div>
                    <div class="input-box" style="width: 100%; margin-top: 0px;">
                        <input type="password" name="current_password" placeholder="Enter your current password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>
                    </div>
                    
                    <div style="padding-top: 2%;padding-bottom:2%;">
                    <div><span>New password</span></div>
                    <div class="input-box" style="width: 100%; margin-top: 0px;">
                        <input type="password" name="new_password" placeholder="Enter your new password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>
                    </div>

                    <div style="padding-top: 2%;padding-bottom:2%;">
                    <div><span>Confirm new password</span></div>
                    <div class="input-box" style="width: 100%; margin-top: 0px;">
                        <input type="password" name="confirm_new_password" placeholder="Confirm your new password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>
                    </div>

                    <div style="display: flex; justify-content: center; width: 100%;">
                        <input type="submit" name="password" value="Submit">
                    </div>
                    </form>
                </div>

            </div>
        </div>

        




        
    </section>
<?php include('partials-front/footer.php'); ?>