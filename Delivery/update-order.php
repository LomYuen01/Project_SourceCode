<?php 
    ob_start(); 
    include('../config/constant.php'); 
    include('Partials/login-check.php');

    if (isset($_GET['id'])) {
        $orderId = $_GET['id'];
    }

    // Fetch order, customer, and address details
    $stmt = $conn->prepare("
        SELECT o.*, c.full_name, c.email, c.ph_no, a.address, a.postal_code, a.city, a.state, a.country, o.order_status, o.order_time
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
    $order_status = $order['order_status'];
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
    
    // Calculate total price
    $totalPrice = 0;
    foreach ($orderItems as $item) {
        $totalPrice += $item['price'];
    }
?>

<!DOCTYPE html>
    <head>
        <!-----===============| CSS |===============----->
        <link rel="stylesheet" href="../Style/style-delivery.css">
    </head>

    <body>
        <section class="home" style="position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <form action="#" method="POST" class="order-container">
                <div>
                    <a href="javascript:history.back()"><img src="Icon/Back_Icon.png" class="icon" title="Back"></a>
                    <h1>Delivery Order Details</h1>
                    <div class="order-details">
                        <p><span class="details">Order ID:</span> <?php echo 'Order' . str_pad($id, 2, '0', STR_PAD_LEFT); ?></p>
                        <p><span class="details">Customer Name:</span> <?php echo $fullName; ?></p>
                        <p><span class="details">Phone Number:</span> <?php echo $phNo ?></p>
                        <p><span class="details">Delivery Address:</span> <?php echo $address . ", " . $postalCode . ", " . $city; ?></p>
                        <p><span class="details">Total Price:</span> RM <?php echo number_format($totalPrice, 2)?></p>
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
                </div>

                <div class="button" style="left: 0;">
                    <input type="submit" name="submit" value="Update Order" class="btn-secondary" style="width: 85%; font-size: 14px;">
                </div>
            </form>
        </section>
    </body>
</html>

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
            $_SESSION['add'] = "<div class='success success-text-shadow' style='color: white;'> Order Status Updated Successfully. </div>";
            header("location:".SITEURL.'delivery/order.php');
        }
        else
        {
            // Failed to Update Data
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='error error-text-shadow' style='color: white;'> Failed to Update Order Status. Try Again Later. </div>";

            // Redirect to Update Order Page
            header("location:".SITEURL.'delivery/order.php?id='.$order_id);
        }
    }
?>