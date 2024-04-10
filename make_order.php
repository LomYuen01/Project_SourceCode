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
    <title>Make Orders</title>
</head>

<body style="background-color: #ffffff;">
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
                    echo '<div class="quantity">' . $row['quantity'] . '</div>';
                    $subtotal = $row['normal_price'] * $row['quantity'];
                    echo '<div class="subtotal">' . $subtotal . '</div>';
                    $total += $subtotal;
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
                        <div class="shopping-option">
                            Delivery
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
                    <div class="total-title">
                        Total
                    </div>
                    <div class="total-value final-value" id="basket-total">
                        <?php echo $total; ?>
                    </div>
                    </div>
                    <div class="summary-checkout">
                        <button class="checkout-cta" onclick="createOrder()">Checkout</button>
                    </div>

                </div>

            </div>
                
            </div>
        </div>
    </main>
</body>
<script>

</script>

</html>
