<?php
include('connection.php'); 


session_start();
if (!isset($_SESSION['username_id'])) {
    
    header("Location: login.html");
    exit(); 
}


$sql = "SELECT * FROM cart_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="cart.css">
    <title>Cart</title>
</head>

<body>
    <main>
        <div class="title">
            <h1>Payment</h1>
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
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="basket-product">';
                    echo '<div class="checkbox">' . $row['id'] . '</div>';
                    echo '<div class="item">';
                    echo '<div class="product-details">';
                    echo '<h2>' . $row['product_name'] . '</h2>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="price">' . $row['price'] . '</div>';
                    echo '<div class="quantity">';
                    echo '<div class="quantity-field">' . $row['quantity'] . '</div>';
                    echo '</div>';
                    echo '<div class="subtotal">' . ($row['price'] * $row['quantity']) . '</div>';
                    echo '</div>';
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
                        <label for="option2">Self Collection</label>
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
                            <img src="source/bankpay.png" alt="Bank Payment">
                        </div>
                        <div class="payment-method-name">
                            <input type="radio" name="payment" value="bank">
                            Bank Payment
                        </div>
                    </div>

                    <div class="payment-method">
                        <div class="payment-method-image">
                            <img src="source/visa.png" alt="Visa Payment">
                        </div>
                        <div class="payment-method-name">
                            <input type="radio" name="payment" value="visa">
                            Visa Payment
                        </div>
                    </div>

                    <div class="payment-method">
                        <div class="payment-method-image">
                            <img src="source/ewallet.png" alt="E-Wallet Payment">
                        </div>
                        <div class="payment-method-name">
                            <input type="radio" name="payment" value="e-wallet">
                            E-Wallet Payment
                        </div>
                    </div>


                </div>


                <div class="summary-total">
                    <div class="total-title">Total</div>
                    <div class="total-value final-value" id="basket-total">00.00</div>
                </div>
                <div class="summary-checkout">
                    <button class="checkout-cta">Checkout</button>
                </div>
            </div>

        </div>

    </main>
</body>

</html>

<?php

$conn->close();
?>
