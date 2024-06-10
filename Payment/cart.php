<?php 
    include('partials/menu.php'); 
    $user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : "";
?>

    <style>
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .notification {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .notification p {
            margin: 0 0 20px;
        }

        .close-notification {
            background: #06c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
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
        <div class="title" style="padding-top: 15px; margin-left: 5.5%;">
            <h1>Cart</h1>
        </div>
        <div style="display: flex; flex-direction: row; gap: 25px; width: 89%; padding-bottom: 5%; margin: auto;">
            <div class="basket">
                <div class="basket-labels">
                    <ul>
                        <li class="food-checkbox">No.</li>
                        <li class="item item-heading">Item</li>
                        <li class="price">Price</li>
                        <li class="quantity">Quantity</li>
                        <li class="subtotal">Subtotal</li>
                    </ul>
                </div>

                <?php
                    $total = 0;

                    if ($user_id !== "") {
                        $sql = "SELECT tbl_cart_items.id as cart_items_id, tbl_cart_items.quantity as cart_quantity, tbl_cart_items.size as cart_size, tbl_food.title, tbl_food.normal_price, tbl_food.large_price, tbl_food_variation.name as variation_name
                                FROM tbl_cart_items
                                INNER JOIN tbl_food ON tbl_cart_items.food_id = tbl_food.id
                                LEFT JOIN tbl_food_variation ON tbl_cart_items.variation = tbl_food_variation.id
                                WHERE tbl_cart_items.customer_id = $user_id";

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $count = 1;
                            while ($row = $result->fetch_assoc()) {
                                $price = $row['cart_size'] == 'Large' ? $row['large_price'] : $row['normal_price'];
                                $subtotal = $price * $row['cart_quantity'];
                                $total += $subtotal;
                                ?>
                                <div class="basket-product" data-cart-id="<?php echo $row['cart_items_id']; ?>">
                                    <div class="food-checkbox"><?php echo $count; ?></div>
                                    <div class="item">
                                        <div class="product-details">
                                            <h2 style="font-size: 1em;"><?php echo $row['title']; ?></h2>
                                            <div style="border: 1px solid #000; border-radius: 5px; width: 40%; padding: 5px;">
                                                <div style="font-size: 1em;">Size: <?php echo $row['cart_size']; ?></div>
                                                <div style="font-size: 1em;">Variation: <?php echo $row['variation_name']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="price" data-price="<?php echo number_format($price, 2, '.', ''); ?>"><?php echo number_format($price, 2); ?></div>
                                    <div class="quantity">
                                        <div class="quantitys">
                                            <button class="quantity-button quantity-minus" onclick="updateQuantity(<?php echo $row['cart_items_id']; ?>, -1)">-</button>
                                            <div class="quantity-field" style="font-size: 1em;" data-cart-id="<?php echo $row['cart_items_id']; ?>"><?php echo $row['cart_quantity']; ?></div>
                                            <button class="quantity-button quantity-plus" onclick="updateQuantity(<?php echo $row['cart_items_id']; ?>, 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="subtotal" data-subtotal="<?php echo number_format($subtotal, 2, '.', ''); ?>"><?php echo number_format($subtotal, 2); ?></div>
                                    <div class="remove" style="border: 0; color: var(--sk-body-link-color,#06c)">
                                        <button onclick="removeFromCart(<?php echo $row['cart_items_id']; ?>)">Remove</button>
                                    </div>
                                </div>
                                <?php
                                $count++;
                            }
                        } else {
                            ?>
                            <div class="item" style="width: 100%; margin-left: 10%;">
                                <div class="product-details">
                                    <h2 style="font-size: 60px;">Cart Empty</h2>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="item" style="width: 100%; margin-left: 10%;">
                            <div class="product-details">
                                <h2 style="font-size: 60px;">You have not logged in</h2>
                            </div>
                        </div>
                        <?php
                    }
                    // Fetch the checkout limits and delivery price from the database
                    $current_day = date('l');
                    $sql_limit = "SELECT * FROM tbl_limit WHERE day = '$current_day'";
                    $result_limit = $conn->query($sql_limit);
                    $limit = $result_limit->fetch_assoc();

                    $checkout_start_time = $limit['start_time'];
                    $checkout_end_time = $limit['end_time'];
                    $minimum_cart_price = $limit['minimum_cart_price'];
                    $delivery_price = $limit['delivery_price'];
                ?>
            </div>

            <?php if ($user_id !== ""): ?>
                <div class="summary" style="width: 25%; height: 35%;">
                    <div class="summary-total-items"><span class="total-items"></span>Payment</div>

                    <div class="shopping-option-title">Shopping Option</div>
                    <div class="shopping-options">
                        <div class="shopping-option" style="display: flex; flex-direction: row;">
                            <input type="radio" name="shopping-option" id="option2" value="selfcollection" checked>
                            <label for="option2">Delivery</label>
                        </div>
                    </div>

                    <div class="payment-method-title">Payment Method</div>
                    <div class="payment-methods">
                        <div class="payment-method">
                            <div class="payment-method-image">
                                <img src="img/creditcard.png" alt="Bank Payment">
                            </div>
                            <div class="payment-method-name">
                                <input type="radio" name="payment" value="bank">
                                Credit/Debit Card
                            </div>
                        </div>

                        <div class="payment-method">
                            <div class="payment-method-image">
                                <img src="img/cod.png" alt="E-Wallet Payment">
                            </div>
                            <div class="payment-method-name">
                                <input type="radio" name="payment" value="cod">
                                Cash on delivery (COD)
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="delivery_title">
                            Delivery Fee
                        </div>
                        <div class="delivery_fee">
                            RM <?php echo $delivery_price; ?>
                        </div>
                    </div>

                    <div class="summary-total">
                        <div class="total-title">Total</div>
                        <div class="total-value final-value" id="basket-total"><?php echo number_format($total, 2, '.', ''); ?></div>
                    </div>

                    <div class="summary-checkout">
                        <button class="checkout-cta" style="background-color: rgb(106, 212, 125);border-radius: 18px; cursor: pointer;" onclick="redirectToCheckout(<?php echo $minimum_cart_price; ?>, '<?php echo $checkout_start_time; ?>', '<?php echo $checkout_end_time; ?>')">Checkout</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <div class="overlay"></div>
    <div class="notification">
        <p id="notification-message"></p>
        <button class="close-notification">Close</button>
    </div>

    <script>
        // Notification Functions
        function showNotification(message) {
            document.getElementById('notification-message').textContent = message;
            document.querySelector('.overlay').style.display = 'block';
            document.querySelector('.notification').style.display = 'block';
        }

        function hideNotification() {
            document.querySelector('.overlay').style.display = 'none';
            document.querySelector('.notification').style.display = 'none';
        }

        document.querySelector('.close-notification').addEventListener('click', hideNotification);
        document.querySelector('.overlay').addEventListener('click', hideNotification);

        function updateQuantity(cart_items_id, change) {
            var quantityField = document.querySelector('.quantity-field[data-cart-id="' + cart_items_id + '"]');
            var currentQuantity = parseInt(quantityField.textContent);
            var newQuantity = currentQuantity + change;

            if (newQuantity < 1) {
                showNotification("Minimum quantity limit of 1 reached.");
                return;
            }

            if (newQuantity > 10) {
                showNotification("Maximum quantity limit of 10 reached.");
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_quantity.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    quantityField.textContent = newQuantity;

                    var basketProduct = document.querySelector('.basket-product[data-cart-id="' + cart_items_id + '"]');
                    var priceElement = basketProduct.querySelector('.price');
                    var subtotalElement = basketProduct.querySelector('.subtotal');

                    var price = parseFloat(priceElement.getAttribute('data-price'));
                    var newSubtotal = price * newQuantity;
                    subtotalElement.setAttribute('data-subtotal', newSubtotal.toFixed(2));
                    subtotalElement.textContent = newSubtotal.toFixed(2);

                    updateTotalPrice();
                }
            };

            xhr.send("cart_items_id=" + cart_items_id + "&change=" + change);
        }

        
        function updateTotalPrice() {
            var total = 0;
            var delivery_price = 5.00; // Set your delivery price here
            var subtotalElements = document.querySelectorAll('.subtotal');
            subtotalElements.forEach(function(subtotalElement) {
                var subtotal = parseFloat(subtotalElement.getAttribute('data-subtotal'));
                if (!isNaN(subtotal)) {
                    total += subtotal;
                }
            });
            total += delivery_price; // Add the delivery price to the total
            document.getElementById('basket-total').textContent = total.toFixed(2);
        }
        

        function removeFromCart(cart_items_id) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "remove_from_cart.php?cart_items_id=" + cart_items_id, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var basketProduct = document.querySelector('.basket-product[data-cart-id="' + cart_items_id + '"]');
                    if (basketProduct) {
                        basketProduct.remove();
                    }
                    updateTotalPrice();
                }
            };
            xhr.send();
        }

        function redirectToCheckout(minimum_cart_price, checkout_start_time, checkout_end_time) {
            var totalPrice = parseFloat(document.getElementById('basket-total').textContent);
            var currentTime = new Date();
            var currentHours = currentTime.getHours();
            var currentMinutes = currentTime.getMinutes();
            var checkoutStartTime = new Date();
            var checkoutEndTime = new Date();

            checkoutStartTime.setHours(checkout_start_time.split(':')[0], checkout_start_time.split(':')[1]);
            checkoutEndTime.setHours(checkout_end_time.split(':')[0], checkout_end_time.split(':')[1]);

            if (totalPrice < minimum_cart_price) {
                showNotification("Minimum cart price requirement is RM " + minimum_cart_price);
                return;
            }

            if (currentTime < checkoutStartTime || currentTime > checkoutEndTime) {
                showNotification("Checkout is available from " + checkout_start_time + " to " + checkout_end_time);
                return;
            }

            if (document.querySelector('input[name="payment"]:checked') === null) {
                showNotification("Please select a payment method.");
                return;
            }

            // Perform AJAX request to check recent checkout verifications
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_checkout_verification.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            var paymentMethod = document.querySelector('input[name="payment"]:checked').value;
                            window.location.href = 'checkout.php?payment=' + paymentMethod;
                        } else {
                            showNotification(response.message);
                        }
                    } else {
                        showNotification("An error occurred. Please try again.");
                    }
                }
            };

            xhr.send("user_id=" + <?php echo $user_id; ?>);
        }
    </script>

<?php include('partials/footer.php');