<?php
include('../partials-front/menu.php');

// Temporary set user_id to 1
$user_id = 1;

// Check if cart_id is set and not empty
if (isset($_GET['cart_id']) && !empty($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];

    // Delete the item from the cart
    $sql_delete_cart = "DELETE FROM carts WHERE user_id='$user_id' AND cart_id='$cart_id'";
    $res_delete_cart = mysqli_query($conn, $sql_delete_cart);

    if ($res_delete_cart) {
        // Redirect to the user's cart page
        header("Location: cart.php");
        exit();
    } else {
        echo "<div class='error'>Failed to remove item from cart.</div>";
    }
} else {
    echo "<div class='error'>Invalid request.</div>";
}

include('partials-front/footer.php');
?>
