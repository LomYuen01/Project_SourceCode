<?php 
    include('partials-front/menu.php'); 
    $error_message = '';
?>

<style>
    .container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
        padding: 20px; 
        background: -webkit-linear-gradient(to bottom, rgb(201, 214, 255), rgb(226, 226, 226)); 
        background: linear-gradient(to bottom, rgb(201, 214, 255), rgb(226, 226, 226));
    }

    .logo {
        width: 50px;
    }

    .topside {
        
        align-items: center;
        gap: 10px;
    }

    .left-side {
        flex: 1;
        padding: 25px;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .form {
        display: flex;
        flex-direction: column;
    }

    .input-boxx {
        height: 40px;
        margin-top: 0;
        margin-bottom: 15px;
        position: relative;
    }

    .input-boxx input {
        height: 100%;
        width: 100%;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .fa-eye-slash {
        position: absolute;
        top: 50%;
        right: 0px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .pw-hide {
        position: absolute;
        top: 50%;
        right: 0px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .button {
        padding: 7px;
        height: 40px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        background-color: #4CAF50;
        color: #fff;
        margin-bottom: 10px;
    }

    .or-container {
        display: flex;
        align-items: center;
        margin: 20px 0;
    }

    .or-line {
        flex: 1;
        height: 1px;
        background: #ddd;
    }

    .or-text {
        margin: 0 10px;
        color: #777;
    }

    .google-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: #555;
        border: 1px solid #ddd;
    }

    .google-btn img {
        width: 20px;
        margin-right: 10px;
    }

    .signup-text {
        text-align: center;
        color: #777;
    }

    .signup-text a {
        color: #4CAF50;
        text-decoration: none;
    }

    .image-container {
        margin-bottom: 20px;
    }

    .image-container img {
        width: 250px;
    }
</style>

<!-- Home -->
<section class="home" style="background: #E0E1E4;">
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

    <!--====== Content ======-->
   <div class="container">
        <div style="position: relative; background: #8e9eab;  background: -webkit-linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243)); background: linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243)); display: flex; padding: 40px; border-radius: 11px;">
            <div class="left-side">
                <h2>Be a member now!</h2>
                <p>Please enter information in details below</p>
                <br>
                <form action="" method="POST" class="form">
                    <div class="input-boxx">
                        <input type="text" name="fullname" placeholder="Full Name" required>
                    </div>
                    <div class="input-boxx">
                        <input type="text" name="username" placeholder="Username" minlength="8" required>
                    </div>
                    <div class="input-boxx">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-boxx">
                        <input type="tel" id="phone" name="phone" placeholder="Phone Number" maxlength="15" required>
                    </div>
                    
                    <div class="input-boxx">
                        <input type="password" name="password" placeholder="Password (min 8, max 16)" minlength="8" maxlength="16" required style="overflow: hidden; margin-right: -50px; padding-right: 50px;">
                        <i class="fa-solid fa-eye-slash pw-hide" style="margin-right: 15px;"></i>
                    </div>
                    <div class="input-boxx">
                        <input type="password" name="confirm_password" placeholder="Confirm password" minlength="8" maxlength="16" required>
                        <i class="fa-solid fa-eye-slash pw-hide" style="margin-right: 15px;"></i>
                    </div>
                    <div>
                        <?php if (!empty($error_message)) : ?>
                        <p style="color: red;"><?php echo $error_message; ?></p>
                        <?php endif; ?>
                    </div>
                    <input type="submit" class="button" name="submit" value="Register">
                </form>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function (e) {
            const value = phoneInput.value.replace(/\D/g, '');
            
            if (value.length > 3 && value.startsWith('010') || value.startsWith('011') || value.startsWith('012') || value.startsWith('013') || value.startsWith('014') || value.startsWith('016') || value.startsWith('017') || value.startsWith('018') || value.startsWith('019')) {
                let formattedValue = value.match(/(\d{1,3})(\d{1,8})?/);
                if (formattedValue) {
                    phoneInput.value = formattedValue[1] + (formattedValue[2] ? '-' + formattedValue[2] : '');
                }
            } else {
                phoneInput.value = value.substring(0, 3);
            }
        });

        phoneInput.addEventListener('blur', function (e) {
            const value = phoneInput.value.replace(/\D/g, '');
            if (value.length < 10 || value.length > 11) {
                alert('Invalid phone number. Please enter a valid phone number.');
                phoneInput.value = '';
            }
        });
    });
</script>

<?php include('partials-front/footer.php'); ?>

<?php 
    if (isset($_POST['submit'])) {

        $fullname = $_POST['fullname'];
        $ph_no = $_POST['phone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Verify email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = 'Invalid email format.';
        } else {
            // Check if the password and confirm password match
            if ($password !== $confirm_password) {
                $error_message = 'Passwords do not match.';
            } else {
                // Check if email already exists in the database
                $sql = "SELECT * FROM tbl_customer WHERE email = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("s", $email);
                    $stmt->execute();

                    // Get the result
                    $result = $stmt->get_result();

                    // Check if a row was returned
                    if ($result->num_rows > 0) {
                        // Email already exists
                        $error_message = 'Email already exists.';
                    } else {
                        // Check if phone number already exists in the database
                        $sql = "SELECT * FROM tbl_customer WHERE ph_no = ?";
                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bind_param("s", $ph_no);
                            $stmt->execute();

                            // Get the result
                            $result = $stmt->get_result();

                            // Check if a row was returned
                            if ($result->num_rows > 0) {
                                // Phone number already exists
                                $error_message = 'Phone number already exists.';
                            } else {
                                // Email and phone number do not exist, insert the new user
                                $sql = "INSERT INTO tbl_customer (full_name, ph_no, username, email, password) VALUES (?, ?, ?, ?, ?)";
                                if ($stmt = $conn->prepare($sql)) {
                                    $stmt->bind_param("sssss", $fullname, $ph_no, $username, $email, $password);
                                    if ($stmt->execute()) {
                                        // User registered successfully
                                        echo "
                                        <script>
                                            Swal.fire({
                                                title: 'Registration Successful!',
                                                text: 'You may log in now.',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = 'index.php';
                                                }
                                            });
                                        </script>";
                                    } else {
                                        echo "Error executing statement.";
                                    }
                                } else {
                                    echo "Error preparing statement.";
                                }
                            }
                        } else {
                            echo "Error preparing statement.";
                        }
                    }
                } else {
                    echo "Error preparing statement.";
                }
            }
        }
        
    }
?>