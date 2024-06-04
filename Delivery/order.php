<?php include('Partials/menu.php'); ?>
    <section class="home">
        <?php
            if(isset($_SESSION['add']))
            {
                echo "<br />" . nl2br($_SESSION['add']);
                unset($_SESSION['add']);
            }
        ?>

        <!-- Break --><br><!-- Line -->

        <div class="table" style="margin-top: 50px;">
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
                            <label><input type="checkbox" class="checkbox-column" data-column="3" checked/>&nbsp; Ph No. &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="4" checked/>&nbsp; Total Price &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="5" checked/>&nbsp; Order Status &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="6" checked/>&nbsp; Details &nbsp; </label>
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

            <section class="table-body" style="background: transparent;">
                <table>
                    <thead>
                        <tr>
                            <th style="padding-left: 3rem;"> <span class="cursor_pointer">Order ID<span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Customer Name<span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Ph No. <span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Total Price <span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Order Status <span class="icon-arrow"></span></span></th>
                            <th style="padding-right: 3rem;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $sql = "SELECT tbl_order.*, tbl_customer.full_name, tbl_customer.ph_no
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
                                    $customer_name = $row['full_name'];
                                    $ph_no = $row['ph_no'];
                                    $status = $row['order_status'];

                                    // Fetch the total price from the tbl_order_items table
                                    $sql2 = "SELECT price FROM tbl_order_items WHERE order_id = $id";
                                    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
                                    $total = 0;
                                    while($row2 = mysqli_fetch_assoc($res2))
                                    {
                                        $total += $row2['price'];
                                    }

                                    ?>
                                        <tr class="table-row">
                                            <td style="padding-left: 3rem;"><?php echo 'Order' . str_pad($id, 2, '0', STR_PAD_LEFT); ?></td>
                                            <td><?php echo $customer_name; ?></td>
                                            <td><?php echo $ph_no; ?></td>
                                            <td>RM <?php echo number_format($total, 2); ?></td>
                                            <td><div class="<?php echo strtolower($status); ?>" style="width: 150px;"><?php echo $status; ?></div></td>
                                            <td style="padding-right: 3rem;">
                                                <a href="<?php echo SITEURL; ?>delivery/update-order.php?id=<?php echo $id; ?>" style="width: 40px; font-size: 14px; text-decoration: none;" title="View Order">Details</a>
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