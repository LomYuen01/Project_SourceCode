<?php include('partials-front/menu.php'); ?>

<head>
    <title>Purchase History</title>
    <style>
        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
</head>

<body>
    <h2 style="color: blue; margin-left:20%;">Purchase History</h2>

    <section class="history" style="box-shadow: rgba(0, 0, 0, 0.24) 20px 30px 80px; padding: 20px; width: 70%; border: 1px solid #0059ff; margin: 0 auto; border-radius:1cm">
    <table style="width: 100%;">
        <tr style="box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.2); height:2cm">
            <th>Purchase Date</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
        
        <?php
        $sql = "SELECT * FROM tbl_order";
        $result = $conn->query($sql);
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
    </section>
    <div style="width: 70%; margin:40px auto 0 auto;" >
        <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <a href="?page=<?php echo $page + 1; ?>">Next</a>
    </div>
</body>
