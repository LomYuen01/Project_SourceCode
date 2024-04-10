<?php
include('partials-front/menu.php');

$user_id = 1; // Temporary user_id

$sql = "SELECT carts.cart_id, carts.quantity, tbl_food.id as food_id, tbl_food.title, tbl_food.normal_price
        FROM carts
        INNER JOIN tbl_food ON carts.food_id = tbl_food.id
        WHERE carts.user_id = $user_id";
$result = $conn->query($sql);

$total = 0;

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Payment/cart.css">
    <style>
        .quantitys {
            display: flex;
            justify-content: space-between;
            width: 70%;
        }
        .quantity-button {
            width: 15%;
            cursor: pointer;
        }
        .quantity-field {
            width: 70%;
            text-align: center;
        }
    </style>
    <title>Cart</title>
</head>

<body style="background-color: #ffffff;">
    <main>
        <div class="title">
            <h1>Cart</h1>
        </div>

        <div class="basket">
            <div class="basket-labels">
                <ul>
                    <li class="checkbox">No.</li>
                    <li class="item item-heading">Item</li>
                    <li class="price">Price</li>
                    <li class="quantity">Quantity</li>
                    <li class="subtotal">Subtotal</li>
                    <li class="remove">Remove</li>
                </ul>
            </div>

            <?php
            if ($result->num_rows > 0) {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="basket-product">';
                    echo '<div class="checkbox">' . $count . '</div>';
                    echo '<div class="item">';
                    echo '<div class="product-details">';
                    echo '<h2>' . $row['title'] . '</h2>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="price">' . $row['normal_price'] . '</div>';
                    echo '<div class="quantity">';
                    echo '<div class="quantitys">';
                    echo '<button class="quantity-button quantity-minus" onclick="updateQuantity(' . $row['cart_id'] . ', -1)">-</button>';
                    echo '<div class="quantity-field">' . $row['quantity'] . '</div>';
                    echo '<button class="quantity-button quantity-plus" onclick="updateQuantity(' . $row['cart_id'] . ', 1)">+</button>';
                    echo '</div>';
                    echo '</div>';
                    $subtotal = $row['normal_price'] * $row['quantity'];
                    echo '<div class="subtotal">' . $subtotal . '</div>';
                    $total += $subtotal;
                    echo '<div class="remove">';
                    echo '<button onclick="removeFromCart(' . $row['cart_id'] . ')">Remove</button>';
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
                            <img src="Payment/source/Bank.jpg" alt="Bank Payment">
                        </div>
                        <div class="payment-method-name">
                            <input type="radio" name="payment" value="bank">
                            Bank Payment
                        </div>
                    </div>

                    <div class="payment-method">
                        <div class="payment-method-image">
                            <img src="Payment/source/TNG.jpg" alt="E-Wallet Payment">
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
                    <button class="checkout-cta" onclick="redirectToCheckout()">Checkout</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function updateQuantity(cartId, change) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_quantity.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var quantityField = document.querySelector('.quantity-field');
                    var currentQuantity = parseInt(quantityField.textContent);
                    var newQuantity = currentQuantity + change;
                    if (newQuantity >= 1) {
                        quantityField.textContent = newQuantity;
                    }
                }
            };
            xhr.send("cart_id=" + cartId + "&change=" + change);
        }

        function removeFromCart(cart_id) {
            window.location.href = 'remove_from_cart.php?cart_id=' + cart_id;
        }

        function redirectToCheckout() {
        window.location.href = 'make_order.php';
        }
    </script>
</body>
