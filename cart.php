<?php
include('partials-front/menu.php');

// Check if user is logged in
/*if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
*/
// Check if food_id is set and not empty
if (isset($_GET['food_id']) && !empty($_GET['food_id'])) {
    $food_id = $_GET['food_id'];
    //$user_id = $_SESSION['user_id'];

    // Fetch food details based on food_id
    $sql_food = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res_food = mysqli_query($conn, $sql_food);
    $count_food = mysqli_num_rows($res_food);

    $user_id = 1;

    if ($count_food == 1) {
        $row_food = mysqli_fetch_assoc($res_food);
        $food_title = $row_food['title'];
        $food_price = $row_food['normal_price'];

        // Insert into cart table
        $sql_insert_cart = "INSERT INTO carts (user_id, food_id, quantity) VALUES ('$user_id', '$food_id', '1')";
        $res_insert_cart = mysqli_query($conn, $sql_insert_cart);

        if ($res_insert_cart) {
            // Redirect to user's cart page
            header("Location: user_cart.php");
            exit();
        } else {
            echo "<div class='error'>Failed to add item to cart.</div>";
        }
    } else {
        echo "<div class='error'>Food not found.</div>";
    }
} else {
    echo "<div class='error'>Invalid request.</div>";
}

include('partials-front/footer.php');
?>
