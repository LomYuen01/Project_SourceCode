<?php include('Partials/menu.php'); ?>
    <section class="home">
        <div class="title">
            <div class="text">Manage Order</div>
        </div>

        <!-- Break --><br><!-- Line -->

        <div class="table">
            <section class="table-header">
                <div class="dropdown-toggle-column">
                    <div class="icon-border">
                        <i class='bx bx-cog select-icon'></i>
                        <span class="tooltip">Toggle Column</span>
                    </div>
                    
                    <ul class="menu-column" style="width: 200px; font-size: 12px;">
                        <li>
                            <label><input type="checkbox" class="checkbox-column" data-column="1" checked/>&nbsp; Order ID &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="2" checked/>&nbsp; Customer Name &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="3" checked/>&nbsp; Order Time &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="4" checked/>&nbsp; Delivery Time &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="5" checked/>&nbsp; Status &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="6" checked/>&nbsp; Total &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="7" checked/>&nbsp; Actions &nbsp; </label>
                        </li>
                    </ul>
                </div>

                <div class="input-group">
                    <input type="search" placeholder="Search Data...">
                    <i class='bx bx-search'></i>
                </div>

                <span></span>
                <span></span>
                <span></span>
            </section>

            <section class="table-body"style="height: 100%; box-shadow: -5px 0px 15px 2px rgba(0, 0, 0, 0.1);">
                <table>
                    <thead>
                        <tr>
                            <th> <span class="cursor_pointer">Order ID <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></span></th>
                            <th> <span class="cursor_pointer">Customer Name<span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Order time <span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Delivery time <span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Status <span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Total <span class="icon-arrow"></span></span></th>
                            <th style="padding-right: 4rem;"> <span class="cursor_pointer">Actions <span class="icon-arrow"></span></span></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $sql = "SELECT tbl_order.*, tbl_customer.full_name AS customer_name 
                            FROM tbl_order 
                            INNER JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.id
                            ORDER BY tbl_order.id ASC";
                            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                            // Count the rows
                            $count = mysqli_num_rows($res);

                            if($count > 0)
                            {
                                // We have data in database
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    $id = $row['id'];
                                    $customer_name = $row['customer_name'];
                                    $order_time = $row['order_time'];
                                    $delivery_time = $row['delivery_time'];
                                    $status = $row['order_status'];

                                    // Fetch the total price from the tbl_order_items table
                                    $sql2 = "SELECT price, quantity FROM tbl_order_items WHERE order_id = $id"; // Add quantity to the SELECT statement
                                    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
                                    $total = 0;
                                    while($row2 = mysqli_fetch_assoc($res2))
                                    {
                                        $total += $row2['price'] * $row2['quantity']; // Now you can use $row2['quantity']
                                    }

                                    ?>
                                        <tr class="table-row">
                                            <td><?php echo 'order' . str_pad($id, 2, '0', STR_PAD_LEFT); ?></td>
                                            <td><?php echo $customer_name; ?></td>
                                            <td><?php echo $order_time; ?></td>
                                            <td><?php echo $delivery_time; ?></td>
                                            <td><div class="<?php echo strtolower($status); ?>"><?php echo $status; ?></div></td>
                                            <td>RM <?php echo number_format($total, 2); ?></td>
                                            <td class="buttons" style="padding-right: 4rem;">
                                                <a href="<?php echo SITEURL; ?>admin/view-order.php?id=<?php echo $id; ?>" style="width: 40px; font-size: 14px;" class="btn-primary" title="View Order"><i class='bx bx-search-alt'></i></a>
                                                <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" style="width: 40px; font-size: 14px;" class="btn-secondary" title="Update Order"><i class='bx bxs-edit'></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                // We do not have data in database
                                echo "<tr> <td colspan='7'> <div class='error'> No Orders Found </div> </td> </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </section>
    <script>
        document.querySelectorAll(".dropdown-toggle-column").forEach(dropdown => {
            const select = dropdown.querySelector(".select-icon");
            const menu = dropdown.querySelector(".menu-column");

            select.addEventListener("click", () => {
                menu.classList.toggle("menu-open-column");

                // Add or remove the 'flex' display property
                if (menu.style.display !== 'flex') {
                    menu.style.display = 'flex';
                    // Scroll to the bottom of the dropdown
                    menu.lastElementChild.scrollIntoView(true);
                } else {
                    menu.style.display = '';
                }
            });
        });

        // Function to update column visibility
        function updateColumnVisibility(column, checked) {
            document.querySelectorAll('tr > :nth-child(' + column + ')').forEach(function(cell) {
                if (checked) {
                    cell.classList.remove('hidden-column');
                } else {
                    cell.classList.add('hidden-column');
                }
            });
        }

        // Code for hiding and showing columns
        document.querySelectorAll('.checkbox-column').forEach(function(checkbox) {
            var column = checkbox.dataset.column;

            // Add the 'hidden-column' class to the cells in this column
            document.querySelectorAll('tr > :nth-child(' + column + ')').forEach(function(cell) {
                cell.classList.add('hidden-column');
            });

            // Get the page name
            var pageName = window.location.pathname.split("/").pop();

            // Load the saved state from localStorage
            var savedState = localStorage.getItem(pageName + '-checkbox-column-' + column);
            if (savedState !== null) {
                checkbox.checked = savedState === 'true';
            }

            // Update column visibility based on checkbox state
            updateColumnVisibility(column, checkbox.checked);

            checkbox.addEventListener('change', function() {
                var checked = this.checked;

                // Save the state to localStorage
                localStorage.setItem(pageName + '-checkbox-column-' + column, checked);

                // Update column visibility based on checkbox state
                updateColumnVisibility(column, checked);
            });
        });

        // Show the content once the state has been loaded
        document.body.style.display = '';
    </script>
<?php include('Partials/footer.php'); ?>