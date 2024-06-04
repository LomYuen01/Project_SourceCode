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
<div>
    <?php

            $order_date = date('Y-m-d H:i:s'); 

        // Fetch the food_price and food_title from the tbl_food table
        $sql = "SELECT price, title FROM tbl_food WHERE id = $user_id";
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
        ?>
</div>