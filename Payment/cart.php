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

        </div>
    </main>
</body>

</html>

<?php

$conn->close();
?>
