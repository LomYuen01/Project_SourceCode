<?php
include ('partials/menu.php');


if (!isset($_SESSION['user']['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['user_id'];
$special_instructions = isset($_SESSION['special_instructions']) ? $_SESSION['special_instructions'] : 'No special instructions provided';

if (empty($special_instructions) || $special_instructions == 'No special instructions provided') {
    header("Location: cart.php");
    exit;
}

// Generate a random verification code
$verification_code = rand(100000, 999999);
$_SESSION['verification_code'] = $verification_code;

// Delete the existing verification code for the user
$sql_delete = $conn->prepare("DELETE FROM tbl_checkout_verification WHERE customer_id = ?");
$sql_delete->bind_param("i", $user_id);
$sql_delete->execute();

// Insert the new verification code for the user
$sql_insert = $conn->prepare("INSERT INTO tbl_checkout_verification (customer_id, verification_code) VALUES (?, ?)");
$sql_insert->bind_param("ii", $user_id, $verification_code);
$sql_insert->execute();

// Fetch the cart items for the user
$sql_cart_items = $conn->prepare("SELECT id, food_id, variation, quantity, size FROM tbl_cart_items WHERE customer_id = ?");
$sql_cart_items->bind_param("i", $user_id);
$sql_cart_items->execute();
$result_cart_items = $sql_cart_items->get_result();

if ($result_cart_items->num_rows > 0) {
    while ($cart_item = $result_cart_items->fetch_assoc()) {
        $cart_item_id = $cart_item['id'];
        $food_id = $cart_item['food_id'];
        $size = $cart_item['size'];

        // Fetch the current price based on food_id and size
        $sql_food = $conn->prepare("SELECT normal_price, large_price FROM tbl_food WHERE id = ?");
        $sql_food->bind_param("i", $food_id);
        $sql_food->execute();
        $result_food = $sql_food->get_result();

        if ($result_food->num_rows > 0) {
            $food = $result_food->fetch_assoc();
            $price = ($size == 'Large') ? $food['large_price'] : $food['normal_price'];

            // Update the price in tbl_cart_items
            $sql_update_cart_item = $conn->prepare("UPDATE tbl_cart_items SET price = ? WHERE id = ?");
            $sql_update_cart_item->bind_param("di", $price, $cart_item_id);
            if (!$sql_update_cart_item->execute()) {
                echo "Error updating price: " . $conn->error;
            }
        }
    }
}

// Existing code to fetch saved addresses
$sql_fetch_addresses = $conn->prepare("SELECT * FROM tbl_customer_address WHERE customer_id = ? ORDER BY id DESC LIMIT 5");
$sql_fetch_addresses->bind_param("i", $user_id);
$sql_fetch_addresses->execute();
$result_addresses = $sql_fetch_addresses->get_result();
$saved_addresses = [];
if ($result_addresses->num_rows > 0) {
    while ($row = $result_addresses->fetch_assoc()) {
        $saved_addresses[] = $row;
    }
}

if (isset($_POST['order'])) {
    $submitted_code = $_SESSION['verification_code'];

    // Fetch the verification details
    $sql_check_verification = $conn->prepare("SELECT * FROM tbl_checkout_verification WHERE customer_id = ?");
    $sql_check_verification->bind_param("i", $user_id);
    $sql_check_verification->execute();
    $result_verification = $sql_check_verification->get_result();

    if ($result_verification->num_rows > 0) {
        $verification = $result_verification->fetch_assoc();
        $stored_code = $verification['verification_code'];
        $stored_timestamp = strtotime($verification['timestamp']);
        $current_time = time();

        if ($submitted_code != $stored_code) {
            echo "<script>alert('You have multiple checkout pages open. Please use the latest one.'); window.location.href='cart.php';</script>";
            exit;
        } elseif (($current_time - $stored_timestamp) > 900) { // 15 minutes
            echo "<script>alert('Your session has expired. Please try again.'); window.location.href='cart.php';</script>";
            exit;
        } else {
            $selected_payment_method = $_POST['payment_method']; 

            if ($selected_payment_method == 'COD') {
                $selected_payment_method = 'COD';
                $address_id = 1;
            } else {
                $selected_payment_method = 'CreditCard';
                $firstname = $_POST['firstname'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $zip = $_POST['zip'];


                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    echo "Invalid email format";
                    exit;
                }

                $cardname = isset($_POST['cardname']) ? $_POST['cardname'] : "";
                $cardnumber = isset($_POST['credit_card']) ? $_POST['credit_card'] : "";
                $expmonth = isset($_POST['expmonth']) ? $_POST['expmonth'] : "";
                $expyear = isset($_POST['expyear']) ? $_POST['expyear'] : "";
                $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : "";

                // Check if address already exists
                $sql_check_address = $conn->prepare("SELECT id FROM tbl_order_address WHERE firstname = ? AND email = ? AND phone = ? AND address = ? AND city = ? AND state = ? AND zip = ? AND customer_id = ?");
                $sql_check_address->bind_param("sssssssi", $firstname, $email, $phone, $address, $city, $state, $zip, $user_id);
                $sql_check_address->execute();
                $result_address = $sql_check_address->get_result();

                if ($result_address->num_rows > 0) {
                    $row_address = $result_address->fetch_assoc();
                    $address_id = $row_address['id'];
                } else {
                    // Insert into tbl_order_address
                    $sql_address = $conn->prepare("INSERT INTO tbl_order_address (firstname, email, address, city, phone, state, zip, customer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $sql_address->bind_param("sssssssi", $firstname, $email, $address, $city, $phone, $state, $zip, $user_id);

                    if ($sql_address->execute()) {
                        $address_id = $conn->insert_id; 
                    } else {
                        echo "Error: " . $sql_address->error;
                        exit;
                    }
                }
            }

            if (strtolower($selected_payment_method) == 'COD') {
                $paymethod_id = 1;
            } else {
                // Check if payment method already exists
                $sql_check_paymethod = $conn->prepare("SELECT id FROM tbl_customer_paymethod WHERE cardname = ? AND cardnumber = ? AND expmonth = ? AND expyear = ? AND cvv = ? AND customer_id = ?");
                $sql_check_paymethod->bind_param("sssssi", $cardname, $cardnumber, $expmonth, $expyear, $cvv, $user_id);
                $sql_check_paymethod->execute();
                $result_paymethod = $sql_check_paymethod->get_result();

                if ($result_paymethod->num_rows > 0) {
                    $row_paymethod = $result_paymethod->fetch_assoc();
                    $paymethod_id = $row_paymethod['id'];
                } else {
                    // Insert into tbl_customer_paymethod
                    $sql_paymethod = $conn->prepare("INSERT INTO tbl_customer_paymethod (cardname, cardnumber, expmonth, expyear, cvv, customer_id) VALUES (?, ?, ?, ?, ?, ?)");
                    $sql_paymethod->bind_param("sssssi", $cardname, $cardnumber, $expmonth, $expyear, $cvv, $user_id);

                    if ($sql_paymethod->execute()) {
                        $paymethod_id = $conn->insert_id; // Get the last inserted ID
                    } else {
                        echo "Error: " . $sql_paymethod->error;
                        exit;
                    }
                }
            }

            $current_day = date('l');
            $sql_limit = $conn->prepare("SELECT * FROM tbl_limit WHERE day = ?");
            $sql_limit->bind_param("s", $current_day);
            $sql_limit->execute();
            $result_limit = $sql_limit->get_result();
            $limit = $result_limit->fetch_assoc();
            $delivery_price = $limit['delivery_price'];

            // Insert into tbl_order
            $sql_order = $conn->prepare("INSERT INTO tbl_order (customer_id, address_id, pay_id, paymethod, special_instructions, order_status) VALUES (?, ?, ?, ?, ?, 'Pending')");
            $sql_order->bind_param("iiiss", $user_id, $address_id, $paymethod_id, $selected_payment_method, $special_instructions);

            if ($sql_order->execute()) {
                $order_id = $conn->insert_id;

                // Insert into tbl_order_items
                $sql_cart_items = $conn->prepare("SELECT * FROM tbl_cart_items WHERE customer_id = ?");
                $sql_cart_items->bind_param("i", $user_id);
                $sql_cart_items->execute();
                $result_cart_items = $sql_cart_items->get_result();

                while ($row_cart_item = $result_cart_items->fetch_assoc()) {
                    $cart_food_id = $row_cart_item['food_id'];
                    $cart_quantity = $row_cart_item['quantity'];
                    $cart_price = $row_cart_item['price'];
                    $cart_variation = $row_cart_item['variation'];
                    $cart_size = $row_cart_item['size'];

                    $sql_order_items = $conn->prepare("INSERT INTO tbl_order_items (order_id, food_id, quantity, price, variation_id, size) VALUES (?, ?, ?, ?, ?, ?)");
                    $sql_order_items->bind_param("iiidss", $order_id, $cart_food_id, $cart_quantity, $cart_price, $cart_variation, $cart_size);

                    if (!$sql_order_items->execute()) {
                        echo "Error: " . $sql_order_items->error;
                        exit;
                    }

                    // Update the food stock
                    $sql_food_stock = $conn->prepare("SELECT quantity FROM tbl_food WHERE id = ?");
                    $sql_food_stock->bind_param("i", $cart_food_id);
                    $sql_food_stock->execute();
                    $result_food_stock = $sql_food_stock->get_result();
                    $food_stock = $result_food_stock->fetch_assoc();
                    $new_stock = $food_stock['quantity'] - $cart_quantity;

                    $sql_update_stock = $conn->prepare("UPDATE tbl_food SET quantity = ? WHERE id = ?");
                    $sql_update_stock->bind_param("ii", $new_stock, $cart_food_id);
                    $sql_update_stock->execute();
                }

                // Clear the cart items for the user
                $sql_clear_cart = $conn->prepare("DELETE FROM tbl_cart_items WHERE customer_id = ?");
                $sql_clear_cart->bind_param("i", $user_id);
                $sql_clear_cart->execute();

                echo "<script>alert('Order placed successfully!'); window.location.href='customer_menu.php';</script>";
            } else {
                echo "Error: " . $sql_order->error;
                exit;
            }
        }
    }
}
?>
<style>
    .checkout-home {
        font-family: Arial;
        font-size: 17px;
    }

    * {
        box-sizing: border-box;
    }

    .row01 {
        display: -ms-flexbox;
        /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap;
        /* IE10 */
        flex-wrap: wrap;
        margin: 0 -16px;
    }

    .col-25 {
        -ms-flex: 25%;
        /* IE10 */
        flex: 25%;
    }

    .col-50 {
        -ms-flex: 50%;
        flex: 50%;
    }

    .col-75 {
        -ms-flex: 75%;
        flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
        padding: 0 16px;
    }

    .container {
        background-color: #f2f2f2;
        padding: 5px 20px 15px 20px;
        border: 1px solid lightgrey;
        border-radius: 3px;
        position: relative;
        display: flex;
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }

    input[type=text],
    input[type=tel] {
        width: 100%;
        margin-bottom: 20px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    label {
        margin-bottom: 10px;
        display: block;
    }

    .icon-container {
        padding: 7px 0;
        font-size: 24px;
    }

    .btn {
        background-color: #04AA6D;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
    }

    .btn:hover {
        background-color: #45a049;
    }

    a {
        color: #2196F3;
    }

    hr {
        border: 1px solid lightgrey;
    }

    span.price {
        float: right;
        color: grey;
    }

    .basket-product {
        border-top: 1px solid #cccccc;
        margin-top: -5px;
        background-color: #eee;
    }

    .basket-product2 {
        border-top: 1px solid #cccccc;
        border-bottom: 5px solid #ccc;
        margin-top: 0;
        background-color: #eee;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
        .row {
            flex-direction: column-reverse;
        }

        .col-25 {
            margin-bottom: 20px;
        }
    }

    .tab-container {

        background-color: #fff;
        margin: 0 auto;
        color: #000;
        font-size: 24px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    ul.tab-title {
        display: flex;
        align-items: center;
        border-bottom: 2px solid #ccc;
    }

    ul.tab-title li {
        list-style: none;
        line-height: 80px;
        padding: 0 40px;
        position: relative;
        cursor: pointer;
        transition: all .3s;
    }

    ul.tab-title li:hover,
    ul.tab-title li.active {
        color: red;
    }

    ul.tab-title li::before {
        content: '';
        display: block;
        width: 0;
        height: 4px;
        position: absolute;
        ;
        bottom: -2px;
        left: 50%;
        background-color: red;
        border-radius: 2px;
        transition: all .3s;
    }

    ul.tab-title li:hover:before,
    ul.tab-title li.active:before {
        width: 100%;
        left: 0;
    }

    .tab-panel {
        display: none;
        justify-content: center;
        align-items: center;
        font-size: 30px;
        color: #999;
    }

    .tab-panel.show {
        display: flex;
    }

    .swal-footer {
        text-align: center;
    }
</style>

<section class="home">
    <!--====== Forms ======-->
    <div class="form-container">
        <i class="fa-solid fa-xmark form-close"></i>

        <!-- Login Form -->
        <div class="form login-form">
            <form method="POST"onsubmit="return validateCreditCard()">
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
                    <a href=".../Email/forgot.php" class="forgot-password">Forgot password?</a>
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
<form action="" method="post" style="display: flex; flex-direction: row; width: 89%; padding-top: 15px; margin: auto;">
    <section class="checkout-home" style="width: 60%;">
        <h2 style="display: block; font-size: 24px; color: #000; font-weight: 600; margin-top: 20px; margin-bottom: 16px;">
            Checkout</h2>
        <div class="row" style="width: 100%;">
            <div class="col-75" style="margin-left: 16px; padding: 0;">
                <div class="container" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <div class="row">
                        <div class="col-50" style="padding-top: 15px;">
                            <h3>Address</h3>
                            <div class="addresssave">
                                <label for="saved_addresses">Select Saved Address</label>
                                <select id="saved_addresses" onchange="fillAddress()" style="margin-bottom: 15px;">
                                    <option value="">Select an address</option>
                                    <?php foreach ($saved_addresses as $address) { ?>
                                        <option value="<?php echo htmlspecialchars(json_encode($address)); ?>">
                                            <?php echo $address['name'] . ' - ' . $address['address']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- Existing form fields -->
                            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                            <input type="text" id="fname" name="firstname" placeholder="Aaa Bbbbb">
                            <label for="phone"><i class="fa fa-phone"></i> Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="0123456789">
                            <br>
                            <label for="email"><i class="fa fa-envelope"></i> Email</label>
                            <input type="text" id="email" name="email" placeholder="abc123@example.com">
                            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                            <input type="text" id="adr" name="address" placeholder="123, adc">
                            <label for="city"><i class="fa fa-institution"></i> Taman</label>
                            <input type="text" id="city" name="city" placeholder="Taman Kenanga Mewah">
                            <div style="margin-left: -15px; display: flex; flex-direction: row;">
                                <div class="col-50">
                                    <label for="zip">Postcode</label>
                                    <select id="zip" name="zip" required>
                                        <option value="">Select a postcode</option>
                                        <option value="75100">75100</option>
                                        <option value="75200">75200</option>
                                        <option value="75250">75250</option>
                                        <option value="75300">75300</option>
                                    </select>
                                </div>
                                <div class="col-50">
                                    <label for="state">State</label>
                                    <select id="state" name="state">
                                        <option value="Melaka">Melaka</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Existing payment section -->
                <div class="container" style="margin-top: 2%; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <div class="row">
                        <div class="col-50" style="padding-top: 15px;">
                            <h3>Payment</h3>

                            <div class="tab-container">
                                <ul class="tab-title">
                                    <li class="active" onclick="setPaymentMethod('CreditCard');">Credit Card</li>
                                    <li onclick="setPaymentMethod('COD');">Cash On Delivery</li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-panel show">
                                        <div style="display: flex; flex-direction:column;">
                                            <label for="fname" style="margin-top: 6px; margin-bottom: -6px;">Accepted Cards</label>
                                            <div class="icon-container">
                                                <i class="fa fa-cc-visa" style="color:navy;"></i>
                                                <i class="fa fa-cc-amex" style="color:blue;"></i>
                                                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                                                <i class="fa fa-cc-discover" style="color:orange;"></i>
                                            </div>
                                            <label for="cname">Name</label>
                                            <input type="text" id="cname" name="cardname" placeholder="Hooolely">
                                            <div style="display: block; width: 100%;">
                                                <label for="ccnum">Credit card number</label>
                                                <input type="tel" name="credit_card" id="credit_card_number"
                                                    placeholder="Card Number:" class="form-control"
                                                    onkeypress='return formats(this,event)'
                                                    onkeyup="numberValidation(event)">
                                            </div>

                                            <div style="display: block; width: 100%;">
                                                <label for="expmonth" style="display: block;">Exp Month</label>
                                                <input type="text" id="expmonth" name="expmonth" placeholder="September">
                                            </div>
                                            <div class="row01">
                                                <div class="col-50">
                                                    <label for="expyear">Exp Year</label>
                                                    <input type="text" id="expyear" name="expyear" placeholder="2018">
                                                </div>
                                                <div class="col-50">
                                                    <label for="cvv">CVV</label>
                                                    <input type="text" id="cvv" name="cvv" placeholder="352" minlength="3" maxlength="4">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-panel" style="padding: 50px;">
                                        <p>COD</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="payment_method" name="payment_method" value="CreditCard">
                <input type="submit" name="order" class="btn <?= ($total > 1) ? '' : 'disabled'; ?>" value="Place order"
                    style="border-radius: 18px; margin-top:5%; transition: .2s ease;">
            </div>
        </div>
    </section>

        <section style="margin-top: 5%; width: 40%; display: flex; flex-direction:column;">
            <div class="basket"
                style="width: 100%; margin-top: -8px; border: none;  box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.1); padding: 15px; border-radius: 18px; background-color: #ffffff;">
                <div class="basket-labels" style="background-color: #ffffff;">
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
                        <div class="basket-product" style="background-color: #ffffff;">
                            <ul>
                                <li class="food-checkbox"><?php echo $count; ?></li>
                                <li class="item">
                                    <div class="product-details">
                                        <h2 style="font-size: 20px;"><?php echo $row['title']; ?></h2>
                                        <div style="font-size: 1em;">Size: <?php echo $row['cart_size']; ?></div>
                                        <div style="font-size: 1em;">Variation: <?php echo $row['variation_name']; ?></div>
                                    </div>
                                </li>
                                <li class="price">RM <?php echo $price; ?></li>
                                <li class="quantity"><?php echo $row['cart_quantity']; ?></li>
                                <li class="subtotal">RM <?php echo $subtotal; ?></li>
                            </ul>
                        </div>
                        <?php
                        $count++;
                    }

                    $current_day = date('l');
                    $sql_limit = "SELECT * FROM tbl_limit WHERE day = '$current_day'";
                    $result_limit = $conn->query($sql_limit);
                    $limit = $result_limit->fetch_assoc();
                    $delivery_price = $limit['delivery_price'];
                    $total += $delivery_price;

                    ?>

                    <div class="basket-product basket-product2" style="background-color: #ffffff;">
                        <ul>
                            <li class="item" style="width: 90%;">
                                <div class="product-details">
                                    <div style="display: flex; justify-content: space-between; text-align: right;">
                                        <h2 style="font-size: 20px; font-weight: bold; width: 100%;">Delivery Fee</h2>
                                        <div class="total" style="font-weight: bold; width: 100%;">RM
                                            <?php echo $delivery_price; ?></div>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; text-align: right;">
                                        <h2 style="font-size: 20px; font-weight: bold; width: 100%;">Total</h2>
                                        <div class="total" style="font-weight: bold; width:100%;">RM <?php echo $total; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="item" style="width: 100%; margin-left: 10%;">
                        <div class="product-details">
                            <h2 style="font-size: 60px;">Your cart is empty</h2>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div
                style="margin-top: 50px; box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.1); padding: 15px; border-radius: 18px;">
                <h2 style="font-size: 24px; color: #000; font-weight: 600; margin-top: 20px; margin-bottom: 16px;">
                    Special Instructions</h2>
                <textarea name="special_instructions" id="special_instructions" cols="30" rows="10"
                    style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;"><?php echo $special_instructions; ?></textarea readonly>
            </div>
        </section>
    </form>
    <div id="timer"
        style="position: fixed; top: 10%; left: 50%; transform: translateX(-50%); color: green; font-size: 32px;"></div>
</section>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        function setPaymentMethod(method) {
            document.getElementById('payment_method').value = method;
        }

        let btns = document.querySelectorAll('.tab-title li');
        btns.forEach((item, i) => {
            item.onclick = function () {
                let activeBtn = document.querySelector('.tab-title li.active');
                activeBtn.classList.remove('active');
                this.classList.add('active');

                let showPanel = document.querySelector('.tab-content .tab-panel.show');
                showPanel.classList.remove('show');
                let panels = document.querySelectorAll('.tab-content .tab-panel');
                panels[i].classList.add('show');
            }
        });

        document.getElementById('phone').addEventListener('input', function (e) {
            const value = this.value.replace(/\D/g, '');
            if (value.length > 3 && (value.startsWith('010') || value.startsWith('011') || value.startsWith('012') || value.startsWith('013') || value.startsWith('014') || value.startsWith('016') || value.startsWith('017') || value.startsWith('018') || value.startsWith('019'))) {
                let formattedValue = value.match(/(\d{1,3})(\d{1,8})?/);
                if (formattedValue) {
                    this.value = formattedValue[1] + (formattedValue[2] ? '-' + formattedValue[2] : '');
                }
            } else {
                this.value = value.substring(0, 3);
            }
        });

        document.getElementById('phone').addEventListener('blur', function (e) {
            const value = this.value.replace(/\D/g, '');
            if (value.length < 10 || value.length > 11) {
                alert('Invalid phone number. Please enter a valid phone number.');
                this.value = '';
            }
        });

        document.getElementById('credit_card_number').addEventListener('keypress', function (e) {
            if (this.value.length < 19) {
                this.value = this.value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
            } else {
                e.preventDefault();
            }
        });

        document.getElementById('credit_card_number').addEventListener('keyup', function (e) {
            this.value = this.value.replace(/[^\d ]/g, '');
        });

        document.getElementById('cvv').addEventListener('input', function () {
            validateCreditCard();
        });

        function validateCreditCard() {
            let isValid = true;
            let cardName = document.getElementById('cname').value;
            let cardNumber = document.getElementById('credit_card_number').value;
            let expMonth = document.getElementById('expmonth').value;
            let expYear = document.getElementById('expyear').value;
            let cvv = document.getElementById('cvv').value;
            let errorMessages = [];

            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            if (!cardName) {
                isValid = false;
                errorMessages.push("Card name is required.");
            }

            if (!isValidCardNumber(cardNumber)) {
                isValid = false;
                errorMessages.push("Invalid card number.");
            }

            if (!isValidExpiry(expMonth, expYear)) {
                isValid = false;
                errorMessages.push("Invalid expiration date.");
            }

            if (!/^\d{3,4}$/.test(cvv)) {
                isValid = false;
                errorMessages.push("Invalid CVV.");
            }

            if (!isValid) {
                document.getElementById('error-messages').innerHTML = errorMessages.map(msg => `<p class="error">${msg}</p>`).join('');
            } else {
                document.getElementById('error-messages').innerHTML = '';
            }

            return isValid;
        }

        function isValidCardNumber(cardNumber) {
            let sum = 0;
            let shouldDouble = false;

            for (let i = cardNumber.length - 1; i >= 0; i--) {
                let digit = parseInt(cardNumber.charAt(i));

                if (shouldDouble) {
                    digit *= 2;
                    if (digit > 9) digit -= 9;
                }

                sum += digit;
                shouldDouble = !shouldDouble;
            }

            return (sum % 10) === 0;
        }

        function isValidExpiry(expMonth, expYear) {
            let currentDate = new Date();
            let inputDate = new Date(`${expYear}-${expMonth}-01`);

            return inputDate >= currentDate;
        }

        function fillAddress() {
            var select = document.getElementById('saved_addresses');
            var address = JSON.parse(select.value);
            if (address) {
                document.getElementById('fname').value = address.firstname;
                document.getElementById('phone').value = address.phone;
                document.getElementById('email').value = address.email || ''; 
                document.getElementById('adr').value = address.address;
                document.getElementById('city').value = address.city;
                document.getElementById('zip').value = address.postal_code;
                document.getElementById('state').value = address.state;
            }
        }

        var countDownDate = new Date().getTime() + 900000;
        var x = setInterval(function () {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";
            if (distance < 0) {
                clearInterval(x);
                alert("Your session has expired. Please try again.");
                window.location.href = 'cart.php';
            }
        }, 1000);
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../Style/form-login.js"></script>