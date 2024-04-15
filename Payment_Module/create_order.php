<?php
include('partials-front/menu.php');

// Temporary set user_id to 1
$user_id = 1;

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve necessary data from session or form submission
    $food_id = $_POST['food_id'];
    $food_title = $_POST['food_title'];
    $food_price = $_POST['food_price'];
    $qty = $_POST['qty'];
    $total = $_POST['total'];
    $order_date = date("Y-m-d H:i:s"); // Current date and time
    $status = "Pending"; // Initial status
    $customer_name = $_POST['customer_name'];
    $customer_contact = $_POST['customer_contact'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];

    // Insert data into the order table
    $sql = "INSERT INTO `tbl_order` (food_id, food_title, price, qty, total, order_date, status, customer_name, customer_contact, customer_email, customer_address, user_id)
            VALUES ('$food_id', '$food_title', '$food_price', '$qty', '$total', '$order_date', '$status', '$customer_name', '$customer_contact', '$customer_email', '$customer_address', '$user_id')";

    // Execute the SQL query
    if (mysqli_query($conn, $sql)) {
        // Order created successfully
        echo "Order created successfully";
    } else {
        // Error occurred while creating the order
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    // Redirect or handle invalid requests
    echo "Invalid request method";
}

include('partials-front/footer.php');
?>
