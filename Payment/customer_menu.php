<?php include('partials/menu.php'); ?>

    <style>
        /* Existing styles */
        .selector {
            display: flex;
            flex-direction: row;
        }

        .group {
            margin-bottom: 20px;
        }

        .title {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .options {
            display: flex;
        }

        .option {
            padding: 10px;
            border: 1px solid #555;
            cursor: pointer;
            text-align: center;
            border-radius: 4px;
        }

        .option.active {
            border: 1px solid #ff4500;
            background-color: #ff4500;
        }

        .option.disabled {
            border: 1px solid #555;
            background-color: #555;
            cursor: not-allowed;
            color: #888;
        }

        button {
            background-color: white;
            color: black; /* Set the text color to black or any color you prefer */
        }

        .option-none {
            font-size: 15px;
            color: #000;
            border: 1px solid #000;
            width: 25%;
            height: 12%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 24px;
            background: #E4E4E4;
        }

        .notification {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid black;
            padding: 20px;
            z-index: 1000;
            text-align: center;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .close-notification {
            cursor: pointer;
            color: red;
            font-weight: bold;
        }

        .not-available-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('img/noavailable.jpg') no-repeat center center;
            background-size: cover;
            opacity: 0.5;
        }
    </style>

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
        <section class="food-menu" style="padding-top: 4.2%;">
            <div class="container">
                <div class="row">
                    <div class="col-md-3" style="display: flex;">
                        <!-- Display Categories -->
                        <div class="categories" style="position: fixed; left: 5%; top: 20%; list-style-type: none;">
                            <h2 style="font-weight: bold; font-size: 18px;">Categories</h2>
                            <ul style="color: black; flex-direction: column;">
                                <?php
                                // Fetch categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                $res = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];
                                    ?>
                                    <li style="display: flex; flex-direction: column; padding-left:20px;"><a href="#<?php echo $category_id; ?>" style="color: black;"><?php echo $category_title; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9" style="margin-left: 10%;">
                        <!-- Display Food Items -->
                        <h2 class="text-center" style="font-size:2em;">Food Menu</h2>
                        <div style="display: flex; flex-direction: row; justify-content: start; flex-direction: column;">
                            <?php
                            // Fetch foods from database based on categories
                            $sql_category = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res_category = mysqli_query($conn, $sql_category);
                            while ($row_category = mysqli_fetch_assoc($res_category)) {
                                $category_id = $row_category['id'];
                                $category_title = $row_category['title'];

                                // Fetch foods based on category
                                $sql_food = "SELECT * FROM tbl_food WHERE category_id=$category_id ";
                                $res_food = mysqli_query($conn, $sql_food);
                                $count = mysqli_num_rows($res_food);

                                if ($count > 0) {
                                    ?>
                                    <div class="food-menu-box" style="display: flex; flex-wrap: wrap; width: 100%; flex-direction: row; justify-content: space-between; margin: 4px 0; padding-bottom: 10%; padding-left: 5%; padding-right: 5%;">
                                        <h4 id="<?php echo $category_id; ?>" style="margin-left: -20px; display: block; width: 100%; font-weight: bold; font-size: 35px;"><?php echo $category_title; ?></h4>
                                        <?php while ($row_food = mysqli_fetch_assoc($res_food)) {
                                            $food_id = $row_food['id'];
                                            $food_title = $row_food['title'];
                                            $normal_price = $row_food['normal_price'];
                                            $food_description = $row_food['description'];
                                            $food_image = $row_food['image_name'];
                                            $food_active = $row_food['active'];
                                        ?>
                                        <div class="food-menu-box" style="display: flex; width: 50%; padding-bottom: 5%; margin-left: -20px; margin-right: -20px; margin-bottom: 20px; margin-top: 20px; box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.1); padding: 15px; border-radius: 18px; position: relative;">
                                            <div class="food-menu-desc" style="flex: 0 0 60%;">
                                                <h4><?php echo $food_title; ?></h4>
                                                <p class="food-detail" style="max-height: 160px; overflow-y: auto; scrollbar-width: none;"><?php echo $food_description; ?></p>
                                                <p>Variation</p>
                                                <?php
                                                    $sql_variation = "SELECT name, active FROM tbl_food_variation WHERE food_id = $food_id AND active = 'Yes'";
                                                    $result_variation = $conn->query($sql_variation);
                                                    if ($result_variation->num_rows > 0) {
                                                    ?>
                                                        <div>
                                                            <select name="<?php echo $food_id; ?>" style="border: 1px solid; border-radius: 18px; padding: 5px; cursor: pointer;">
                                                                <?php
                                                                while ($row = $result_variation->fetch_assoc()) {
                                                                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    <?php
                                                    } else {
                                                        echo "<option class='option-none'>None</option>";
                                                    }
                                                ?>
                                                <p class="food-price"></p>
                                                <div class="selector">
                                                    <div class="group">
                                                        <div class="title">Price</div>
                                                        <div class="options" data-group="price">
                                                            <?php
                                                            $sql_price = "SELECT normal_price, large_price, normal_active, large_active FROM tbl_food WHERE id = $food_id";
                                                            $result_price = $conn->query($sql_price);
                                                            if ($result_price->num_rows > 0) {
                                                                $row_price = $result_price->fetch_assoc();
                                                                echo "<div class='selector'>";
                                                                if ($row_price['normal_active'] == 'No') {
                                                                    echo "<button style='display: block; position: relative; margin-bottom: 12px; cursor: pointer; font-size: 0.8em; user-select: none;' class='option' data-price='".$row_price['normal_price']."'>Regular: $".$row_price['normal_price']."</button>";
                                                                }
                                                                if ($row_price['large_active'] == 'No') {
                                                                    echo "<button style='display: block; position: relative; margin-bottom: 12px; cursor: pointer; font-size: 0.8em; user-select: none;' class='option' data-price='".$row_price['large_price']."'>Large: $".$row_price['large_price']."</button>";
                                                                }
                                                                echo "</div>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="food-menu-img" style="flex: 1; flex-direction: column; justify-content: center; position: relative;">
                                                <?php if ($food_image == "") { ?>
                                                    <div class='error' style="width: 112px; height: 112px;">Image not Available.</div>
                                                <?php } else { ?>
                                                    <div style="position: relative;">
                                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $food_image; ?>" alt="<?php echo $food_title; ?>" class="img-responsive img-curve" style="width: 100%; height: 50%;">
                                                        <?php if ($food_active == 'No') { ?>
                                                            <div class="not-available-overlay"></div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                                <div>
                                                    <button class="btn btn-primary add-cart-btn" data-food-id="<?php echo $food_id; ?>" style="display: block; margin: auto; border: 1px solid; border-radius: 18px; color: var(--sk-body-link-color, #06c); text-align: center; font-size: 1em;">Add to Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <div class="overlay"></div>
    <div class="notification">
        <p id="notification-message"></p>
        <button class="close-notification">Close</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const options = document.querySelectorAll('.option');
            const addCartButtons = document.querySelectorAll('.add-cart-btn');
            const overlay = document.querySelector('.overlay');
            const notification = document.querySelector('.notification');
            const notificationMessage = document.querySelector('#notification-message');
            const closeNotificationButton = document.querySelector('.close-notification');

            options.forEach(option => {
                option.addEventListener('click', () => {
                    if (option.classList.contains('disabled')) return;

                    const group = option.parentElement.dataset.group;
                    document.querySelectorAll(`.options[data-group="${group}"] .option`).forEach(opt => opt.classList.remove('active'));
                    option.classList.add('active');
                });
            });

            addCartButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    const foodId = button.getAttribute('data-food-id');
                    const foodActive = button.closest('.food-menu-box').querySelector('.not-available-overlay');

                    if (!<?php echo isset($_SESSION['user']['user_id']) ? 'true' : 'false'; ?>) {
                        showNotification('You need to log in to add items to your cart.');
                    } else if (foodActive) {
                        showNotification('This item is currently not available.');
                    } else {
                        
                        window.location.href = `<?php echo SITEURL; ?>/Payment/add-cart.php?food_id=${foodId}`;
                    }
                });
            });

            closeNotificationButton.addEventListener('click', () => {
                hideNotification();
            });

            function showNotification(message) {
                notificationMessage.textContent = message;
                overlay.style.display = 'block';
                notification.style.display = 'block';
            }

            function hideNotification() {
                overlay.style.display = 'none';
                notification.style.display = 'none';
            }
        });
    </script>

<?php include('partials/footer.php'); ?>
