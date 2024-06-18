<?php
include('../config/constant.php'); 

$response = array('success' => false);

if (isset($_SESSION['user']['user_id']) && isset($_POST['food_id']) && isset($_POST['variation']) && isset($_POST['size']) && isset($_POST['price'])) {
    $user_id = $_SESSION['user']['user_id'];
    $food_id = $_POST['food_id'];
    $variation = $_POST['variation'];
    $size = $_POST['size'];
    $price = $_POST['price'];

    // Prepare statement
    $stmt = $conn->prepare("SELECT quantity FROM tbl_cart_items WHERE customer_id = ? AND food_id = ? AND variation = ? AND size = ?");
    $stmt->bind_param("iiss", $user_id, $food_id, $variation, $size);

    // Execute query
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($current_quantity);

    // Fetch value
    if ($stmt->fetch()) {
        // Item exists in the cart
        if ($current_quantity >= 10) {
            // Cannot add more of this item
            $response['message'] = 'You cannot add more of this item. Maximum quantity is 10.';
        } else {
            // Update quantity of this item
            $new_quantity = $current_quantity + 1;
            $stmt->close();
            $stmt = $conn->prepare("UPDATE tbl_cart_items SET quantity = ? WHERE customer_id = ? AND food_id = ? AND variation = ? AND size = ?");
            $stmt->bind_param("iiiss", $new_quantity, $user_id, $food_id, $variation, $size);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Quantity updated successfully. New quantity: ' . $new_quantity;
            } else {
                $response['message'] = 'Failed to update cart item.';
            }
        }
    } else {
        // Item does not exist in the cart, can add
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO tbl_cart_items (customer_id, food_id, variation, quantity, size, price) VALUES (?, ?, ?, 1, ?, ?)");
        $stmt->bind_param("iissd", $user_id, $food_id, $variation, $size, $price);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Item added to cart successfully.';
        } else {
            $response['message'] = 'Failed to add item to cart.';
        }
    }

    echo json_encode($response);
} else {
    $response['message'] = 'Invalid request.';
    echo json_encode($response);
}
?>
