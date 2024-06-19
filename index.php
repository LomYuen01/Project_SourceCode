<?php include('partials-front/menu.php'); ?>

<style>
    .hero-section {
        position: relative;
        text-align: center;
        color: white;
        background: url('images/home.jpg') no-repeat center center/cover;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-content {
        background: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 10px;
    }

    .hero-title {
        font-size: 4em;
        margin: 0;
    }

    .hero-subtitle {
        font-size: 1.5em;
        margin: 10px 0;
    }

    .hero-button {
        padding: 10px 20px;
        background-color: #000;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1.2em;
    }

    .our-story {
        padding: 50px;
        background-color: #1c1c1c;
        color: white;
        text-align: center;
    }

    .section-title {
        font-size: 2.5em;
        margin-bottom: 30px;
    }

    .story-content {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .story-image {
        width: 300px;
        height: auto;
        border-radius: 10px;
        margin: 20px;
    }

    .story-text {
        max-width: 600px;
        text-align: left;
    }

    .story-text h3 {
        font-size: 2em;
        margin: 0 0 10px;
    }

    .story-text p {
        font-size: 1.2em;
        line-height: 1.6;
    }

    .new-section {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        padding: 50px;
        background-color: #f4f4f4;
    }

    .new-section .text {
        max-width: 600px;
        margin: 20px;
    }

    .new-section .text h3 {
        font-size: 2em;
        margin-bottom: 10px;
    }

    .new-section .text p {
        font-size: 1.2em;
        line-height: 1.6;
    }

    .new-section .menu-image {
        width: 300px;
        height: auto;
        border-radius: 10px;
        margin: 20px;
    }

    .location-section {
        text-align: center;
        padding: 50px;
        background-color: #e2e2e2;
    }

    .location-section .location-text {
        max-width: 800px;
        margin: 0 auto;
        font-size: 1.2em;
        line-height: 1.6;
    }

    .location-section img {
        margin-top: 20px;
        width: 80%;
        height: auto;
        border-radius: 10px;
    }

    .swal-footer {
        text-align: center;
    }
</style>

<!-- Home -->
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
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Reno Kitchen</h1>
            <p class="hero-subtitle">Takeout & Delivery</p>
            <a href="Payment/customer_menu.php" class="hero-button">Menu</a>
        </div>
    </div>

    <div class="our-story" id="our-story">
        <h2 class="section-title">Our Story</h2>
        <div class="story-content">
            <img src="images/story.png" alt="Chef" class="story-image">
            <div class="story-text">
                <h3>The Passion for Yong Tau Foo</h3>
                <p>Reno Kitchen has been selling Yong Tau Foo for around 3 - 4 years. What started as just one of the food court stalls has slowly developed into a full-fledged shop. Our journey is a testament to our dedication to quality and our love for this traditional dish. Come and experience the rich flavors and the warmth of our service.</p>
            </div>
        </div>
    </div>

    <div class="new-section">
        <div class="text">
            <h3>Our Varied Menu</h3>
            <p>We offer a wide variety of dishes, with nearly 25 different types of food on our menu. From traditional Yong Tau Foo to other delicious options, there's something for everyone at Reno Kitchen. Explore our menu and find your new favorite dish today!</p>
        </div>
        <img src="images/menu.jpg" alt="Menu" class="menu-image">
    </div>

    <div class="location-section">
        <h2 class="section-title">Where are we?</h2>
        <p class="location-text">We are located at BG-8, Jalan Tun Perak, Taman Kenaga Mewah, 75200 Melaka. Come visit us and enjoy our delicious Yong Tau Foo and other varieties.</p>
        <div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d604.1700226702823!2d102.23933833243478!3d2.211040622687029!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1f1c0e1faef9b%3A0x6eebff51969bf9c5!2zUmVubyBLaXRjaGVuIOadpeeil-mdoiAo54K45rC06aW6IOOAgiDphb_osYbohZDvvIk!5e0!3m2!1sen!2smy!4v1717391601878!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
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
