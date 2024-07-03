<?php include('partials-front/menu.php'); ?>

<style>
    .contact-container-unique {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        
        color: white;
        padding: 20px;
        height: 100%;
    }

    .contact-heading-container {
        position: relative;
        width: 100%;
        height: 300px;
        margin: auto;
    }

    .contact-heading-container h1 {
        font-size: 3em;
        margin-bottom: 20px;
        z-index: 2; /* 保证标题在视频上层 */
        position: relative;
    }

    .contact-heading-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1; /* 确保视频在标题下层 */
    }

    .contact-subheading {
        margin-bottom: 20px;
    }

    .contact-form {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    .contact-label {
        margin-bottom: 5px;
    }

    .contact-input, .contact-textarea {
        margin-bottom: 15px;
        padding: 10px;
        border: none;
        border-radius: 5px;
    }

    .contact-button {
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #ff6347;
        color: white;
        font-size: 1em;
        cursor: pointer;
    }

    .contact-button:hover {
        background-color: #ff4500;
    }

    .contact-info-unique {
        text-align: left;
        max-width: 400px;
    }

    .contact-info-heading {
        margin-top: 20px;
        font-size: 1.2em;
    }

    .contact-info-text {
        margin-top: 5px;
        color: black;
        display: flex;
        flex-direction: column;
    }

    .contact-info-link {
        color: black;
        text-decoration: none;
    }

    .contact-info-link:hover {
        text-decoration: underline;
    }

    .contact-subheading {
        font-size: 1.5rem;
    }

    .swal-footer {
        text-align: center;
    }
</style>

<section class="home">
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
                    <a href="Email/forgot.php" class="forgot-password">Forgot password?</a>
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
    <div class="contact-heading-container" style="display: flex; justify-content: center; align-items: center; text-align: center; position: relative;">
        <img src="images/Yong_Tau_Fu.jpg" alt="Contact Us Background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1;">
        <h1 class="contact-heading" style="font-family: 'Yellowtail'; font-size: 54px; color: #fff; position: relative; z-index: 2; -webkit-text-stroke: 0.5px #000;">Contact Us</h1>
    </div>

    <div class="contact_us" style="display: flex; flex-direction: row; width: 89%; padding-top: 3%; padding-bottom: 3%; margin: auto;">
        <div class="contact-container-unique" style="display: flex; flex-direction: row; color: black;">
            <div style="box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 50px -12px; background-color: rgb(255, 255, 255);border-radius: 18px; padding: 35px; max-width: 40%;">
                <p class="contact-subheading">We'd Love to Hear From You, Please Let Us Know</p>
                <p>We understand that your needs are important, and we are here to assist you every step of the way. Our dedicated team is committed to providing top-notch support and addressing any questions or concerns you may have.</p>
                <h2 class="contact-info-heading">Send Us A Message</h2>
                <div style="width: 100%;">
                    <form action="process-contact-form.php" method="post" class="contact-form">
                        <label for="name" class="contact-label">Name</label>
                        <input type="text" id="name" name="name" class="contact-input" required style="border: 1px solid black; width: 100%;">

                        <label for="email" class="contact-label">Email</label>
                        <input type="email" id="email" name="email" class="contact-input" required style="border: 1px solid black; width: 100%;">

                        <label for="message" class="contact-label">Message</label>
                        <textarea id="message" name="message" rows="4" class="contact-textarea" required style="border: 1px solid black; width: 100%;"></textarea>

                        <button type="submit" name="submit" class="contact-button">Send</button>
                    </form>
                </div>
            </div>
            
            <div class="contact-info-unique" style="box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 50px -12px; background-color: rgb(255, 255, 255); border-radius: 18px; padding: 35px; padding-top: 15px; color: black; margin-left: 10px;">
                <h2 class="contact-info-heading">Address</h2>
                <p class="contact-info-text">BG-8, Jalan Tun Perak, Taman Kenaga Mewah, 75200 Melaka</p>
                <h2 class="contact-info-heading">Email</h2>
                <p class="contact-info-text">RenoKitchen@gmail.com</p>
                <h2 class="contact-info-heading">Phone</h2>
                <p class="contact-info-text">+60 14-925-9139</p>
                <h2 class="contact-info-heading">Open Hours</h2>
                <p class="contact-info-text">Monday: 06:30 - 14:00</p>
                <p class="contact-info-text">Tuesday: Closed</p>
                <p class="contact-info-text">Wednesday: 06:30 - 14:00</p>
                <p class="contact-info-text">Thursday: 06:30 - 14:00</p>
                <p class="contact-info-text">Friday: 06:30 - 14:00</p>
                <p class="contact-info-text">Saturday: 06:30 - 14:00</p>
                <p class="contact-info-text">Sunday: 06:30 - 14:00</p>
                <h2 class="contact-info-heading">Find Us On</h2>
                <p class="contact-info-text">
                    <a href="https://www.facebook.com/profile.php?id=100089915641375" class="contact-info-link">Facebook</a>
                    <a href="#" class="contact-info-link">Twitter</a>
                    <a href="#" class="contact-info-link">Instagram</a>
                </p>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    
    document.querySelector('.contact-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    formData.append('submit', 'Send'); // Add the submit button to the form data

    fetch('process-contact-form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        if (data === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Your form has been successfully submitted!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'There was an error submitting your form. Please try again.'
            });
        }
    })
    .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'There was an error submitting your form. Please try again.'
            });
            console.error('Error:', error);
        });
    });
</script>

<?php include('partials-front/footer.php'); ?>
