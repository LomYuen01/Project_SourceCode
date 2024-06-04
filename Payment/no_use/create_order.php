<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $food_title = $row['title'];

        // Insert the order details into the tbl_order table
        $sql = "INSERT INTO `tbl_order` (food_id, food_title, price, qty, total, order_date, user_id)
                VALUES ('$food_id', '$food_title', '$food_price', '$qty', '$finaltotal', '$order_date', '$user_id')";
        // Execute the SQL query here
    } else {
        // Handle the case where the food_id does not exist in the tbl_food table
    }
}
?>