<?php include('partials-front/menu.php'); ?>
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
        <php $user_id = 1></php>
        <div style="width: 90%; margin: auto; margin-top: 5%; margin-left:2%; display:inline-flex;">
            <div style="border: 1px solid black; width: 20%; font-size: 1rem;">
                <h1>Profile</h1>
                <div style="border: 1px solid black;">
                    <div class="profile-img" style="display: flex; justify-content: center; align-items: center; width: 100%; ;">
                        <img src="images/user.png" alt="User Image" class="img-responsive img-curve" style="width: 100%; height: auto; object-fit: cover;">
                    </div>
                    <div class="user-info style:">
                        User Name
                    </div>
                </div>
                <div class="profile-menu">
                    <ul>
                        <li>
                            <a href="profile_edit.php">Edit Profile</a>
                        </li>
                        <li>
                            <a href="profile_password.php">Change Password</a>
                        </li>
                        <li>
                            <a href="profile_order.php">Order History</a>
                        </li>
                        <li>
                            <a href="profile_address.php">Address</a>
                        </li>
                    </ul>
            </div>
            </div>

            <div style="border: 1px solid black; font-size: 1rem; width:80%;margin-left:2%;">
                <h1>Personal Information</h1>
                <table class="personal-info">
                    <tr>
                        <th class="info-title">Name</th>
                        <td class="user-name">User Name</td>
                    </tr>
                    <tr>
                        <th class="info-title">Email</th>
                        <td class="email">Email</td>
                    </tr>
                    <tr>
                        <th class="info-title">Phone</th>
                        <td class="phone">Phone</td>
                    </tr>
                </table>
            </div>
        </div>
        
    </section>
<?php include('partials-front/footer.php'); ?>