<?php 
    include('Partials/menu.php'); 

    if (isset($_GET['id'])) {
        $orderId = $_GET['id'];
    } else {
        // Handle the case where no id is provided, perhaps redirect to another page
    }

    // Fetch order, customer, and address details
    $stmt = $conn->prepare("
        SELECT o.*, c.full_name, c.email, c.ph_no, a.address, a.postal_code, a.city, a.state, a.country
        FROM tbl_order o
        JOIN tbl_customer c ON o.customer_id = c.id
        JOIN tbl_address a ON o.address_id = a.id
        WHERE o.id = ?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    $id = $order['id'];
    $fullName = $order['full_name'];
    $email = $order['email'];
    $phNo = $order['ph_no'];
    $address = $order['address'];
    $postalCode = $order['postal_code'];
    $city = $order['city'];
    $state = $order['state'];
    $country = $order['country'];
    $special_instructions = $order['special_instructions'];

    // Fetch order items and food details
    $stmt = $conn->prepare("
        SELECT oi.*, f.title
        FROM tbl_order_items oi
        JOIN tbl_food f ON oi.food_id = f.id
        WHERE oi.order_id = ?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderItems = $result->fetch_all(MYSQLI_ASSOC);
?>

<section class="home">
    <div class="title">
        <div class="text">View Orders</div>
    </div>

    <!-- Break --><br><!-- Line -->

    <div class="table" style="padding-left: 25px;">
        <div class="delivery-container" data-title="Delivery Details">
            <div class="delivery-details">
                <div class="input-box">
                    <span class="details readonly-color">Name</span>
                    <input class="readonly-color" type="text" name="title" value="<?php echo $fullName ?>" readonly>
                </div>

                <div class="input-box">
                    <span class="details readonly-color">Email</span>
                    <input class="readonly-color" type="text" name="title" value="<?php echo $email ?>" readonly>
                </div>

                <div class="input-box">
                    <span class="details readonly-color">Ph No.</span>
                    <input class="readonly-color" type="text" name="title" value="<?php echo $phNo ?>" readonly>
                </div>

                <div class="input-box">
                    <span class="details readonly-color">Address</span>
                    <input class="readonly-color" type="text" name="title" value="<?php echo $address ?>" readonly>
                </div>

                <div class="input-box">
                    <span class="details readonly-color">Postal Code</span>
                    <input class="readonly-color" type="text" name="title" value="<?php echo $postalCode ?>" readonly>
                </div>

                <div class="input-box">
                    <span class="details readonly-color">City</span>
                    <input class="readonly-color" type="text" name="title" value="<?php echo $city ?>" readonly>
                </div>

                <div class="input-box">
                    <span class="details readonly-color">State</span>
                    <input class="readonly-color" type="text" name="title" value="<?php echo $state ?>" readonly>
                </div>

                <div class="input-box">
                    <span class="details readonly-color">Country</span>
                    <input class="readonly-color" type="text" name="title" value="<?php echo $country ?>" readonly>
                </div>
            </div>
        </div>

        <div class="order-container" data-title="Order Details">
            <div class="item-details"> <!-- Fixed Size, Scrollable -->
                <table>
                    <thead>
                        <tr>
                            <th><span class="cursor_pointer">Product<span class="icon-arrow"></span></span></th>
                            <th><span class="cursor_pointer">Price<span class="icon-arrow"></span></span></th>
                            <th><span class="cursor_pointer">Quantity<span class="icon-arrow"></span></span></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $totalPrice = 0;
                        foreach ($orderItems as $item) {
                            $itemId = $item['food_id']; // Use 'food_id' instead of 'id'
                            $title = $item['title'];
                            $price = $item['price'];
                            $quantity = $item['quantity'];
                            $totalPrice += $price; // Just add the price without considering the quantity

                            // Fetch the image name from the tbl_food table
                            $sql = "SELECT image_name FROM tbl_food WHERE id = $itemId";
                            $res = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($res);
                            $image_name = $row ? $row['image_name'] : 'default_image.jpg'; // Use a default image if $row is null
                        ?>
                            <tr>
                                <td><img src="../images/Food/<?php echo $image_name; ?>" alt="" style="width: 42px; height: 42px;"><?php echo $title; ?></td>
                                <td>RM <?php echo number_format($price, 2); ?></td>
                                <td><?php echo $quantity; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="order-summary"> <!-- Below item-details, scroll based on order-container -->
                <div class="total-price">
                    <span>Total Price:</span>
                    <span>RM <?php echo number_format($totalPrice, 2); ?></span>
                </div>

                <div class="input-box">
                    <span class="details readonly-color">Special Instructions</span>
                    <input class="readonly-color" type="text" name="title" value="<?php echo $special_instructions ?>" readonly>
                </div>

                <div style="position: relative; display: flex; flex-wrap: wrap; justify-content: space-between;">
                    <div class="input-box" style="width: 48%;">
                        <span class="details readonly-color">Payment Method</span>
                        <input class="readonly-color" type="text" name="title" value="COD" readonly>
                    </div>

                    <div class="input-box" style="width: 48%;">
                        <span class="details readonly-color">Order Status</span>
                        <input class="readonly-color" type="text" name="title" value="<?php echo $order['order_status']; ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('Partials/footer.php'); ?>