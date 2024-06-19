<?php 
    ob_start(); 
    include('../config/constant.php'); 
    include('Partials/login-check.php');

    if (isset($_GET['id'])) {
        $orderId = $_GET['id'];
    } else {
        // Handle the case where no id is provided, perhaps redirect to another page
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
        $email = $order['customer_email']; // Use customer_email to avoid confusion
        $phNo = $order['phone']; // Changed from ph_no to phone
        $address = $order['address'];
        $postalCode = $order['zip'];
        $city = $order['city'];
        $state = $order['state'];
        $paymethod = $order['paymethod'];
        $order_status = $order['order_status'];
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

        // Calculate total price
        $totalPrice = 0;
        foreach ($orderItems as $item) {
            $totalPrice += $item['price'] * $item['quantity']; // Multiply the price by the quantity
        }
    } else {
        echo "Order not found!";
    }
?>

<!DOCTYPE html>
    <head>
        <title>Update Order Status</title>
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
                        <p><span class="details">Payment Method:</span> <?php echo $paymethod ?></p>
                        <p><span class="details">Total Price:</span> RM <?php echo number_format($totalPrice, 2)?></p>
                    </div>

                    <div class="dropdown2">
                        <div class="status" style="margin: 0; margin-top: 8px;">
                            <span class="details">Status</span>
                            <select name="status" style="font-size: 14px; font-weight: 500;">
                                <option value="out-for-delivery" <?php echo $order_status == 'out-for-delivery' ? 'selected' : ''; ?>>Out for delivery</option>
                                <option value="delivered" <?php echo $order_status == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Order Status Updated Successfully.',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."delivery/order.php';
                    }
                });
            </script>";
        }
        else
        {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to Update Order Status. Try Again Later.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."delivery/order.php?id=".$order_id."';
                    }
                });
            </script>";
        }
    }
?>