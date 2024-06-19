<?php include('partials-front/menu.php'); ?>
<section class="home">
    <style>
        .swal-footer {
            text-align: center;
        }
    </style>
    <!--====== Forms ======-->
    <div class="form-container">
        <i class="fa-solid fa-xmark form-close"></i>

        <!-- Login Form -->
        <div class="form login-form">
            <form method="POST">
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loginForm = document.querySelector('.form.login-form form');

        loginForm.addEventListener('submit', (event) => {
            event.preventDefault();

            // Send the form data to the server using AJAX
            const formData = new FormData(loginForm);

            // Add the submit field manually
            formData.append('submit', 'Login');

            fetch('<?php echo SITEURL; ?>login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                return response.text();  // Change this line
            })
            .then(text => {
                console.log(text);  // Log the raw response text
                const data = JSON.parse(text);  // Parse the text as JSON

                if (data.success) {
                    swal('Success!', data.message, 'success').then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    swal('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                swal('Error!', error.message, 'error');
            });
        });
    });
</script>

<?php include('partials-front/footer.php'); ?>