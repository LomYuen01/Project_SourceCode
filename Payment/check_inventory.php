<?php

include('../config/constant.php'); 

// Fetch cart items from request
$cartItems = json_decode($_POST['cartItems'], true);

// Initialize response
$response = array('success' => false, 'message' => '');

// Get current timestamp
$currentTimestamp = date('Y-m-d H:i:s');

// Loop through each cart item to check inventory
foreach ($cartItems as $item) {
    $cartId = $item['cart_id'];
    $requestedQuantity = $item['quantity'];

    // Get the food item details and current quantity
    $sql = "SELECT tbl_cart_items.food_id, tbl_cart_items.size, tbl_cart_items.variation, tbl_food.quantity as food_quantity
            FROM tbl_cart_items
            INNER JOIN tbl_food ON tbl_cart_items.food_id = tbl_food.id
            WHERE tbl_cart_items.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $foodId = $row['food_id'];
        $foodQuantity = $row['food_quantity'];

        // Calculate reserved quantity from other users' checkout processes within the last 15 minutes
        $reservedQuantityQuery = "SELECT SUM(tbl_cart_items.quantity) as reserved_quantity
                                  FROM tbl_cart_items
                                  INNER JOIN tbl_checkout_verification ON tbl_cart_items.customer_id = tbl_checkout_verification.customer_id
                                  WHERE tbl_cart_items.food_id = ?
                                  AND tbl_checkout_verification.timestamp >= DATE_SUB(?, INTERVAL 15 MINUTE)";
        $stmt_reserved = $conn->prepare($reservedQuantityQuery);
        $stmt_reserved->bind_param("is", $foodId, $currentTimestamp);
        $stmt_reserved->execute();
        $reservedResult = $stmt_reserved->get_result();
        $reservedRow = $reservedResult->fetch_assoc();
        $reservedQuantity = $reservedRow['reserved_quantity'] ? $reservedRow['reserved_quantity'] : 0;

        // Check if the requested quantity is available
        if (($foodQuantity - $reservedQuantity) < $requestedQuantity) {
            $response['message'] = 'Insufficient stock for some items in your cart.';
            echo json_encode($response);
            exit;
        }
    } else {
        $response['message'] = 'Invalid cart item.';
        echo json_encode($response);
        exit;
    }
}

// If all items pass the check, set success to true
$response['success'] = true;
$response['message'] = 'Inventory check passed.';
echo json_encode($response);

include('partials/footer.php');

?>
