<?php include('partials/menu.php');
    $user_id = 1; // Temporary user_id

    $sql = "SELECT carts.cart_id, carts.quantity, tbl_food.id as food_id, tbl_food.title, tbl_food.normal_price
            FROM carts
            INNER JOIN tbl_food ON carts.food_id = tbl_food.id
            WHERE carts.user_id = $user_id";
    $result = $conn->query($sql);

    $total = 0;
?>

<!-- Home -->
<section class="home"  style="padding-left: 10%; padding-right: 10%;">
    
    <!--===== Content =====-->
 
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
                    echo '<h2 style="font-size: 20px;">' . $row['title'] . '</h2>';
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
                <div class="subtotal-value final-value" id="basket-subtotal"><?php echo '<div class="subtotal">' . $total . '</div>';?></div>
                <div class="subtotal-title">Services Tax 6%</div>
                <?php $finaltotal = number_format($total * 1.06, 2); ?>
                
                <div class="subtotal-value final-value" id="basket-services-tax"><?php echo '<div class="subtotal">' . $finaltotal . '</div>';?></div>
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
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                    <input type="hidden" name="qty" value="<?php echo $quantity; ?>">
                    <input type="hidden" name="finaltotal" value="<?php echo $finaltotal; ?>">
                    <div class="summary-checkout">
                        <input type="submit" name="submit" value="Checkout" class="checkout-cta" style="border-radius:18px">
                    </div>
                </form>
        </div>
</section>

<?php include('partials/footer.php');?>

<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        
        $user_id = 1; // Temporary user_id
        $food_id = $_POST['food_id'];
        $qty = $_POST['qty'];
        $finaltotal = $_POST['finaltotal'];
        $order_date = date('Y-m-d H:i:s'); 

        // Fetch the food_price and food_title from the tbl_food table
        $sql = "SELECT price, title FROM tbl_food WHERE id = $food_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $food_price = $row['price'];
        $food_title = $row['title'];}

        $sql = "INSERT INTO tbl_order SET
        food = '$food_title',
        price = '$food_price', 
        qty = '$qty', 
        finaltotal = '$finaltotal', 
        order_date = '$order_date', 
        user_id = '$user_id,
        food_id = 'food_id'
        ";
 
        // 3. Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());
        
        header("location:".SITEURL.'Payment/history_order.php');
    }
?>