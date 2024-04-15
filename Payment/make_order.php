<?php include('partials-front/menu.php'); ?>

<?php
    $customer_id = 1; // Temporary customer_id

    $sql = "SELECT tbl_shopping_cart.id as cart_id, tbl_shopping_cart.quantity, tbl_food.id as food_id, tbl_food.title, tbl_food.normal_price
            FROM tbl_shopping_cart
            INNER JOIN tbl_food ON tbl_shopping_cart.food_id = tbl_food.id
            WHERE tbl_shopping_cart.customer_id = $customer_id";
    $result = $conn->query($sql);

    $total = 0;
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
    <main>
        <div class="title">
            <h1>Make Orders</h1>
        </div>

        <div class="basket">
        <div class="basket-labels">
            <ul>
                <li class="checkbox">No.</li>
                <li class="item item-heading">Item</li>
                <li class="price">Price</li>
                <li class="quantity">Quantity</li>
                <li class="subtotal">Subtotal</li>
            </ul>
        </div>

        <?php
            if ($result->num_rows > 0) 
            {
                $count = 1;
                while ($row = $result->fetch_assoc()) 
                {
                    echo '<div class="basket-product">';
                    echo '<div class="checkbox">' . $count . '</div>';
                    echo '<div class="item">';
                    echo '<div class="product-details">';
                    echo '<h2>' . $row['title'] . '</h2>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="price">' . $row['normal_price'] . '</div>';
                    echo '<div class="quantity">' . $row['quantity'] . '</div>';
                    $subtotal = $row['normal_price'] * $row['quantity'];
                    echo '<div class="subtotal">' . $subtotal . '</div>';
                    $total += $subtotal;
                    echo '</div>';
                    $count++;
                }
            } 
            else 
            {
                echo '<div class="item" style="width: 100%; margin-left: 10%;">';
                echo '<div class="product-details">';
                echo '<h2 style="font-size: 60px;">Your cart is empty</h2>';
                echo '</div>';
                echo '</div>';
            }
        ?>

        <div class="summary">
            <div class="summary-total-items"><span class="total-items"></span>Payment</div>
            <div class="summary-subtotal">
                <div class="subtotal-title">Subtotal</div>
                <div class="subtotal-value final-value" id="basket-subtotal"><?php echo isset($subtotal) ? $subtotal : '80.00'; ?></div>
                <div class="subtotal-title">Services Tax 6%</div>
                <div class="subtotal-value final-value" id="basket-services-tax"><?php echo isset($services_tax) ? $services_tax : '4.80'; ?></div>
            </div>

            <div class="shopping-option-title">Shopping Option</div>
            <div class="shopping-options" style="margin-top: 0px;">
                <div class="shopping-option"> Delivery </div>
            </div>

            <div>
                <Address>
                    <div class="address-title">Address</div>
                    <div class="address-value"><?php echo isset($delivery_address) ? $delivery_address : 'No. 1, Jalan 1, Taman 1, 12345, Kuala Lumpur'; ?></div>
                </Address>
            </div>

            </div>
                <div class="payment-method-title" style="margin-top: 20px;">Payment Method</div>
                <div class="payment-methods" style="margin-top: 0px;">
                    <div class="payment-method">
                        <div class="payment-method-image">
                            <img src="Payment/source/TNG.jpg" alt="E-Wallet Payment">
                        </div>
                        <div class="payment-method-name">
                            E-Wallet Payment
                        </div>
                    </div>
                </div>

                <div class="summary-total">
                <div class="total-title"> Total </div>
                <div class="total-value final-value" id="basket-total"> <?php echo $total; ?> </div>
                <div class="summary-checkout"><button class="checkout-cta" onclick="createOrder()">Checkout</button></div>
            </div>
        </div>
    </main>
</section>
<?php include('partials-front/footer.php'); ?>