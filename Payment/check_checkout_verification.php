<?php 
    include('../config/constant.php'); 

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $timestamp = date('Y-m-d H:i:s', strtotime('-15 minutes'));

    // Fetch cart items and their quantities for the current user
    $sql_cart_current = "SELECT food_id, quantity FROM tbl_cart_items WHERE customer_id = $user_id";
    $result_cart_current = $conn->query($sql_cart_current);
    $current_cart_items = [];
    while ($row = $result_cart_current->fetch_assoc()) {
        $current_cart_items[] = $row;
    }

    // Fetch recent checkout verifications within the last 15 minutes
    $sql_verification = "SELECT customer_id FROM tbl_checkout_verification WHERE timestamp >= '$timestamp'";
    $result_verification = $conn->query($sql_verification);
    $verified_customers = [];

    if ($result_verification->num_rows > 0) {
        while ($row_verification = $result_verification->fetch_assoc()) {
            $verified_customers[] = $row_verification['customer_id'];
        }
    }

    // Fetch cart items and their quantities for verified customers
    if (!empty($verified_customers)) {
        $verified_customers_ids = implode(',', $verified_customers);
        $sql_cart_verified = "SELECT food_id, SUM(quantity) AS reserved_quantity 
                              FROM tbl_cart_items 
                              WHERE customer_id IN ($verified_customers_ids) 
                              GROUP BY food_id";
        $result_cart_verified = $conn->query($sql_cart_verified);
        $verified_cart_items = [];
        while ($row = $result_cart_verified->fetch_assoc()) {
            $verified_cart_items[$row['food_id']] = $row['reserved_quantity'];
        }
    } else {
        $verified_cart_items = [];
    }

    // Check inventory
    $all_quantities_valid = true;
    foreach ($current_cart_items as $item) {
        $food_id = $item['food_id'];
        $requested_quantity = $item['quantity'];

        // Fetch current stock
        $sql_stock = "SELECT quantity FROM tbl_food WHERE id = $food_id";
        $result_stock = $conn->query($sql_stock);
        $stock_row = $result_stock->fetch_assoc();
        $current_stock = $stock_row['quantity'];

        // Calculate reserved quantity by other users
        $reserved_quantity = isset($verified_cart_items[$food_id]) ? $verified_cart_items[$food_id] : 0;

        // Check if there is enough stock
        if ($current_stock - $reserved_quantity < $requested_quantity) {
            $all_quantities_valid = false;
            break;
        }
    }

    if ($all_quantities_valid) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'One or more items in your cart are out of stock.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
}
?>