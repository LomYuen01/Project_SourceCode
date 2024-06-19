<?php 
    include('Partials/menu.php'); 

    if (isset($_GET['id'])) {
        $orderId = $_GET['id'];
    } else {
        header("Location: manage-order.php");
        exit;
    }

    // Fetch order, customer, and address details
    $stmt = $conn->prepare("
        SELECT o.*, c.full_name, c.email AS customer_email, a.firstname, a.phone, a.address, a.zip, a.city, a.state
        FROM tbl_order o
        JOIN tbl_customer c ON o.customer_id = c.id
        JOIN tbl_order_address a ON o.address_id = a.id
        WHERE o.id = ?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if ($order) {
        $id = $order['id'];
        $fullName = $order['firstname']; // Changed from full_name to firstname
        $order_time = $order['order_time']; // Added order_time
        $order_status = $order['order_status']; // Added order_status
        $email = $order['customer_email']; // Use customer_email to avoid confusion
        $phNo = $order['phone']; // Changed from ph_no to phone
        $address = $order['address'];
        $zip = $order['zip'];
        $city = $order['city'];
        $state = $order['state'];
        $paymethod = $order['paymethod'];
        // Assuming special_instructions is part of the tbl_order
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
    } else {
        echo "Order not found!";
    }
?>

<section class="home" style="overflow: hidden;">
    <div class="title">
        <div class="text">Update Order Status</div>
    </div>

    <!-- Break --><br><!-- Line -->

    <div class="table" style="padding-left: 25px;">
        <form action="" method="POST" style="width: 40%">
            <div class="delivery-container" data-title="Delivery Details" style="width: 100%;">
                <div class="delivery-details">
                    <div class="input-box">
                        <span class="details readonly-color">Customer Name</span>
                        <input class="readonly-color" type="text" name="title" value="<?php echo $fullName ?>" readonly>
                    </div>

                    <div class="input-box">
                        <span class="details readonly-color">Order Time</span>
                        <input class="readonly-color" type="text" name="title" value="<?php echo $order_time ?>" readonly>
                    </div>

                    <div class="dropdown2">
                        <div class="status" style="margin: 0; margin-top: 8px;">
                            <span class="details">Status</span>
                            <select name="status" style="font-size: 14px; font-weight: 500;">
                                <option value="pending" <?php echo $order_status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="preparing" <?php echo $order_status == 'preparing' ? 'selected' : ''; ?>>Preparing</option>
                                <option value="out-for-delivery" <?php echo $order_status == 'out-for-delivery' ? 'selected' : ''; ?>>Out for delivery</option>
                                <option value="delivered" <?php echo $order_status == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="cancelled" <?php echo $order_status == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                <option value="on-hold" <?php echo $order_status == 'on-hold' ? 'selected' : ''; ?>>On hold</option>
                            </select>
                        </div>
                    </div>

                    <div class="button" style="left: 0; padding-bottom: 0">
                        <input type="submit" name="submit" value="Update Status" class="btn-secondary">
                    </div>
                </div>
            </div>
        </form>

        <div class="order-container" data-title="Order Details">
            <div class="item-details" style="height: 1200%;"> <!-- Fixed Size, Scrollable -->
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
                            $totalPrice += $price * $quantity; 

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
            </div>
        </div>
    </div>
</section>
<?php include('Partials/footer.php'); ?>

<?php
    if(isset($_POST['submit']))
    {
        // Get the data from Form
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // SQL Query to update the order status in tbl_order
        $sql_order = "UPDATE tbl_order SET
            order_status = '$status'
            WHERE id = $orderId
        ";

        // Executing Query and Updating Data in tbl_order
        $res_order = mysqli_query($conn, $sql_order) or die(mysqli_error());

        // Check whether the (Query is executed) data is updated or not
        if($res_order==TRUE)
        {
            // Data Updated
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Order Status Updated Successfully.',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."admin/manage-order.php';
                        }
                    });
                </script>";
        }
        else
        {
            // Failed to Update Data
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to Update Order Status. Try Again Later.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."admin/update-order.php?id='.$order_id';
                    }
                });
            </script>";
        }
    }
?>