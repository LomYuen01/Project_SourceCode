<?php include('partials-front/menu.php'); ?>
<section class="home">
    <!--====== Forms ======-->
    <div class="form-container">
        <i class="fa-solid fa-xmark form-close"></i>

        <!-- Login Form -->
        <div class="form login-form">
            <form action="<?php echo SITEURL; ?>login.php" method="POST">
                <h2>Login</h2>

                <div class="input-box">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <i class="fa-solid fa-envelope email"></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Enter your password" required>
                    <i class="fa-solid fa-lock password"></i>
                    <i class="fa-solid fa-eye-slash pw-hide"></i>
                </div>

                <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">

                <div class="option-field">
                    <span class="checkbox">
                        <input type="checkbox" id="check">
                        <label for="check" style="margin-bottom: 0;">Remember me</label>
                    </span>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" name="submit" class="btn">Login Now</button>

                <div class="login-singup">
                    Don't have an account? <a href="<?php echo SITEURL; ?>signup.php">Sign up</a>
                </div>
            </form>
        </div>
    </div>
    <!--====== Forms ======-->

    <!--===== Content =====-->

</section>

<?php include('partials-front/footer.php'); ?>