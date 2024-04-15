<?php include('partials-front/menu.php'); ?>

<!-- Order History Section Starts Here -->
<section class="order-history"  style="box-shadow: rgba(0, 0, 0, 0.24) 20px 30px 80px; padding: 20px; width: 70%; border: 1px solid #0059ff; margin: 0 auto; border-radius:1cm">
    <div class="container">
        <h2 class="text-center">Order History</h2>

        <div class="order-table">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 20%; padding: 30px 0; text-align: center;">Order Number</th>
                        <th style="width: 20%; padding: 30px 0; text-align: center;">Order Date</th>
                        <th style="width: 20%; padding: 30px 0; text-align: center;">Total Amount</th>
                        <th style="width: 20%; padding: 30px 0; text-align: center;">Order Status</th>
                        <th style="width: 20%; padding: 30px 0; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        
                        $user_id = 1; 
                        
                        // SQL query to fetch user's order history
                        $sql = "SELECT * FROM tbl_order WHERE user_id = $user_id ORDER BY order_date DESC";
                        $res = mysqli_query($conn, $sql);

                        // Check if any orders found
                        if(mysqli_num_rows($res) > 0) {
                            // Loop through each order
                            while($row = mysqli_fetch_assoc($res)) {
                                // Extract order details
                                $order_id = $row['id'];
                                $order_date = $row['order_date'];
                                $total = $row['total'];
                                $status = $row['status'];
                                ?>

                                <!-- Display order details -->
                                <tr style=" box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.2); ">
                                    <td style="width: 20%; text-align: left;padding: 20px 0;"><?php echo $order_id; ?></td>
                                    <td style="width: 20%; text-align: left;padding: 20px 0;"><?php echo $order_date; ?></td>
                                    <td style="width: 20%; text-align: left;padding: 20px 0;">$<?php echo $total; ?></td>
                                    <td style="width: 20%; text-align: left;padding: 20px 0;"><?php echo $status; ?></td>
                                    <td style="width: 20%; text-align: center;padding: 20px 0;">
                                        <a href="#" class="btn btn-primary">Invoice</a>
                                        <a href="#" class="btn btn-success">Report</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        } else {
                            // No orders found
                            echo "<tr><td colspan='5' class='text-center'>No order history available.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>



<style>
    .order-history {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
