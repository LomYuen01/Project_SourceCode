<?php
//include('connection.php'); 

/*
session_start();
if (!isset($_SESSION['usern_id = 01'])) {
    
    header("Location: login.html");
    exit(); 
}



$sql = "SELECT * FROM tbl_order";
$result = $conn->query($sql);
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <style>
        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
</head>

<body>
    <h2 style="color: blue;">Purchase History</h2>
    <table style="width: 70%; margin: 0 auto;">
        <tr>
            <th>Purchase Date</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
        <?php
        
        $results_per_page = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $results_per_page;

        //$sql = "SELECT * FROM tbl_order LIMIT $start, $results_per_page"; 
        //$result = $conn->query($sql);
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
    <div style="width: 70%; margin:40px auto 0 auto;" >
        <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <a href="?page=<?php echo $page + 1; ?>">Next</a>
    </div>
</body>

</html>