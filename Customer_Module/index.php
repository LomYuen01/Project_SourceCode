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
        
    </section>
<?php include('partials-front/footer.php'); ?>