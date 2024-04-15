<?php 
    include('../config/constant.php'); 

    // Temporary set user_id to 1
    $user_id = 1;

    // Check if food_id is set and not empty
    if (isset($_GET['food_id']) && !empty($_GET['food_id'])) {
        $food_id = $_GET['food_id'];

        // Fetch food details
        $sql_food = "SELECT * FROM tbl_food WHERE id=$food_id";
        $res_food = mysqli_query($conn, $sql_food);
        $count_food = mysqli_num_rows($res_food);

        if ($count_food == 1) {
            $row_food = mysqli_fetch_assoc($res_food);
            $food_title = $row_food['title'];
            $food_price = $row_food['normal_price'];

            // Check if the same food already exists in the cart
            $sql_check_cart = "SELECT * FROM carts WHERE user_id='$user_id' AND food_id='$food_id'";
            $res_check_cart = mysqli_query($conn, $sql_check_cart);
            $count_check_cart = mysqli_num_rows($res_check_cart);

            if ($count_check_cart > 0) {
                // If the same food already exists in the cart, update the quantity
                $row_check_cart = mysqli_fetch_assoc($res_check_cart);
                $current_quantity = $row_check_cart['quantity'];
                $new_quantity = $current_quantity + 1;

                $sql_update_cart = "UPDATE carts SET quantity='$new_quantity' WHERE user_id='$user_id' AND food_id='$food_id'";
                $res_update_cart = mysqli_query($conn, $sql_update_cart);

                if ($res_update_cart) 
                {
                    // Redirect to the user's cart page
                    header("Location: customer_menu.php");
                    exit();
                } 
                else 
                {
                    echo "<div class='error'>Failed to update cart.</div>";
                }
            } 
            else 
            {
                // If the same food doesn't exist in the cart, insert a new row
                $sql_insert_cart = "INSERT INTO carts (user_id, food_id, quantity) VALUES ('$user_id', '$food_id', '1')";
                $res_insert_cart = mysqli_query($conn, $sql_insert_cart);

                if ($res_insert_cart) {
                    // Redirect to the user's cart page
                    header("Location: cart.php");
                    exit();
                } 
                else 
                {
                    echo "<div class='error'>Failed to add item to cart.</div>";
                }
            }
        } 
        else 
        {
            echo "<div class='error'>Food not found.</div>";
        }
    } 
    else 
    {
        echo "<div class='error'>Invalid request.</div>";
    }
?>
