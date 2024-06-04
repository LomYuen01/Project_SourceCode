<?php include('partials/menu.php');
?>
    <section class="home" style="width: 80%; margin:auto">
        <div class="title">
            <h1>Cart</h1>
        </div>

        <div class="basket" >
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
            $user_id = 1;
            /*
            $sql = "SELECT tbl_cart_items.*, tbl_food.*, tbl_food_variation.*
                        FROM tbl_cart_items
                        INNER JOIN tbl_food ON tbl_cart_items.food_id = tbl_food.id
                        INNER JOIN tbl_food_variation ON tbl_cart_items.variation = tbl_food_variation.id
                        WHERE tbl_cart_items.customer_id = $user_id";
            $result = $conn->query($sql);
            */

            $total = 0;
            
            $sql = "SELECT tbl_cart_items.id as cart_items_id, tbl_cart_items.quantity as cart_quantity, tbl_cart_items.size as cart_size, tbl_food.title, tbl_food.normal_price, tbl_food.large_price, tbl_food_variation.name as variation_name
                    FROM tbl_cart_items
                    INNER JOIN tbl_food ON tbl_cart_items.food_id = tbl_food.id
                    LEFT JOIN tbl_food_variation ON tbl_cart_items.variation = tbl_food_variation.id
                    WHERE tbl_cart_items.customer_id = $user_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="basket-product">';
                    echo '<div class="checkbox">' . $count . '</div>';
                    echo '<div class="item">';
                    echo '<div class="product-details">';
                    echo '<h2 style="font-size: 1em;">' . $row['title'] . '</h2>';
                    echo '<div style="background-color: #6B7A8F; border: 1px solid blank; border-radius: 5px; width: 40%;">';
                    echo '<div style="font-size: 1em;">Size: ' . $row['cart_size'] . '</div>';
                    echo '<div style="font-size: 1em;">Variation: ' . $row['variation_name'] . '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $price = $row['cart_size'] == 'Large' ? $row['large_price'] : $row['normal_price'];
                    echo '<div class="price">' . $price . '</div>';
                    echo '<div class="quantity">';
                    echo '<div class="quantitys">';
                    echo '<button class="quantity-button quantity-minus" onclick="updateQuantity(' . $row['cart_items_id'] . ', -1)">-</button>';
                    echo '<div class="quantity-field" style="font-size: 1em;" data-cart-id="' . $row['cart_items_id'] . '">' . $row['cart_quantity'] . '</div>';
                    echo '<button class="quantity-button quantity-plus" onclick="updateQuantity(' . $row['cart_items_id'] . ', 1)">+</button>';
                    echo '</div>';
                    echo '</div>';
                    $subtotal = $price * $row['cart_quantity'];
                    echo '<div class="subtotal">' . $subtotal . '</div>';
                    $total += $subtotal;
                    echo '<div class="remove" style:"border: 0; color:var(--sk-body-link-color,#06c)">';
                    echo '<button onclick="removeFromCart(' . $row['cart_items_id'] . ')">Remove</button>';
                    echo '</div>';
                    echo '</div>';
                    $count++;
                }
            
            
                
            } else {
                echo '<div class="item" style="width: 100%; margin-left: 10%;">';
                echo '<div class="product-details">';
                echo '<h2 style="font-size: 60px;">Your cart is empty</h2>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>

            <div class="summary" style="width: 20%;">
                <div class="summary-total-items"><span class="total-items"></span>Payment</div>

                <div class="shopping-option-title">Shopping Option</div>
                <div class="shopping-options">
                    <div class="shopping-option">
                        <input type="radio" name="shopping-option" id="option2" value="selfcollection">
                        <label for="option2">Delivery</label>
                    </div>
                    <div class="shopping-option">
                        <input type="radio" name="shopping-option" id="option3" value="expressdelivery">
                        <label for="option3">Dine In</label>
                    </div>
                </div>

                <div class="payment-method-title">Payment Method</div>
                <div class="payment-methods">
                    <div class="payment-method">
                        <div class="payment-method-image">
                            <img src="img/Bank.jpg" alt="Bank Payment">
                        </div>
                        <div class="payment-method-name">
                            <input type="radio" name="payment" value="bank">
                            Bank Payment
                        </div>
                    </div>

                    <div class="payment-method">
                        <div class="payment-method-image">
                            <img src="img/TNG.jpg" alt="E-Wallet Payment">
                        </div>
                        <div class="payment-method-name">
                            <input type="radio" name="payment" value="e-wallet">
                            E-Wallet Payment
                        </div>
                    </div>
                </div>

                <div class="summary-total">
                    <div class="total-title">Total</div>
                    <div class="total-value final-value" id="basket-total"><?php echo $total; ?></div>
                </div>
                <div class="summary-checkout">
                    <button class="checkout-cta" style="background-color: rgb(106, 212, 125);border-radius: 18px;" onclick="redirectToCheckout()">Checkout</button>
                </div>
            </div>
        </div>
    </section>

    <script>
        function updateQuantity(cart_items_id, change) {
            var quantityField = document.querySelector('.quantity-field[data-cart-id="' + cart_items_id + '"]');
            var currentQuantity = parseInt(quantityField.textContent);
            var newQuantity = currentQuantity + change;

            if (newQuantity < 1) {
                alert("Minimum quantity limit of 1 reached.");
                return;
            }

            if (newQuantity > 10) {
                alert("Maximum quantity limit of 10 reached.");
                return;
            }

            var xhr = new XMLHttpRequest();
            
            xhr.open("POST", "update_quantity.php", true);
            
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    setTimeout(function() {
                        
                        window.location.reload();
                    }, 300);
                }
            };

            xhr.send("cart_items_id=" + cart_items_id + "&change=" + change);
        }

        function removeFromCart(cart_items_id) {
            window.location.href = 'remove_from_cart.php?cart_items_id=' + cart_items_id;
        }

        function redirectToCheckout() {
        window.location.href = 'checkout.php';
        }
    </script>

<?php include('partials/footer.php');