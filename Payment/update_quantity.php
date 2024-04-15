<?php
include('../partials-front/menu.php');

// 暂时设置 user_id 为 1
$user_id = 1;

// 检查是否设置 cart_id 和 change 参数
if (isset($_POST['cart_id'], $_POST['change'])) {
    $cart_id = $_POST['cart_id'];
    $change = $_POST['change'];

    // 查询购物车中对应的记录
    $sql_select_cart = "SELECT * FROM carts WHERE cart_id='$cart_id' AND user_id='$user_id'";
    $result_select_cart = mysqli_query($conn, $sql_select_cart);

    if (mysqli_num_rows($result_select_cart) == 1) {
        $row_cart = mysqli_fetch_assoc($result_select_cart);
        $current_quantity = $row_cart['quantity'];

        // 计算新的数量
        $new_quantity = $current_quantity + $change;

        // 更新购物车中的数量
        $sql_update_cart = "UPDATE carts SET quantity='$new_quantity' WHERE cart_id='$cart_id' AND user_id='$user_id'";
        $result_update_cart = mysqli_query($conn, $sql_update_cart);

        if ($result_update_cart) {
            // 返回更新后的数量
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

include('partials-front/footer.php');
?>
