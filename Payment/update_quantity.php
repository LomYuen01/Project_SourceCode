<?php
include('../config/constant.php');

$user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : "";

if (isset($_POST['cart_items_id'], $_POST['change'])) {
    $cart_items_id = $_POST['cart_items_id'];
    $change = $_POST['change'];

    $sql_select_cart = "SELECT * FROM tbl_cart_items WHERE id='$cart_items_id' AND customer_id='$user_id'";
    $result_select_cart = mysqli_query($conn, $sql_select_cart);

    if (mysqli_num_rows($result_select_cart) == 1) {
        $row_cart = mysqli_fetch_assoc($result_select_cart);
        $current_quantity = $row_cart['quantity'];

        $new_quantity = $current_quantity + $change;

        if ($new_quantity > 10) {
            echo "Maximum quantity limit of 10 reached.";
            exit();
        }

        $sql_update_cart = "UPDATE tbl_cart_items SET quantity='$new_quantity' WHERE id='$cart_items_id' AND customer_id='$user_id'";
        $result_update_cart = mysqli_query($conn, $sql_update_cart);

        if ($result_update_cart) {
            echo $new_quantity;
            exit();
        } else {
            echo "<div class='error'>Failed to update quantity.</div>";
        }
    } else {
        echo "<div class='error'>Cart item not found.</div>";
    }
} else {
    echo "<div class='error'>Invalid request.</div>";
}

include('partials/footer.php');
?>