<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header("Location: login.html");
    exit(); // Terminate further code execution
}

// Include database connection file here
include('connection.php');

// Get purchase history records for the user
$username = $_SESSION['username'];
$sql = "SELECT * FROM purchase_history WHERE username = '$username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
</head>

<body>
    <h2>Purchase History</h2>
    <table border="1">
        <tr>
            <th>Purchase Date</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['purchase_date'] . "</td>";
                echo "<td>" . $row['product_name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . ($row['price'] * $row['quantity']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No purchase history available</td></tr>";
        }
        ?>
    </table>
</body>

</html>

<?php
// Close database connection
$conn->close();
?>
